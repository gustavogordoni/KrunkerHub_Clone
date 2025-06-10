<?php

namespace App\Livewire;

use App\Models\Sale;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MySales extends Component
{
    public $sales;

    public function mount()
    {
        $this->sales = Sale::with('item')
            ->where('user_id', Auth::id())
            ->get()->sortBy(function ($item) {
                $rarityOrder = [
                    'Unobtainable' => 1,
                    'Contraband' => 2,
                    'Relic' => 3,
                    'Legendary' => 4,
                    'Epic' => 5,
                    'Rare' => 6,
                    'Uncommon' => 7,
                ];

                return [$rarityOrder[$item->item->rarity], $item->price];
            });
    }

    public function render()
    {
        return view('livewire.my-sales');
    }

    public function unlistItem($id)
    {
        if (!is_numeric($id)) {
            abort(404, 'Item não encontrado.');
        }

        Sale::where('item_id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        Auth::user()->items()->attach($id);

        $this->mount();
    }
}
