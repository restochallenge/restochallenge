<?php

namespace App\Rules;

use DB;
use Illuminate\Contracts\Validation\Rule;

class ItemInRestaurant implements Rule
{
    private $restaurantId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($restaurantId)
    {
        $this->restaurantId = $restaurantId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return DB::table('restaurant_items')
                 ->where('restaurant_id', $this->restaurantId)
                 ->where('item_id', $value)
                 ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
