<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends BaseController
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product']);

        // Filter by user (for regular users, only show their orders)
        if (!$request->user()->isAdmin()) {
            $query->where('user_id', $request->user()->id);
        } elseif ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->has('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $orders = $query->paginate($request->get('per_page', 15));

        return $this->sendPaginatedResponse($orders, 'Orders retrieved successfully');
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'billing_address' => 'required|array',
            'billing_address.name' => 'required|string',
            'billing_address.address' => 'required|string',
            'billing_address.city' => 'required|string',
            'billing_address.state' => 'required|string',
            'billing_address.zip' => 'required|string',
            'billing_address.country' => 'required|string',
            'shipping_address' => 'required|array',
            'shipping_address.name' => 'required|string',
            'shipping_address.address' => 'required|string',
            'shipping_address.city' => 'required|string',
            'shipping_address.state' => 'required|string',
            'shipping_address.zip' => 'required|string',
            'shipping_address.country' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = 0;
            $orderItems = [];

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                
                if (!$product || !$product->is_active) {
                    throw new \Exception("Product {$product->name} is not available");
                }

                if (!$product->isInStock() || ($product->manage_stock && $product->stock_quantity < $item['quantity'])) {
                    throw new \Exception("Insufficient stock for product {$product->name}");
                }

                $price = $product->getCurrentPrice();
                $total = $price * $item['quantity'];
                $subtotal += $total;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $price,
                    'total' => $total,
                ];

                // Update stock if managed
                if ($product->manage_stock) {
                    $product->decrement('stock_quantity', $item['quantity']);
                    if ($product->stock_quantity <= 0) {
                        $product->update(['stock_status' => 'out_of_stock']);
                    }
                }
            }

            $shippingAmount = 10.00; // Fixed shipping for now
            $taxAmount = $subtotal * 0.08; // 8% tax
            $totalAmount = $subtotal + $shippingAmount + $taxAmount;

            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $request->user()->id,
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'shipping_amount' => $shippingAmount,
                'tax_amount' => $taxAmount,
                'billing_address' => $request->billing_address,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                OrderItem::create(array_merge($item, ['order_id' => $order->id]));
            }

            DB::commit();

            $order->load(['orderItems.product', 'user']);

            return $this->sendResponse($order, 'Order created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage(), [], 422);
        }
    }

    /**
     * Display the specified order.
     */
    public function show(Request $request, $id)
    {
        $query = Order::with(['orderItems.product', 'user']);

        // Regular users can only view their own orders
        if (!$request->user()->isAdmin()) {
            $query->where('user_id', $request->user()->id);
        }

        $order = $query->find($id);

        if (!$order) {
            return $this->sendError('Order not found');
        }

        return $this->sendResponse($order, 'Order retrieved successfully');
    }

    /**
     * Update the specified order.
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return $this->sendError('Order not found');
        }

        // Regular users cannot update orders
        if (!$request->user()->isAdmin()) {
            return $this->sendError('Unauthorized', [], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'sometimes|required|in:pending,processing,shipped,delivered,cancelled',
            'notes' => 'nullable|string',
            'shipped_at' => 'nullable|date',
            'delivered_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $data = $request->only(['status', 'notes', 'shipped_at', 'delivered_at']);

        // Auto-set timestamps based on status
        if ($request->status === 'shipped' && !$order->shipped_at) {
            $data['shipped_at'] = now();
        }
        if ($request->status === 'delivered' && !$order->delivered_at) {
            $data['delivered_at'] = now();
        }

        $order->update($data);
        $order->load(['orderItems.product', 'user']);

        return $this->sendResponse($order, 'Order updated successfully');
    }

    /**
     * Cancel an order.
     */
    public function cancel(Request $request, $id)
    {
        $query = Order::query();

        // Regular users can only cancel their own orders
        if (!$request->user()->isAdmin()) {
            $query->where('user_id', $request->user()->id);
        }

        $order = $query->find($id);

        if (!$order) {
            return $this->sendError('Order not found');
        }

        if (!$order->canBeCancelled()) {
            return $this->sendError('Order cannot be cancelled', [], 422);
        }

        try {
            DB::beginTransaction();

            // Restore stock for cancelled order
            foreach ($order->orderItems as $item) {
                if ($item->product->manage_stock) {
                    $item->product->increment('stock_quantity', $item->quantity);
                    if ($item->product->stock_quantity > 0) {
                        $item->product->update(['stock_status' => 'in_stock']);
                    }
                }
            }

            $order->update(['status' => 'cancelled']);

            DB::commit();

            $order->load(['orderItems.product', 'user']);

            return $this->sendResponse($order, 'Order cancelled successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Failed to cancel order', [], 500);
        }
    }

    /**
     * Get order statistics (admin only).
     */
    public function statistics(Request $request)
    {
        if (!$request->user()->isAdmin()) {
            return $this->sendError('Unauthorized', [], 403);
        }

        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::whereIn('status', ['delivered'])->sum('total_amount'),
            'recent_orders' => Order::recent(7)->count(),
        ];

        return $this->sendResponse($stats, 'Order statistics retrieved successfully');
    }
}