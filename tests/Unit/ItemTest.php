<?php

namespace Tests\Unit;

use App\Item;
use App\Order;
use Tests\TestCase;
use App\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        // Create a random restaurant
        $this->restaurant = factory(Restaurant::class)->create();

        // Create a random item
        $this->item = factory(Item::class)->create();

        // List the item on the restaurant for 13$
        $this->restaurant->items()->attach($this->item, ['price' => 13]);
    }

    /** @test */
    public function i_can_get_all_restaurants_listing_this_item()
    {
        $this->assertEquals(1, $this->item->restaurants()->count());
        factory(Restaurant::class)->create()->items()->attach($this->item);
        $this->assertEquals(2, $this->item->restaurants()->count());
    }

    /** @test */
    public function i_can_get_all_orders_using_this_item()
    {
        // Create a random order for the restaurant
        $order = factory(Order::class)->create(['restaurant_id' => $this->restaurant->id]);

        // Attach our test item
        $order->items()->attach($this->item);

        // Make sure we can find back the order we just created that is listing our test item
        $this->assertEquals(1, $this->item->orders()->count());
        $this->assertEquals($order->id, $this->item->orders()->first()->id); 
    }
}