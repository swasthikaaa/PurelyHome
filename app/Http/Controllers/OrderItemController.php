<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Resources\OrderItemResource;

class OrderItemController extends Controller
{
    /**
     * Display a listing of order items.
     */
    public function index()
    {
        $orderItems = OrderItem::with('product', 'order')->get();
        return OrderItemResource::collection($orderItems);
    }

    /**
     * Store a newly created order item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id'   => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'price'      => 'required|numeric|min:0',
        ]);

        $orderItem = OrderItem::create($validated);

        return new OrderItemResource($orderItem->load('product'));
    }

    /**
     * Display the specified order item.
     */
    public function show(OrderItem $orderItem)
    {
        return new OrderItemResource($orderItem->load('product'));
    }

    /**
     * Update the specified order item.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        $validated = $request->validate([
            'product_id' => 'sometimes|exists:products,id',
            'quantity'   => 'sometimes|integer|min:1',
            'price'      => 'sometimes|numeric|min:0',
        ]);

        $orderItem->update($validated);

        return new OrderItemResource($orderItem->load('product'));
    }

    /**
     * Remove the specified order item.
     */
    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();

        return response()->json(['message' => 'Order item deleted successfully.']);
    }
}
