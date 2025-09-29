<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\Models\User;

class CartController extends Controller
{
    /**
     * Display a listing of all carts.
     */
    public function index()
    {
        $carts = Cart::with(['user', 'cartItems.product'])->get();
        return CartResource::collection($carts);
    }

    /**
     * Store a newly created cart.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id', // users in MySQL
        ]);

        $cart = Cart::create([
            'user_id' => $validated['user_id'],
            'status'  => 'active',
        ]);

        return new CartResource($cart->load(['user', 'cartItems.product']));
    }

    /**
     * Display the specified cart by MongoDB _id.
     */
    public function show(string $id)
    {
        $cart = Cart::with(['user', 'cartItems.product'])->findOrFail($id);
        return new CartResource($cart);
    }

    /**
     * Update the specified cart by MongoDB _id.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'status'  => 'sometimes|string',
        ]);

        $cart = Cart::findOrFail($id);
        $cart->update($validated);

        return new CartResource($cart->load(['user', 'cartItems.product']));
    }

    /**
     * Remove the specified cart by MongoDB _id.
     */
    public function destroy(string $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return response()->json(['message' => 'Cart deleted successfully.']);
    }
}
