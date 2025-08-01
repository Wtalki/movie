<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends BaseController
{
    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        $query = Category::query();

        // Filter by active status
        if ($request->has('active')) {
            $query->where('is_active', $request->boolean('active'));
        }

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Order by sort order and name
        $query->ordered();

        $categories = $query->paginate($request->get('per_page', 15));

        return $this->sendPaginatedResponse($categories, 'Categories retrieved successfully');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $request->image,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->get('is_active', true),
        ]);

        return $this->sendResponse($category, 'Category created successfully');
    }

    /**
     * Display the specified category.
     */
    public function show($id)
    {
        $category = Category::with('products')->find($id);

        if (!$category) {
            return $this->sendError('Category not found');
        }

        return $this->sendResponse($category, 'Category retrieved successfully');
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->sendError('Category not found');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $data = $request->only(['name', 'description', 'image', 'sort_order', 'is_active']);

        if ($request->has('name')) {
            $data['slug'] = Str::slug($request->name);
        }

        $category->update($data);

        return $this->sendResponse($category, 'Category updated successfully');
    }

    /**
     * Remove the specified category.
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->sendError('Category not found');
        }

        // Check if category has products
        if ($category->products()->count() > 0) {
            return $this->sendError('Cannot delete category with existing products', [], 422);
        }

        $category->delete();

        return $this->sendResponse([], 'Category deleted successfully');
    }

    /**
     * Get products for a specific category.
     */
    public function products($id, Request $request)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->sendError('Category not found');
        }

        $query = $category->products();

        // Filter by active status
        if ($request->has('active')) {
            $query->where('is_active', $request->boolean('active'));
        }

        // Filter by stock status
        if ($request->has('in_stock') && $request->boolean('in_stock')) {
            $query->inStock();
        }

        $products = $query->paginate($request->get('per_page', 15));

        return $this->sendPaginatedResponse($products, 'Category products retrieved successfully');
    }
}