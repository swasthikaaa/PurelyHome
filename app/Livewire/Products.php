<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class Products extends Component
{
    public $search;
    public $toastMessage = null;

    public function mount()
    {
        $this->search = request()->query('q', null);
    }

    /**
     * Add product to cart
     */
    public function addToCart($productId)
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login');
        }

        // ✅ Ensure only active products can be added
        $product = Product::where('id', $productId)
            ->where('is_active', 1)
            ->first();

        if (!$product || $product->quantity <= 0) {
            session()->flash('error', '❌ This product is out of stock or unavailable.');
            return;
        }

        $cart = Cart::firstOrCreate(['user_id' => $userId, 'status' => 'active']);

        $item = CartItem::where('cart_id', $cart->_id)
            ->where('product_id', $productId)
            ->first();

        if ($item) {
            if ($product->quantity > $item->quantity) {
                $item->quantity += 1;
                $item->save();
            } else {
                session()->flash('error', '⚠️ Not enough stock for ' . $product->name);
                return;
            }
        } else {
            CartItem::create([
                'cart_id'    => $cart->_id,
                'product_id' => $productId,
                'quantity'   => 1,
            ]);
        }

        $this->toastMessage = ($product->name ?? 'Product') . " added to cart!";
    }

    /**
     * Buy Now (direct order)
     */
    public function buyNow($productId)
    {
        $userId = Auth::id();
        if (!$userId) return redirect()->route('login');

        // ✅ Ensure only active products can be bought
        $product = Product::where('id', $productId)
            ->where('is_active', 1)
            ->first();

        if (!$product || $product->quantity <= 0) {
            return back()->with('error', '❌ Product is out of stock or unavailable.');
        }

        $order = Order::create([
            'user_id'    => $userId,
            'order_date' => now(),
            'status'     => 'pending',
        ]);

        $price = $product->offer_price ?? $product->price ?? 0;

        OrderItem::create([
            'order_id'   => (string) $order->_id,
            'product_id' => $product->id,
            'quantity'   => 1,
            'price'      => $price,
        ]);

        // reduce stock
        $product->decrement('quantity', 1);

        // remove from cart if exists
        CartItem::where('product_id', $productId)
            ->where('cart_id', optional(Cart::where('user_id', $userId)->where('status', 'active')->first())->_id)
            ->delete();

        session()->put('placed_orders', [$order->_id]);

        return redirect()->route('my-orders.index')
            ->with('success', '✅ Order placed successfully!');
    }

    public function render()
    {
        if ($this->search) {
            $products = Product::where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                      ->orWhere('description', 'like', "%{$this->search}%");
                })
                ->where('is_active', 1) // ✅ hide inactive products
                ->get();

            return view('livewire.products', [
                'products'   => $products,
                'searchTerm' => $this->search,
            ])->layout('layouts.app');
        }

        // ✅ Only active products in both sections
        $newArrivals   = Product::where('is_active', 1)->latest()->take(4)->get();
        $otherProducts = Product::where('is_active', 1)->latest()->skip(4)->take(20)->get();

        return view('livewire.products', [
            'newArrivals'   => $newArrivals,
            'otherProducts' => $otherProducts,
        ])->layout('layouts.app');
    }
}
