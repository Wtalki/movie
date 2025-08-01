<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::take(5)->get();

        foreach ($users as $user) {
            // Create 1-3 orders per user
            $orderCount = rand(1, 3);
            
            for ($i = 0; $i < $orderCount; $i++) {
                $order = Order::create([
                    'order_number' => Order::generateOrderNumber(),
                    'user_id' => $user->id,
                    'status' => ['pending', 'processing', 'shipped', 'delivered'][rand(0, 3)],
                    'total_amount' => 0, // Will be calculated after items
                    'shipping_amount' => 10.00,
                    'tax_amount' => 0, // Will be calculated
                    'billing_address' => [
                        'name' => $user->name,
                        'address' => '123 Main St',
                        'city' => 'Anytown',
                        'state' => 'CA',
                        'zip' => '12345',
                        'country' => 'US',
                    ],
                    'shipping_address' => [
                        'name' => $user->name,
                        'address' => '123 Main St',
                        'city' => 'Anytown',
                        'state' => 'CA',
                        'zip' => '12345',
                        'country' => 'US',
                    ],
                    'notes' => 'Please handle with care',
                ]);

                // Add 1-4 items per order
                $itemCount = rand(1, 4);
                $subtotal = 0;

                for ($j = 0; $j < $itemCount; $j++) {
                    $product = $products->random();
                    $quantity = rand(1, 3);
                    $price = $product->getCurrentPrice();
                    $total = $quantity * $price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total' => $total,
                    ]);

                    $subtotal += $total;
                }

                // Update order totals
                $taxAmount = $subtotal * 0.08; // 8% tax
                $totalAmount = $subtotal + $order->shipping_amount + $taxAmount;

                $order->update([
                    'tax_amount' => $taxAmount,
                    'total_amount' => $totalAmount,
                ]);
            }
        }
    }
}