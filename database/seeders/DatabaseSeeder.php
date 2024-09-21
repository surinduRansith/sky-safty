<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Size;
use App\Models\Stock;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => bcrypt('12341234'),
        ]);


        // Create 5 stocks
        $stocks = Stock::factory()->count(5)->create();

        // Define available sizes
        $sizes = ['XS', 'S', 'M', 'L', 'XL'];

        // For each stock, create sizes
        foreach ($stocks as $stock) {
            foreach ($sizes as $size) {
                Size::factory()->create([
                    'stock_id'     => $stock->id,
                    'size'         => $size,
                    'quantity' => rand(10, 100),
                ]);
            }
        }

        // Create 3 customers
        $customers = Customer::factory()->count(3)->create();

        // For each customer, create an order
        foreach ($customers as $customer) {
            $orders = Order::factory()->count(3)->create([
                'customer_id' => $customer->id,
            ]);

            // Add 1 to 5 random order items to each order
            $numberOfItems = rand(1, 5);
            $randomStocks = $stocks->random($numberOfItems);

            foreach ($orders as $order) {
                foreach ($randomStocks as $stock) {
                    OrderItem::factory()->create([
                        'order_id' => $order->id,
                        'stock_id' => $stock->id,
                        'quantity' => rand(1, 5),
                        'price'    => rand(1000, 5000) / 100, // Price between $10 and $50
                    ]);
                }
            }
        }
    }
}
