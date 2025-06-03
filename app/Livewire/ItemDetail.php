<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Sale;
use App\Models\User;
use Livewire\Component;

class ItemDetail extends Component
{
    public $item;

    public $averagePrice;
    public $unitsSold;
    public $owners;
    public $minPrice;
    public $maxPrice;
    public $author;

    public function mount($id)
    {
        $this->item = Item::findOrFail($id);

        $this->author = User::find($this->item->author);

        $salesQuery = Sale::where('item_id', $this->item->id)
            ->where('status', 'sold');

        $this->averagePrice = $salesQuery->avg('price') ?? 0;
        $this->minPrice = $salesQuery->min('price') ?? 0;
        $this->maxPrice = $salesQuery->max('price') ?? 0;
        $this->unitsSold = $salesQuery->count();
        $this->owners = Sale::where('item_id', $this->item->id)->distinct('user_id')->count('user_id') ?? 0;
    }

    public function render()
    {
        return view('livewire.item-detail');
    }
}
