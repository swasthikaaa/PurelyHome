<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'admin'])->get();
        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'admin_id'     => 'required|exists:users,id',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'quantity'     => 'required|integer|min:0',
            'price'        => 'required|numeric|min:0',
        ]);

        $product = Product::create($validated);

        return new ProductResource($product->load(['category', 'admin']));
    }

    public function show(Product $product)
    {
        return new ProductResource($product->load(['category', 'admin']));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id'  => 'sometimes|exists:categories,id',
            'admin_id'     => 'sometimes|exists:users,id',
            'name'         => 'sometimes|string|max:255',
            'description'  => 'nullable|string',
            'quantity'     => 'sometimes|integer|min:0',
            'price'        => 'sometimes|numeric|min:0',
        ]);

        $product->update($validated);

        return new ProductResource($product->load(['category', 'admin']));
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully.']);
    }

}
