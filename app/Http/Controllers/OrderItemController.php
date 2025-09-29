<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Resources\OrderItemResource;
use Illuminate\Support\Facades\Auth;

class OrderItemController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only admin can view all order items');
        }

        // ✅ eager-load product and order
        $orderItems = OrderItem::with(['product', 'order'])->get();
        return OrderItemResource::collection($orderItems);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only admin can add order items');
        }

        $validated = $request->validate([
            'order_id'   => 'required|string',
            'product_id' => 'required|integer|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'price'      => 'required|numeric|min:0',
        ]);

        $orderItem = OrderItem::create([
            'order_id'   => (string) $validated['order_id'],
            'product_id' => (int) $validated['product_id'],
            'quantity'   => (int) $validated['quantity'],
            'price'      => (float) $validated['price'],
        ]);

        // ✅ include product + order in response
        return new OrderItemResource($orderItem->load(['product', 'order']));
    }

    public function show(string $id)
    {
        $orderItem = OrderItem::with(['product', 'order'])->findOrFail($id); // ✅

        if (Auth::user()->role !== 'admin' && $orderItem->order->user_id !== (string) Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return new OrderItemResource($orderItem);
    }

    public function update(Request $request, string $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only admin can update order items');
        }

        $validated = $request->validate([
            'quantity' => 'sometimes|integer|min:1',
            'price'    => 'sometimes|numeric|min:0',
        ]);

        $orderItem = OrderItem::findOrFail($id);
        $orderItem->update($validated);

        return new OrderItemResource($orderItem->load(['product', 'order'])); // ✅
    }

    public function destroy(string $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only admin can delete order items');
        }

        $orderItem = OrderItem::findOrFail($id);
        $orderItem->delete();

        return response()->json(['message' => 'Order item deleted']);
    }
}
