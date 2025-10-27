<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Public: List all active products
     */
    public function publicIndex()
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($p) {
                if ($p->image && !Str::startsWith($p->image, ['http://', 'https://'])) {
                    $p->image = asset('storage/' . $p->image);
                }
                return $p;
            });

        return response()->json([
            'success' => true,
            'message' => 'Active products fetched successfully',
            'count'   => $products->count(),
            'data'    => $products
        ]);
    }

    /**
     * Admin: List all products
     */
    public function adminIndex()
    {
        $products = Product::with(['category', 'admin'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($p) {
                if ($p->image && !Str::startsWith($p->image, ['http://', 'https://'])) {
                    $p->image = asset('storage/' . $p->image);
                }
                return $p;
            });

        return response()->json([
            'success' => true,
            'message' => 'All products fetched successfully',
            'count'   => $products->count(),
            'data'    => $products
        ]);
    }

    /**
     * Store new product
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string',
        'category_id' => 'nullable|exists:categories,id',
        'price'       => 'required|numeric|min:0',
        'offer_price' => 'nullable|numeric|min:0',   
        'quantity'    => 'required|integer|min:0',
        'is_active'   => 'required|boolean',
        'image'       => 'nullable|image|max:2048'
    ]);

    $validated['slug'] = Str::slug($validated['name']);
    $validated['admin_id'] = auth()->id();

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('products', 'public');
    }

    $product = Product::create($validated);

    return response()->json([
        'success' => true,
        'message' => 'Product created successfully',
        'data'    => $product
    ], 201);
}


    /**
     * Admin: Show single product
     */
    public function show($id)
    {
        $product = Product::with(['category', 'admin'])->find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        if ($product->image && !Str::startsWith($product->image, ['http://', 'https://'])) {
            $product->image = asset('storage/' . $product->image);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product fetched successfully',
            'data'    => $product
        ]);
    }

    /**
     * Update product
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        $validated = $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'price'       => 'sometimes|required|numeric|min:0',
            'offer_price' => 'nullable|numeric|min:0',
            'quantity'    => 'sometimes|required|integer|min:0',
            'is_active'   => 'required|boolean',
            'image'       => 'nullable|image|max:2048'
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data'    => $product
        ]);
    }

    /**
     * Delete a product
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}
