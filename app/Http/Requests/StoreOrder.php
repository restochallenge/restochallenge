<?php

namespace App\Http\Requests;

use App\Rules\ItemInRestaurant;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'restaurant_id' => 'required|exists:restaurants,id',
            'user_id' => 'required|exists:users,id',
            'menu_items' => 'required|array|filled',
            'menu_items.*' => new ItemInRestaurant($this->restaurant_id)
        ];
    }
}
