<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    
    /**
     * Get the user that made this order
     */
    public function user()
    {
        return $this->belongsTo(User::Class);
    }

    /**
     * Get the restaurant that this order was made for 
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Get all the items that this order has
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'order_items')->withPivot('quantity');
    }

    /**
     * Get the price of all items on this order
     * @return int 
     */
    public function getPriceAttribute()
    {
        $price = 0;

        // For each items in this order, we fetch the price listed for the restaurant and multiply it by the quantity of that item we have
        foreach($this->items as $item) {
            $price += $item->pivot->quantity * $this->restaurant->getItemPrice($item);
        }

        return $price;
    }
}
