<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends BaseController
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filter by active status
        if ($request->has('active')) {
            $query->where('is_active', $request->boolean('active'));
        }

        // Filter by featured
        if ($request->has('featured') && $request->boolean('featured')) {
            $query->featured();
        }

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by stock status
        if ($request->has('in_stock') && $request->boolean('in_stock')) {
            $query->inStock();
        }

        // Search by name or description
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Price range filter
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $products = $query->paginate($request->get('per_page', 15));

        return $this->sendPaginatedResponse($products, 'Products retrieved successfully');
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'sku' => 'required|string|max:100|unique:products',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'images' => 'nullable|array',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'manage_stock' => 'boolean',
            'stock_status' => 'required|in:in_stock,out_of_stock,on_backorder',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'short_description' => $request->short_description,
            'sku' => $request->sku,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'stock_quantity' => $request->stock_quantity,
            'category_id' => $request->category_id,
            'images' => $request->images,
            'is_active' => $request->get('is_active', true),
            'is_featured' => $request->get('is_featured', false),
            'manage_stock' => $request->get('manage_stock', true),
            'stock_status' => $request->stock_status,
        ]);

        $product->load('category');

        return $this->sendResponse($product, 'Product created successfully');
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return $this->sendError('Product not found');
        }

        return $this->sendResponse($product, 'Product retrieved successfully');
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->sendError('Product not found');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'sku' => 'sometimes|required|string|max:100|unique:products,sku,' . $id,
            'price' => 'sometimes|required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'sometimes|required|integer|min:0',
            'category_id' => 'sometimes|required|exists:categories,id',
            'images' => 'nullable|array',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'manage_stock' => 'boolean',
            'stock_status' => 'sometimes|required|in:in_stock,out_of_stock,on_backorder',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $data = $request->only([
            'name', 'description', 'short_description', 'sku', 'price', 'sale_price',
            'stock_quantity', 'category_id', 'images', 'is_active', 'is_featured',
            'manage_stock', 'stock_status'
        ]);

        if ($request->has('name')) {
            $data['slug'] = Str::slug($request->name);
        }

        // Validate sale price is less than regular price
        if (isset($data['sale_price']) && isset($data['price']) && $data['sale_price'] >= $data['price']) {
            return $this->sendError('Sale price must be less than regular price', [], 422);
        }

        $product->update($data);
        $product->load('category');

        return $this->sendResponse($product, 'Product updated successfully');
    }

    /**
     * Remove the specified product.
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->sendError('Product not found');
        }

        // Check if product has order items
        if ($product->orderItems()->count() > 0) {
            return $this->sendError('Cannot delete product with existing orders', [], 422);
        }

        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully');
    }

    /**
     * Get featured products.
     */
    public function featured(Request $request)
    {
        $products = Product::with('category')
            ->featured()
            ->active()
            ->take($request->get('limit', 10))
            ->get();

        return $this->sendResponse($products, 'Featured products retrieved successfully');
    }

    /**
     * Search products.
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'q' => 'required|string|min:2',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $query = Product::with('category')
            ->active()
            ->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%')
                  ->orWhere('sku', 'like', '%' . $request->q . '%');
            });

        $products = $query->paginate($request->get('per_page', 15));

        return $this->sendPaginatedResponse($products, 'Search results retrieved successfully');
    }
}