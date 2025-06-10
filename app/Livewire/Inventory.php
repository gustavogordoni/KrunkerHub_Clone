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
        })->sortBy(function ($item) {
            $rarityOrder = [
                'Unobtainable' => 1,
                'Contraband' => 2,
                'Relic' => 3,
                'Legendary' => 4,
                'Epic' => 5,
                'Rare' => 6,
                'Uncommon' => 7,
            ];

            return [$rarityOrder[$item->rarity], -$item->market_avg_price];
        });
    }

    public function render()
    {
        $itemsTotal = Item::count();

        return view('livewire.inventory', ['itemsTotal' => $itemsTotal]);
    }

    public function listItem($id, $price)
    {
        if (!is_numeric($id) && !is_numeric($price)) {
            abort(404, 'Item não encontrado.');
        }

        Sale::create([
            'item_id' => $id,
            'user_id' => Auth::id(),
            'price' => $price,
        ]);
        
        Auth::user()->items()->detach($id);

        $this->mount();
    }
}
