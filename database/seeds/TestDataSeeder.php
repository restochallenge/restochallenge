<?php

use Illuminate\Database\Seeder;

use App\Restaurant;
use App\Item;
use App\Order;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 3 random orders
        factory(Order::class, 3)->create()->each(function($order) {
            // For each order, create a restaurant associated to it
            $order->restaurant()->associate(
                factory(Restaurant::class)->make()
            );
        });

        Restaurant::each(function($restaurant) {
            // We create 12 unique items
            $items = factory(Item::class, 12)->create();

            // For each items we just created, we attach it to the restaurant with a random price between 1 and 20$
            foreach($items as $item) {
                $restaurant->items()->attach($item, ['price' => rand(1, 20)]);
            }

            // Add between 2 and 7 random items to the first order made to this restaurant
            $restaurant->orders()
                       ->first()
                       ->items()
                       ->saveMany(
                            $restaurant->items()->inRandomOrder()->take(rand(2, 7))->get()
                        );
        });
    }
}
