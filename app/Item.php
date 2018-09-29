<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * Get all the restaurants that carries this item
     */
    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'restaurant_items');
    }

    /**
     * Get all orders made with this item
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items');
    }
}
