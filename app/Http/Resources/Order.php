<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Restaurant as RestaurantResource;
use App\Http\Resources\ItemsCollection as ItemsCollectionResource;

class Order extends JsonResource
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
            'price' => $this->price,
            'user' => new UserResource($this->user),
            'restaurant' => new RestaurantResource($this->restaurant),
            'items' => new ItemsCollectionResource($this->items)
        ];
    }
}
