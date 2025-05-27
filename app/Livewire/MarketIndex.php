<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;

class MarketIndex extends Component
{
    public $items;

    public function mount()
    {
        $this->items = Item::select('name', 'rarity', 'season', 'category', 'tag', 'price', 'author', 'image_path')->get();
    }

    public function render()
    {
        return view('livewire.market-index');
    }
}
