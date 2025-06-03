<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Sale;
use App\Models\User;
use Livewire\Component;

class ItemDetail extends Component
{
    public $item;
    public $range = '1 month';

    public $averagePrice;
    public $unitsSold;
    public $owners;
    public $chartData = [];

    public function mount($id)
    {
        $this->item = Item::findOrFail($id);
        $this->loadStats();
    }
    
    public function loadStats()
    {
        $rangeDate = match ($this->range) {
            '1 week' => now()->subWeek(1),
            '2 week' => now()->subWeek(2),
            '3 week' => now()->subWeek(3),
            '1 months' => now()->subMonths(1),
            '2 months' => now()->subMonths(2),
            '3 months' => now()->subMonths(3),
            '4 months' => now()->subMonths(4),
            default    => now()->subMonth(),
        };

        $sales = Sale::where('item_id', $this->item->id)
            ->where('status', 'sold')
            ->where('created_at', '>=', $rangeDate)
            ->get();

        $this->averagePrice = $sales->avg('price') ?? 0;
        $this->unitsSold = $sales->count();
        $this->owners = Sale::where('item_id', $this->item->id)->distinct('user_id')->count('user_id');
    }

    public function render()
    {
        $author = User::find($this->item->author);

        return view('livewire.item-detail', [
            'author' => $author,
        ]);
    }
}
