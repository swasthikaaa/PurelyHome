<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;

class Index extends Component
{
    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteOrderId = null;

    public function mount()
    {
        $this->statusFilter = request()->query('status', '');
    }

    // Update status
    public function updateStatus($orderId, $status)
    {
        $order = Order::find($orderId);

        if ($order) {
            $order->update(['status' => $status]);

            if ($status === 'completed') {
                session()->flash('success', "✅ Order #{$order->_id} marked as completed successfully.");
            } elseif ($status === 'cancelled') {
                session()->flash('error', "❌ Order #{$order->_id} cancelled successfully.");
            } else {
                session()->flash('warning', "ℹ️ Order #{$order->_id} updated to {$status}.");
            }
        }
    }

    // Confirm delete
    public function confirmDelete($orderId)
    {
        $this->deleteOrderId = $orderId;
        $this->showDeleteModal = true;
    }

    // Delete order
    public function deleteOrder()
    {
        if (!$this->deleteOrderId) {
            $this->showDeleteModal = false;
            return;
        }

        $order = Order::find($this->deleteOrderId);
        if ($order) {
            $orderId = $order->_id;
            OrderItem::where('order_id', (string) $order->_id)->delete();
            $order->delete();

            session()->flash('success', "🗑 Order #{$orderId} deleted successfully.");
        }

        $this->reset(['deleteOrderId', 'showDeleteModal']);
    }

    public function render()
    {
        $query = Order::with('orderItems')->orderBy('order_date', 'desc');

        if ($this->statusFilter !== '') {
            $query->where('status', $this->statusFilter);
        }

        $orders = $query->get();

        $productIds = $orders
            ->flatMap(fn($order) => $order->orderItems->pluck('product_id'))
            ->unique()
            ->filter();

        $products = $productIds->isNotEmpty()
            ? Product::whereIn('id', $productIds)->get()->keyBy('id')
            : collect();

        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $item->product = $products->get($item->product_id);
            }
        }

        return view('livewire.admin.orders.index', [
            'orders' => $orders,
        ])->layout('layouts.app');
    }
}
