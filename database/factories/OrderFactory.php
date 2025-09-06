<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Order;

class OrderFactory extends Factory
{
    protected $model = \App\Models\Order::class;

    public function definition(): array
    {
        return [
            // User ID will be overridden from seeder for correctness
            'user_id' => User::inRandomOrder()->first()->id,

            // Order date between 2024 and 2025
            'order_date' => $this->faker->dateTimeBetween('2024-01-01', '2025-12-31'),

            // Random status
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),

            // Optional: faker created_at and updated_at
            'created_at' => $this->faker->dateTimeBetween('2023-01-01', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('created_at', 'now'),
        ];
    }
}
