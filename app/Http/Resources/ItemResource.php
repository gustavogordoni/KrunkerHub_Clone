<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'name' => $this->name,
            'rarity' => $this->rarity,
            'category' => $this->category,
            'season' => $this->season,
            'author' => [
                'id' => $this->author,
                'name' => User::findOrFail($this->author)->name,
            ],
            'created' => Carbon::make($this->created_at)->format('d-m-Y'),
        ];
    }
}
