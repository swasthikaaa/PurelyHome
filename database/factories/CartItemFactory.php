<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CartItem>
 */
class CartItemFactory extends Factory
{
    public function definition(): array
    {
        $maxTries = 10;
        $tries = 0;

        do {
            $cart = Cart::inRandomOrder()->first() ?? Cart::factory()->create();
            $product = Product::inRandomOrder()->first() ?? Product::factory()->create();

            $exists = CartItem::where('cart_id', $cart->id)
                              ->where('product_id', $product->id)
                              ->exists();

            $tries++;
        } while ($exists && $tries < $maxTries);

        if ($exists) {
            // Skip or handle logic if unique combination couldn't be found
            throw new \Exception("Could not find a unique cart-product combination.");
        }

        return [
            'cart_id'    => $cart->id,
            'product_id' => $product->id,
            'quantity'   => $this->faker->numberBetween(1, 5),
        ];
    }
}
