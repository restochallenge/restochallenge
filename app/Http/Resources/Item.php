<?php

namespace App\Http\Resources;

use App\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class Item extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'quantity' => $this->when($this->pivot, $this->pivot->quantity ?? 1),
            'price' => $this->when($this->pivot, function() {
                return Order::find($this->pivot->order_id)->restaurant->getItemPrice($this->id);
            })
        ];
    }
}
