<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CartIndex extends Component
{
    public $cart;

    public function mount()
    {
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login');
        }

        if (Auth::user()->role === 'admin') {
            abort(403, 'Admins do not have carts.');
        }

        $this->cart = Cart::firstOrCreate(
            ['user_id' => $userId, 'status' => 'active']
        );
    }

    public function addToCart($productId)
    {
        $item = CartItem::where('cart_id', (string) $this->cart->_id)
            ->where('product_id', (int) $productId)
            ->first();

        if ($item) {
            $item->quantity = (int) $item->quantity + 1;
            $item->save();
        } else {
            CartItem::create([
                'cart_id'    => (string) $this->cart->_id,
                'product_id' => (int) $productId,
                'quantity'   => 1,
            ]);
        }

        $this->cart->refresh();

        $this->dispatch('cartUpdated');
        $this->dispatchBrowserEvent('cart-toast', [
            'message' => 'Product added to cart successfully!'
        ]);
    }

    public function removeFromCart($itemId)
    {
        CartItem::where('_id', (string) $itemId)->delete();
        $this->cart->refresh();
        $this->dispatch('cartUpdated');
    }

    public function updateQuantity($itemId, $quantity)
    {
        $item = CartItem::find((string) $itemId);

        if ($item) {
            $item->quantity = max(1, (int) $quantity);
            $item->save();
            $this->cart->refresh();
            $this->dispatch('cartUpdated');
        }
    }

    /**
     * ✅ Checkout all current cart items into a single order
     */
    public function checkout()
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login');
        }

        $cart = Cart::where('user_id', $userId)->where('status', 'active')->first();
        if (!$cart) {
            return;
        }

        $cartItems = CartItem::where('cart_id', (string) $cart->_id)->get();
        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Create Order
        $order = Order::create([
            'user_id'    => $userId,
            'order_date' => now(),
            'status'     => 'pending',
        ]);

        // Transfer cart items → order items
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            $price   = $product->offer_price ?? $product->price ?? 0;

            OrderItem::create([
                'order_id'   => (string) $order->_id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $price,
            ]);
        }

        // Mark cart as completed & clear items
        $cart->update(['status' => 'completed']);
        CartItem::where('cart_id', (string) $cart->_id)->delete();

        // ✅ Store this placed order ID in session
        session()->put('placed_orders', [$order->_id]);

       return redirect()->route('my-orders.index', ['order_id' => $order->_id])
    ->with('success', 'Order placed successfully!');

    }

    public function render()
    {
        $items = CartItem::where('cart_id', (string) $this->cart->_id)->get();

        $items->transform(function ($item) {
            $product = Product::find($item->product_id);
            $item->product = $product ?? (object) [
                'id'          => $item->product_id,
                'name'        => 'Unknown Product',
                'offer_price' => 0,
                'image_url'   => 'https://via.placeholder.com/100',
            ];
            return $item;
        });

        return view('livewire.cart.index', [
            'cartItems' => $items,
        ])->layout('layouts.app');
    }
}
