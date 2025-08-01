<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and accessories',
                'sort_order' => 1,
            ],
            [
                'name' => 'Clothing',
                'description' => 'Men and women clothing',
                'sort_order' => 2,
            ],
            [
                'name' => 'Books',
                'description' => 'Books and educational materials',
                'sort_order' => 3,
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Home improvement and garden supplies',
                'sort_order' => 4,
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Sports equipment and outdoor gear',
                'sort_order' => 5,
            ],
            [
                'name' => 'Beauty & Health',
                'description' => 'Beauty products and health supplements',
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => true,
                'sort_order' => $category['sort_order'],
            ]);
        }
    }
}