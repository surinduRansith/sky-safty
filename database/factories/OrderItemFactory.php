<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /* return [
            'order_id'   => Order::factory(),
            'stock_id'   => Stock::factory(),
            'quantity'   => $this->faker->numberBetween(1, 10),
            'price'      => $this->faker->randomFloat(2, 10, 200),
        ]; */
        return [
            'quantity' => $this->faker->numberBetween(1, 5),
            'price'    => $this->faker->randomFloat(2, 10, 500), // Price between $10 and $500
            // 'order_id' and 'stock_id' will be assigned in the seeder
        ];
    }
}
