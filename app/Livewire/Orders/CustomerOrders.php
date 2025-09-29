<?php

namespace App\Livewire\Orders;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CustomerOrders extends Component
{
    public $sortDirection = 'desc'; // ✅ default: newest first
    public $orders;                 // ✅ store orders in property for refresh

    protected $listeners = [
        'orderDeleted' => 'refreshOrders', // ✅ listen for admin delete event
    ];

    public function toggleSort()
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        $this->loadOrders();
    }

    public function mount()
    {
        $this->loadOrders();
    }

    /** ✅ Refresh orders when admin deletes one */
    public function refreshOrders()
    {
        $this->loadOrders();
    }

    /** ✅ Common method to load orders */
    private function loadOrders()
    {
        $userId = Auth::id();
        $this->orders = collect();

        if ($userId) {
            $this->orders = Order::where('user_id', $userId)
                ->with('orderItems')
                ->orderBy('order_date', $this->sortDirection)
                ->get();

            // Load MySQL product details
            $productIds = $this->orders->flatMap(fn($o) => $o->orderItems->pluck('product_id'))->unique();

            $products = $productIds->isEmpty()
                ? collect()
                : Product::whereIn('id', $productIds)->get()->keyBy('id');

            // Attach products to each orderItem
            foreach ($this->orders as $order) {
                foreach ($order->orderItems as $item) {
                    $item->setRelation('product', $products->get($item->product_id));
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.orders.customer-orders', [
            'orders'        => $this->orders,        // ✅ updated orders
            'sortDirection' => $this->sortDirection,
        ])->layout('layouts.app');
    }
}
