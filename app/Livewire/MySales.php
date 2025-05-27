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
            ->get();
    }

    public function render()
    {
        return view('livewire.my-sales');
    }
}
