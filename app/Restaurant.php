<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $guarded = [];
    
    /**
     * Get the price of an item
     * @param Item|int Either the id of an item or the item itself
     * @return int Price of the item in the restaurant, 0 if the item isn't listed
     */
    public function getItemPrice($item)
    {
        // If we're given an ID, we find the actual item
        if(!($item instanceof Item)) {
            $item = Item::find($item);
        }

        // Make sure that we have this item listed in our restaurant, if not we just return 0
        return $this->items()
                    ->select('price')
                    ->find($item->id)
                    ->price
               ?? 0;
    }

    /**
     * Get all orders made to this restaurant
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all the items that this restaurant has
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'restaurant_items')->withPivot('price');
    }
}
