<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    // -------------------------
    // List Orders
    // -------------------------
    public function index()
    {
        $orders = Auth::user()->role !== 'admin'
            ? Order::where('user_id', Auth::id())->with(['orderItems', 'payment'])->get()
            : Order::with(['orderItems', 'payment'])->get();

        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $product = \App\Models\Product::on('mysql')->find($item->product_id);

                if ($product && $product->image && !Str::startsWith($product->image, ['http://', 'https://'])) {
                    $product->image = asset('storage/' . $product->image);
                }

                $item->setRelation('product', $product);
            }
        }

        return $orders;
    }

    // -------------------------
    // Store new Order
    // -------------------------
    public function store(Request $request)
    {
        $validated = $request->validate([
            'status'      => 'required|string|max:255',
            'order_items' => 'required|array|min:1',
            'order_items.*.product_id' => 'required|integer|exists:products,id',
            'order_items.*.quantity'   => 'required|integer|min:1',
            'order_items.*.price'      => 'required|numeric|min:0',
            'amount'   => 'required|numeric|min:1',
            'method'   => 'required|string|in:card,cod',
            'phone'    => 'required|string|max:20',
            'address'  => 'nullable|string|max:255',
            'zip'      => 'nullable|string|max:10',
        ]);

        // ✅ calculate amounts
        $subtotal = collect($validated['order_items'])
            ->sum(fn($i) => $i['price'] * $i['quantity']);

        $shipping = 0; // free shipping for now
        $tax = round($subtotal * 0.02, 2); // 2% tax
        $total = $subtotal + $shipping + $tax;

        // ✅ create order
        $order = Order::create([
            'user_id'    => Auth::id(),
            'order_date' => now(),
            'status'     => $validated['status'],
            'subtotal'   => $subtotal,
            'shipping'   => $shipping,
            'tax'        => $tax,
            'total'      => $total,
        ]);

        foreach ($validated['order_items'] as $item) {
            OrderItem::create([
                'order_id'   => (string) $order->_id,
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);
        }

        // ✅ create payment
        Payment::create([
            'order_id'       => (string) $order->_id,
            'user_id'        => Auth::id(),
            'amount'         => $validated['amount'],
            'method'         => $validated['method'],
            'status'         => 'paid',
            'transaction_id' => uniqid('txn_'),
            'address'        => $validated['address'] ?? null,
            'zip'            => $validated['zip'] ?? null,
            'phone'          => $validated['phone'],
        ]);

        session()->flash('method', $validated['method']);

        return redirect()->route('payment.success', ['order_id' => $order->_id]);
    }

    // -------------------------
    // Payment Success
    // -------------------------
    public function success($order_id)
    {
        $order = Order::with(['orderItems', 'payment'])->findOrFail($order_id);

        $user = \App\Models\User::on('mysql')->find($order->user_id);
        $order->setRelation('user', $user);

        foreach ($order->orderItems as $item) {
            $product = \App\Models\Product::on('mysql')->find($item->product_id);

            if ($product && $product->image && !Str::startsWith($product->image, ['http://', 'https://'])) {
                $product->image = asset('storage/' . $product->image);
            }

            $item->setRelation('product', $product);
        }

        return view('payment-success', compact('order'));
    }

    // -------------------------
    // Show Single Order
    // -------------------------
    public function show(string $id)
    {
        $order = Order::with(['orderItems', 'payment'])->findOrFail($id);

        if (Auth::user()->role !== 'admin' && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order');
        }

        foreach ($order->orderItems as $item) {
            $product = \App\Models\Product::on('mysql')->find($item->product_id);

            if ($product && $product->image && !Str::startsWith($product->image, ['http://', 'https://'])) {
                $product->image = asset('storage/' . $product->image);
            }

            $item->setRelation('product', $product);
        }

        return $order;
    }

    // -------------------------
    // Update Order
    // -------------------------
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => 'sometimes|string|max:255',
        ]);

        $order = Order::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized update');
        }

        $order->update($validated);

        return $order->load(['orderItems', 'payment']);
    }

    // -------------------------
    // Delete Order
    // -------------------------
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized delete');
        }

        OrderItem::where('order_id', (string) $order->_id)->delete();
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully.']);
    }

    // -------------------------
    // Track Orders Page (Blade)
    // -------------------------
    public function trackOrders()
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
            ->with(['orderItems', 'payment'])
            ->latest('order_date')
            ->get();

        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $product = \App\Models\Product::on('mysql')->find($item->product_id);
                if ($product && $product->image && !Str::startsWith($product->image, ['http://', 'https://'])) {
                    $product->image = asset('storage/' . $product->image);
                }
                $item->setRelation('product', $product);
            }
        }

        return view('orders.track', compact('orders'));
    }

    // -------------------------
    // Download Invoice (PDF)
    // -------------------------
    public function downloadInvoice($orderId)
    {
        $order = Order::with(['orderItems', 'payment'])->findOrFail($orderId);

        if (Auth::user()->role !== 'admin' && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $user = \App\Models\User::on('mysql')->find($order->user_id);
        $order->setRelation('user', $user);

        foreach ($order->orderItems as $item) {
            $product = \App\Models\Product::on('mysql')->find($item->product_id);

            if ($product && $product->image && !Str::startsWith($product->image, ['http://', 'https://'])) {
                $product->image = asset('storage/' . $product->image);
            }

            $item->setRelation('product', $product);
        }

        $subtotal = $order->subtotal ?? $order->orderItems->sum(fn($i) => $i->price * $i->quantity);
        $shipping = $order->shipping ?? 0;
        $tax = $order->tax ?? round($subtotal * 0.02, 2);
        $total = $order->total ?? ($subtotal + $shipping + $tax);

        $pdf = Pdf::loadView('invoices.invoice', compact('order', 'subtotal', 'shipping', 'tax', 'total'));

        return $pdf->download("Invoice_{$order->_id}.pdf");
    }

    // -------------------------
    // API: Latest Tracking
    // -------------------------
    public function latestTracking()
    {
        $user = Auth::user();

        $order = Order::with('orderItems')
            ->where('user_id', $user->id)
            ->latest('order_date')
            ->first();

        if (!$order) {
            return response()->json(null, 200);
        }

        $subtotal = $order->subtotal ?? $order->orderItems->sum(fn($i) => $i->price * $i->quantity);
        $shipping = $order->shipping ?? 0;
        $tax = $order->tax ?? round($subtotal * 0.02, 2);
        $total = $order->total ?? ($subtotal + $shipping + $tax);

        return response()->json([
            'tracking_id'         => $order->_id,
            'placed_at'           => $order->created_at,
            'arrived_at'          => $order->arrived_at ?? null,
            'out_for_delivery_at' => $order->out_for_delivery_at ?? null,
            'delivered_at'        => $order->delivered_at ?? null,
            'items' => $order->orderItems->map(fn($i) => [
                'name'  => optional(\App\Models\Product::on('mysql')->find($i->product_id))->name ?? 'Unknown',
                'qty'   => $i->quantity,
                'price' => $i->price,
                'image' => optional(\App\Models\Product::on('mysql')->find($i->product_id))->image
                    ? asset('storage/' . \App\Models\Product::on('mysql')->find($i->product_id)->image)
                    : null,
            ]),
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax'      => $tax,
            'total'    => $total,
        ]);
    }

    // -------------------------
    // API: Track Specific Order
    // -------------------------
    public function track($orderId)
    {
        $order = Order::with('orderItems')->findOrFail($orderId);

        if (Auth::user()->role !== 'admin' && $order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $subtotal = $order->subtotal ?? $order->orderItems->sum(fn($i) => $i->price * $i->quantity);
        $shipping = $order->shipping ?? 0;
        $tax = $order->tax ?? round($subtotal * 0.02, 2);
        $total = $order->total ?? ($subtotal + $shipping + $tax);

        return response()->json([
            'tracking_id'         => $order->_id,
            'placed_at'           => $order->created_at,
            'arrived_at'          => $order->arrived_at ?? null,
            'out_for_delivery_at' => $order->out_for_delivery_at ?? null,
            'delivered_at'        => $order->delivered_at ?? null,
            'items' => $order->orderItems->map(fn($i) => [
                'name'  => optional(\App\Models\Product::on('mysql')->find($i->product_id))->name ?? 'Unknown',
                'qty'   => $i->quantity,
                'price' => $i->price,
                'image' => optional(\App\Models\Product::on('mysql')->find($i->product_id))->image
                    ? asset('storage/' . \App\Models\Product::on('mysql')->find($i->product_id)->image)
                    : null,
            ]),
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax'      => $tax,
            'total'    => $total,
        ]);
    }
}
