<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
    'order_id' => Order::inRandomOrder()->first()->id ?? Order::factory(),
    'amount' => $this->faker->randomFloat(2, 50, 500),
    'method' => $this->faker->randomElement(['card', 'cash', 'paypal']),
    'status' => $this->faker->randomElement(['paid', 'unpaid', 'pending']),
    'transaction_ref' => $this->faker->uuid,
        ];
    }
}
