<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
        // 🚨 First clean all tables (order matters due to foreign keys)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        Category::truncate();
        Product::truncate();
        Phone::truncate();
        Cart::truncate();
        CartItem::truncate();
        Order::truncate();
        OrderItem::truncate();
        Payment::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ✅ Create 1 Admin User (fixed credentials)
        $admin = User::create([
            'name'              => 'Admin User',
            'email'             => 'admin@purelyhome.com',
            'password'          => Hash::make('password123'),
            'role'              => 'admin',
            'email_verified_at' => now(),
        ]);

        // ✅ Create 4 Customer Users
        $customers = User::factory(4)->create([
            'role' => 'customer',
        ]);

        // ✅ Insert 3 Fixed Categories
        $categories = collect([
            Category::create(['name' => 'Cleaning Essentials']),
            Category::create(['name' => 'Kitchenware']),
            Category::create(['name' => 'Home Decor']),
        ]);

        // ✅ Create 10 Products linked to random of the 3 categories and admin
        $products = Product::factory(10)->create()->each(function ($product) use ($categories, $admin) {
            $product->update([
                'category_id' => $categories->random()->id,
                'admin_id'    => $admin->id,
            ]);
        });

        // ✅ Create one Phone for each user
        User::all()->each(function ($user) {
            Phone::factory()->create([
                'user_id' => $user->id,
            ]);
        });

        // ✅ Create Carts and CartItems for each customer
        foreach ($customers as $customer) {
            $cart = Cart::factory()->create([
                'user_id' => $customer->id,
            ]);

            $cartProducts = $products->random(rand(1, 3));

            foreach ($cartProducts as $product) {
                CartItem::factory()->create([
                    'cart_id'    => $cart->id,
                    'product_id' => $product->id,
                ]);
            }
        }

        // ✅ Create Orders + OrderItems + Payments for each customer
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
