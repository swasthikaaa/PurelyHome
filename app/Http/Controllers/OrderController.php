<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index()
    {
        $orders = Order::with(['user', 'orderItems.product', 'payment'])->get();
        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created order.
     * Expecting order details + order items in request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'order_date' => 'required|date',
            'status'     => 'required|string|max:255',
            'order_items' => 'required|array|min:1',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.quantity'   => 'required|integer|min:1',
            'order_items.*.price'      => 'required|numeric|min:0',
        ]);

        // Create order
        $order = Order::create([
            'user_id' => $validated['user_id'],
            'order_date' => $validated['order_date'],
            'status' => $validated['status'],
        ]);

        // Create order items
        foreach ($validated['order_items'] as $item) {
            $order->orderItems()->create($item);
        }

        // Load relations for response
        $order->load(['user', 'orderItems.product', 'payment']);

        return new OrderResource($order);
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product', 'payment']);
        return new OrderResource($order);
    }

    /**
     * Update the specified order.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_date' => 'sometimes|date',
            'status'     => 'sometimes|string|max:255',
        ]);

        $order->update($validated);

        $order->load(['user', 'orderItems.product', 'payment']);

        return new OrderResource($order);
    }

    /**
     * Remove the specified order.
     */
    public function destroy(Order $order)
    {
        // Optional: delete related order items first if cascade is not set on DB
        $order->orderItems()->delete();

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully.']);
    }
}
