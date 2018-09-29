<?php

namespace Tests\Feature;

use App\User;
use App\Item;
use App\Order;
use App\Restaurant;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderApiTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        // Create a random restaurant
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
    public function i_can_add_valid_orders()
    {
        $this->json('post', '/api/orders', [
            'restaurant_id' => $this->restaurant->id,
            'menu_items' => $this->restaurant->items()->inRandomOrder()->take(3)->pluck('id'),
            'user_id' => factory(User::class)->create()->id
        ])->assertStatus(200)
          ->assertJsonStructure([
            'order' => [
                'id',
                'price',
                'user' => [
                    'id',
                    'name'
                ],
                'restaurant' => [
                    'id',
                    'name'
                ],
                'items' => [
                    [
                        'id',
                        'name',
                        'quantity',
                        'price'
                    ]
                ]
            ]
          ]);
    }

    /** @test */
    public function i_cannot_add_orders_to_an_invalid_restaurant()
    {
        $this->json('post', '/api/orders', [
            'restaurant_id' => time(),
            'menu_items' => $this->restaurant->items()->inRandomOrder()->take(3)->pluck('id'),
            'user_id' => factory(User::class)->create()->id
        ])->assertStatus(422);
    }

    /** @test */
    public function i_cannot_add_orders_with_unlisted_items()
    {
        $this->json('post', '/api/orders', [
            'restaurant_id' => $this->restaurant->id,
            'menu_items' => [$this->restaurant->items()->max('id')+1], // Make sure we use an item that we do not have
            'user_id' => factory(User::class)->create()->id
        ])->assertStatus(422);
    }

    /** @test */
    public function i_cannot_add_orders_with_missing_fields()
    {
        $restaurant = $this->restaurant->id;
        $items = [$this->restaurant->items()->first()->id];
        $user = factory(User::class)->create()->id;

        $this->json('post', '/api/orders', [
            'menu_items' => $items, 
            'user_id' => $user
        ])->assertStatus(422);
        $this->json('post', '/api/orders', [
            'restaurant_id' => $restaurant,
            'user_id' => $user
        ])->assertStatus(422);
        $this->json('post', '/api/orders', [
            'restaurant_id' => $restaurant,
            'menu_items' => $items,
        ])->assertStatus(422);
    }

    /** @test */
    public function i_can_update_a_valid_order()
    {
        $this->json('patch', '/api/orders/' . $this->order->id, [
            'restaurant_id' => $this->restaurant->id,
            'menu_items' => $this->restaurant->items()->inRandomOrder()->take(3)->pluck('id'),
        ])->assertStatus(200)
          ->assertJsonStructure([
            'order' => [
                'id',
                'price',
                'user' => [
                    'id',
                    'name'
                ],
                'restaurant' => [
                    'id',
                    'name'
                ],
                'items' => [
                    [
                        'id',
                        'name',
                        'quantity',
                        'price'
                    ]
                ]
            ]
          ]);
    }

    /** @test */
    public function i_cannot_update_an_order_with_unlisted_items()
    {
        $this->json('patch', '/api/orders/'.$this->order->id, [
            'restaurant_id' => $this->restaurant->id,
            'menu_items' => [$this->restaurant->items()->max('id')+1], // Make sure we use an item that we do not 
        ])->assertStatus(422);
    }

    /** @test */
    public function i_can_delete_a_valid_order()
    {
        $this->json('delete', '/api/orders/'.$this->order->id, [
            'restaurant_id' => $this->restaurant->id,
        ])->assertStatus(200);
    }

    /** @test */
    public function i_cannot_delete_an_order_if_restaurant_doesnt_match()
    {
        $this->json('delete', '/api/orders/'.$this->order->id, [
            'restaurant_id' => time(),
        ])->assertStatus(422);
    }

    /** @test */
    public function i_can_get_a_valid_order()
    {
        $this->json('get', '/api/orders/'.$this->order->id)
             ->assertStatus(200);
    }
}
