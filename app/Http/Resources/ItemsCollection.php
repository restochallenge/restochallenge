<?php

namespace App\Http\Resources;

use App\Http\Resources\Item as ItemResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $items = [];

        foreach($this->collection as $item) {
            $items[] = new ItemResource($item);
        }

        return $items;
    }
}
