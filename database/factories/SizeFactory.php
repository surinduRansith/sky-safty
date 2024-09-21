<?php

namespace Database\Factories;

use App\Models\Size;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Size>
 */
class SizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Define sizes and reset usedSizes after each stock is seeded
        /* static $usedSizes = [];

        if (empty($usedSizes)) {
            $usedSizes = ['S', 'M', 'L', 'XL'];
        }

        $size = array_pop($usedSizes);

        return [
            'quantity' => $this->faker->numberBetween(1, 100),
            'size'         => $size,
            'stock_id'     => Stock::factory(),
        ]; */

        return [
            'quantity' => $this->faker->numberBetween(10, 100),
            // 'size' and 'stock_id' will be assigned in the seeder to ensure uniqueness per stock
        ];
    }
}
