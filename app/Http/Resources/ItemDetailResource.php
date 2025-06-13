<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'item' => new ItemResource($this['item']),
            'average_price' => $this['average_price'],
            'min_price' => $this['min_price'],
            'max_price' => $this['max_price'],
            'owners' => $this['owners'],
        ];
    }
}
