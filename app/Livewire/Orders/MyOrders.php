<?php

namespace App\Livewire\Orders;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class MyOrders extends Component
{
    public $orders;

    public function mount($order_id = null)
    {
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login');
        }

        // Start query
        $query = Order::where('user_id', $userId)->with('orderItems');

        if ($order_id) {
            // If route provides an order_id → filter by that
            $query->where('_id', $order_id);
        } else {
            // Otherwise → show only the orders from this session
            $sessionPlacedOrders = session()->get('placed_orders', []);
            if (!empty($sessionPlacedOrders)) {
                $query->whereIn('_id', $sessionPlacedOrders);
            } else {
                $query->whereRaw('1 = 0'); // no orders if session is empty
            }
        }

        $this->orders = $query->orderBy('order_date', 'desc')->get();

        // Attach product info from MySQL
        $productIds = $this->orders->flatMap(fn($order) => $order->orderItems->pluck('product_id'))->unique();
        $products   = Product::whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($this->orders as $order) {
            foreach ($order->orderItems as $item) {
                $item->setRelation('product', $products->get($item->product_id));
            }
        }
    }

    public function render()
    {
        return view('livewire.orders.my-orders', [
            'orders' => $this->orders
        ])->layout('layouts.app');
    }
}
