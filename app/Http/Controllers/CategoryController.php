<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories with their products.
     */
    public function index()
    {
        $categories = Category::with('products')->get();
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($validated);

        return new CategoryResource($category->load('products'));
    }

    /**
     * Display the specified category with products.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category->load('products'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $category->update($validated);

        return new CategoryResource($category->load('products'));
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.']);
    }

    /**
     * Get all products of a given category.
     */
    public function products(Category $category)
    {
        return ProductResource::collection(
            $category->products()->with(['admin', 'category'])->get()
        );
    }
}
