<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class ProductDetail extends Component
{
    public $product;
    public $thumbnail;
    public $toastMessage = null; // toast message property

    public function mount($id)
    {
        $this->product = Product::findOrFail($id);

        $this->thumbnail = $this->product->image 
            ? asset('storage/'.$this->product->image) 
            : asset('images/default.png');
    }

    public function setThumbnail($image)
    {
        $this->thumbnail = $image;
    }

    public function addToCart($id)
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login');
        }

        $cart = Cart::firstOrCreate(
            ['user_id' => $userId, 'status' => 'active']
        );

        $item = CartItem::where('cart_id', $cart->_id)
            ->where('product_id', $id)
            ->first();

        if ($item) {
            $item->quantity++;
            $item->save();
        } else {
            $item = CartItem::create([
                'cart_id'    => $cart->_id,
                'product_id' => $id,
                'quantity'   => 1,
            ]);
        }

        // Set toast message to show in Blade
        $this->toastMessage = ($item->product->name ?? 'Product') . " added to cart!";
    }

    public function buyNow($id)
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login');
        }

        $product = Product::findOrFail($id);

        $order = Order::create([
            'user_id'    => $userId,
            'order_date' => now(),
            'status'     => 'pending',
        ]);

        OrderItem::create([
            'order_id'   => $order->_id,
            'product_id' => $product->id,
            'quantity'   => 1,
            'price'      => $product->offer_price ?? $product->price,
        ]);

        // Store session for MyOrders
        session()->put('placed_orders', [$order->_id]);

        return redirect()->route('my-orders.index', ['order_id' => $order->_id]);
    }

    public function render()
    {
        return view('livewire.product-detail')->layout('layouts.app');
    }
}
