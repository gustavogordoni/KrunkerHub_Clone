<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            'id' => $this->id,
            'item_id' => $this->item_id,
            'user_id' => $this->user_id,
            'user_name' => User::findOrFail($this->user_id)->name,
            'price' => $this->price,
            'status' => $this->status,
            'created' => Carbon::make($this->created_at)->format('d-m-Y'),
            'item' => new ItemResource($this->item),
        ];
    }
}
