<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Phone;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 1 Admin User
        $admin = User::factory()->create([
            'role'  => 'admin',
            'email' => 'admin@purelyhome.com', // for login/testing
        ]);

        // Create 4 Customer Users
        $customers = User::factory(4)->create([
            'role' => 'customer',
        ]);

        // Create 5 Categories
        $categories = Category::factory(5)->create();

        // Create 10 Products linked to random categories and the admin
        $products = Product::factory(10)->create()->each(function ($product) use ($categories, $admin) {
            $product->update([
                'category_id' => $categories->random()->id,
                'admin_id'    => $admin->id,
            ]);
        });

        // Create one Phone for each user
        User::all()->each(function ($user) {
            Phone::factory()->create([
                'user_id' => $user->id,
            ]);
        });

        // Create Carts and CartItems for each customer
        foreach ($customers as $customer) {
            $cart = Cart::factory()->create([
                'user_id' => $customer->id,
            ]);

            // Pick 1–3 unique products for cart items
            $cartProducts = $products->random(rand(1, 3));

            foreach ($cartProducts as $product) {
                CartItem::factory()->create([
                    'cart_id'    => $cart->id,
                    'product_id' => $product->id,
                ]);
            }
        }

        // Create 1–2 Orders per customer with OrderItems and Payment
        foreach ($customers as $customer) {
            $orders = Order::factory(rand(1, 2))->create([
                'user_id' => $customer->id,
            ]);

            foreach ($orders as $order) {
                $orderProducts = $products->random(rand(1, 3));
                $totalAmount = 0;

                foreach ($orderProducts as $product) {
                    $orderItem = OrderItem::factory()->create([
                        'order_id'   => $order->id,
                        'product_id' => $product->id,
                    ]);

                    $totalAmount += $orderItem->price * $orderItem->quantity;
                }

                Payment::factory()->create([
                    'order_id' => $order->id,
                    'amount'   => $totalAmount,
                ]);
            }
        }
    }
}
