<?php

namespace App\Rules;

use App\Order;
use Illuminate\Contracts\Validation\Rule;

class RestaurantHasOrder implements Rule
{
    private $orderId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->orderId = $orderId;
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
        return Order::where('id', $this->orderId)
                    ->where('restaurant_id', $value)
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
