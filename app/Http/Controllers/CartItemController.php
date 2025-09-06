<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Resources\CartItemResource;

class CartItemController extends Controller
{
    /**
     * Display a listing of the cart items.
     */
    public function index()
    {
        $cartItems = CartItem::with('product')->get();
        return CartItemResource::collection($cartItems);
    }

    /**
     * Store a newly created cart item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cart_id'    => 'required|exists:carts,id',
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        // Check if the item already exists in the cart
        $existingItem = CartItem::where('cart_id', $validated['cart_id'])
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existingItem) {
            // If it exists, update the quantity
            $existingItem->quantity += $validated['quantity'];
            $existingItem->save();

            return new CartItemResource($existingItem->load('product'));
        }

        $cartItem = CartItem::create($validated);
        return new CartItemResource($cartItem->load('product'));
    }

    /**
     * Display the specified cart item.
     */
    public function show(CartItem $cartItem)
    {
        return new CartItemResource($cartItem->load('product'));
    }

    /**
     * Update the specified cart item.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $validated = $request->validate([
            'quantity'   => 'sometimes|integer|min:1',
            'product_id' => 'sometimes|exists:products,id',
        ]);

        $cartItem->update($validated);

        return new CartItemResource($cartItem->load('product'));
    }

    /**
     * Remove the specified cart item.
     */
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return response()->json(['message' => 'Cart item removed successfully.']);
    }
}
