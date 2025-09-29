<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartIcon extends Component
{
    public $count = 0;

    protected $listeners = ['cartUpdated' => 'updateCount'];

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            $cart = Cart::where('user_id', Auth::id())
                ->where('status', 'active')
                ->first();

            $this->count = $cart
                ? CartItem::where('cart_id', (string) $cart->_id)->sum('quantity')
                : 0;
        } else {
            $this->count = 0;
        }
    }

    public function render()
    {
        return view('livewire.cart.cart-icon');
    }
}
