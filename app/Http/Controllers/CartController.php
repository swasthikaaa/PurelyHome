<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;

class CartController extends Controller
{
    /**
     * Display a listing of the carts.
     */
    public function index()
    {
        $carts = Cart::with(['user', 'cartItems'])->get();
        return CartResource::collection($carts);
    }

    /**
     * Store a newly created cart.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $cart = Cart::create($validated);

        return new CartResource($cart->load(['user', 'cartItems']));
    }

    /**
     * Display the specified cart.
     */
    public function show(Cart $cart)
    {
        return new CartResource($cart->load(['user', 'cartItems']));
    }

    /**
     * Update the specified cart.
     */
    public function update(Request $request, Cart $cart)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
        ]);

        $cart->update($validated);

        return new CartResource($cart->load(['user', 'cartItems']));
    }

    /**
     * Remove the specified cart.
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return response()->json(['message' => 'Cart deleted successfully.']);
    }
}
