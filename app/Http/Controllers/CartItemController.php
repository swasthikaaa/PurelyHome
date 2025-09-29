<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Resources\CartItemResource;

class CartItemController extends Controller
{
    /**
     * Display all cart items.
     */
    public function index()
    {
        $cartItems = CartItem::all(); // no eager load (MySQL + Mongo conflict)
        return CartItemResource::collection($cartItems);
    }

    /**
     * Store a new cart item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cart_id'    => 'required|exists:carts,_id',  // Mongo cart
            'product_id' => 'required|exists:products,id', // MySQL product
            'quantity'   => 'required|integer|min:1',
        ]);

        // If already exists, increment quantity
        $existingItem = CartItem::where('cart_id', $validated['cart_id'])
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existingItem) {
            $existingItem->quantity += $validated['quantity'];
            $existingItem->save();

            return new CartItemResource($existingItem);
        }

        $cartItem = CartItem::create($validated);
        return new CartItemResource($cartItem);
    }

    /**
     * Show a specific cart item by MongoDB _id.
     */
    public function show(string $id)
    {
        $cartItem = CartItem::findOrFail($id);
        return new CartItemResource($cartItem);
    }

    /**
     * Update a cart item by MongoDB _id.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'quantity'   => 'sometimes|integer|min:1',
            'product_id' => 'sometimes|exists:products,id',
        ]);

        $cartItem = CartItem::findOrFail($id);
        $cartItem->update($validated);

        return new CartItemResource($cartItem);
    }

    /**
     * Remove a cart item by MongoDB _id.
     */
    public function destroy(string $id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return response()->json(['message' => 'Cart item removed successfully.']);
    }
}
