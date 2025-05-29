<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Sale;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Inventory extends Component
{
    public $items;

    public function mount()
    {
        $this->items = Auth::user()->items->map(function ($item) {
            $item->market_avg_price = Sale::where('item_id', $item->id)
                ->where('status', 'on_sale')
                ->avg('price') ?? 0;
            return $item;
        });
    }

    public function render()
    {
        $itemsTotal = Item::count();

        return view('livewire.inventory', ['itemsTotal' => $itemsTotal]);
    }
}
