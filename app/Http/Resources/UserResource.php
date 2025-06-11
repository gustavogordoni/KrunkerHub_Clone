<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'level' => $this->level,
            'kr' => $this->kr,
            'clan' => $this->clan,
            'junk' => $this->junk,
            'score' => $this->score,
            'kills' => $this->kills,
            'deaths' => $this->deaths,
            'games' => $this->games,
            'wins' => $this->wins,
            'assists' => $this->assists,
            'melee' => $this->melee,
            'headshots' => $this->headshots,
            'wallbangs' => $this->wallbangs,
            'shots' => $this->shots,
            'hits' => $this->hits,
            'misses' => $this->misses,
            'time_played' => $this->time_played,
            'created' => Carbon::make($this->created_at)->format('d-m-Y'),
        ];
    }
}
