<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $electronicsCategory = Category::where('slug', 'electronics')->first();
        $clothingCategory = Category::where('slug', 'clothing')->first();
        $booksCategory = Category::where('slug', 'books')->first();
        $homeCategory = Category::where('slug', 'home-garden')->first();

        $products = [
            // Electronics
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Latest iPhone with advanced camera system',
                'short_description' => 'Premium smartphone with Pro camera system',
                'price' => 999.99,
                'sale_price' => 899.99,
                'stock_quantity' => 50,
                'category_id' => $electronicsCategory->id,
                'is_featured' => true,
            ],
            [
                'name' => 'MacBook Air M2',
                'description' => 'Powerful laptop with M2 chip',
                'short_description' => 'Ultra-thin laptop with M2 processor',
                'price' => 1199.99,
                'stock_quantity' => 25,
                'category_id' => $electronicsCategory->id,
                'is_featured' => true,
            ],
            [
                'name' => 'AirPods Pro',
                'description' => 'Wireless earbuds with noise cancellation',
                'short_description' => 'Premium wireless earbuds',
                'price' => 249.99,
                'stock_quantity' => 100,
                'category_id' => $electronicsCategory->id,
            ],

            // Clothing
            [
                'name' => 'Classic White T-Shirt',
                'description' => 'Comfortable cotton t-shirt for everyday wear',
                'short_description' => '100% cotton classic fit t-shirt',
                'price' => 19.99,
                'stock_quantity' => 200,
                'category_id' => $clothingCategory->id,
            ],
            [
                'name' => 'Denim Jeans',
                'description' => 'Premium denim jeans with classic fit',
                'short_description' => 'Classic fit denim jeans',
                'price' => 79.99,
                'sale_price' => 59.99,
                'stock_quantity' => 75,
                'category_id' => $clothingCategory->id,
            ],
            [
                'name' => 'Leather Jacket',
                'description' => 'Genuine leather jacket for stylish look',
                'short_description' => 'Premium leather jacket',
                'price' => 299.99,
                'stock_quantity' => 15,
                'category_id' => $clothingCategory->id,
                'is_featured' => true,
            ],

            // Books
            [
                'name' => 'The Great Gatsby',
                'description' => 'Classic American novel by F. Scott Fitzgerald',
                'short_description' => 'Classic literature masterpiece',
                'price' => 12.99,
                'stock_quantity' => 80,
                'category_id' => $booksCategory->id,
            ],
            [
                'name' => 'Laravel: Up & Running',
                'description' => 'Comprehensive guide to Laravel framework',
                'short_description' => 'Learn Laravel from basics to advanced',
                'price' => 39.99,
                'stock_quantity' => 30,
                'category_id' => $booksCategory->id,
            ],

            // Home & Garden
            [
                'name' => 'Coffee Maker',
                'description' => 'Programmable coffee maker with timer',
                'short_description' => '12-cup programmable coffee maker',
                'price' => 89.99,
                'stock_quantity' => 40,
                'category_id' => $homeCategory->id,
            ],
            [
                'name' => 'Garden Tool Set',
                'description' => 'Complete set of essential garden tools',
                'short_description' => '5-piece garden tool set',
                'price' => 49.99,
                'stock_quantity' => 60,
                'category_id' => $homeCategory->id,
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $product['description'],
                'short_description' => $product['short_description'],
                'sku' => 'SKU-' . strtoupper(Str::random(8)),
                'price' => $product['price'],
                'sale_price' => $product['sale_price'] ?? null,
                'stock_quantity' => $product['stock_quantity'],
                'manage_stock' => true,
                'stock_status' => 'in_stock',
                'images' => json_encode([
                    'image1.jpg',
                    'image2.jpg',
                ]),
                'is_active' => true,
                'is_featured' => $product['is_featured'] ?? false,
                'category_id' => $product['category_id'],
            ]);
        }
    }
}