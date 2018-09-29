<?php

namespace Tests\Unit;

use App\Restaurant;
use App\Order;
use App\Item;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RestaurantTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->restaurant = factory(Restaurant::class)->create();

        // We create 12 unique items
        $items = factory(Item::class, 12)->create();

        // For each items we just created, we attach it to the restaurant with a random price between 1 and 20$
        foreach($items as $item) {
            $this->restaurant->items()->attach($item, ['price' => rand(1, 20)]);
        }
    }

    /** @test */
    public function i_can_get_all_items()
    {
        $this->assertEquals(12, $this->restaurant->items()->count());
    }

    /** @test */
    public function i_can_get_all_orders()
    {
        // Create a random order, which creates a random restaurant
        $order = factory(Order::class)->create(['restaurant_id' => $this->restaurant->id]);

        $this->assertEquals($this->restaurant->orders()->first()->id, $order->id);
    }

    /** @test */
    public function i_can_get_the_price_of_a_given_item_using_pivot()
    {
        // Get the first item and its price
        $firstItem = $this->restaurant->items()->first();
        $firstItemPrice = $firstItem->pivot->price;

        // Make sure it's not free
        $this->assertGreaterThan(0, $firstItemPrice);
    }

    /** @test */
    public function i_can_get_the_price_of_a_given_item_using_getitemprice()
    {
        // Get the first item and its price
        $firstItem = $this->restaurant->items()->first();
        $firstItemPrice = $firstItem->pivot->price;

        $this->assertEquals($firstItemPrice, $this->restaurant->getItemPrice($firstItem->id));
        $this->assertEquals($firstItemPrice, $this->restaurant->getItemPrice($firstItem));        
    }
}
