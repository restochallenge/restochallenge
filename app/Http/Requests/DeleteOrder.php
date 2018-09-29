<?php

namespace App\Http\Requests;

use App\Rules\RestaurantHasOrder;
use Illuminate\Foundation\Http\FormRequest;

class DeleteOrder extends FormRequest
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
            'restaurant_id' => [
                'required',
                new RestaurantHasOrder($this->route('order')->id)
            ] 
        ];
    }
}
