<?php

namespace App\Livewire;

use App\Models\Item;
    use App\Models\Sale;
use Livewire\Component;

class MarketIndex extends Component
{
    public $sales;

    public function mount()
    {
        // $this->items = Item::select('name', 'rarity', 'season', 'category', 'tag', 'price', 'author', 'image_path')->get();

        $this->sales = Sale::with('item')
            ->where('status', 'on_sale')
            ->get();            
    }

    public function render()
    {
        return view('livewire.market-index');
    }
}
