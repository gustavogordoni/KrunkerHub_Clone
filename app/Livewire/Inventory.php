<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Inventory extends Component
{
    public $items;

    public function mount()
    {
        $this->items = Auth::user()->items()->get();
    }

    public function render()
    {
        return view('livewire.inventory');
    }
}
