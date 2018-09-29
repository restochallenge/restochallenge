<?php

namespace Tests\Unit;

use App\Restaurant;
use App\Order;
use App\Item;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderTest extends TestCase
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

        // Create an order and add 1 to 4 items
        $this->order = factory(Order::class)->create(['restaurant_id' => $this->restaurant]);
        $this->order->items()->attach($items->take(rand(1, 4)));
    }

    /** @test */
    public function i_can_get_all_items()
    {
        $this->assertGreaterThan(0, $this->order->items()->count());
    }

    /** @test */
    public function i_can_get_the_user_that_made_this_order()
    {
        $this->assertNotNull($this->order->user->id);
    }


    /** @test */
    public function i_can_get_the_restaurant_that_this_order_belongs_to()
    {
        $this->assertEquals($this->order->restaurant->id, $this->restaurant->id);
    }

    /** @test */
    public function i_can_calculate_the_price_of_all_items_using_price_attribute()
    {
        $price = 0;
        
        foreach($this->order->items as $item) {
            $price += $item->pivot->quantity * $this->restaurant->items()->find($item->id)->pivot->price;
        }

        $this->assertNotEquals(0, $price);
        $this->assertEquals($price, $this->order->price);
    }
}