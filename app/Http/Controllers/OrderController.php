<?php

namespace App\Http\Controllers;

use Validator;
use App\Order;
use App\Restaurant;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrder;
use App\Http\Requests\UpdateOrder;
use App\Http\Requests\DeleteOrder;

use App\Http\Resources\Order as OrderResource;

class OrderController extends Controller
{
    /**
     * Show a specific order
     */
    public function show(Order $order)
    {
        return response()->json([
            new OrderResource($order)
        ]);
    }

    /**
     * Create a new order
     */
    public function store(StoreOrder $request)
    {
        // Create the restaurant order for the given user
        $order = Restaurant::find($request->restaurant_id)->orders()->create([
            'user_id' => $request->user_id
         ]);

        // Attach the wanted items
        $order->items()->attach($request->menu_items);

        return response()->json([
            'order' => new OrderResource($order)
        ]);
    }

    /**
     * Update a given order
     */
    public function update(Order $order, UpdateOrder $request)
    {
        // Switch the order to the new restaurant
        $order->restaurant()->associate($request->restaurant_id)->save();

        // Associate new items to the order
        $order->items()->sync($request->menu_items);

        return response()->json([
            'order' => new OrderResource($order->refresh())
        ]);
    }

    /**
     * Delete a given order
     */
    public function destroy(Order $order, DeleteOrder $request)
    {
        return response()->json([
            'success' => $order->delete()
        ]);
    }
}