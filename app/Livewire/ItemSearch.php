<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;

class ItemSearch extends Component
{
    public $search = '';
    public $season = '';
    public $rarities = [];
    public $categories = [];
    public $minPrice = null;
    public $maxPrice = null;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    public function resetFilters()
    {
        $this->reset(['search', 'season', 'rarities', 'categories', 'minPrice', 'maxPrice', 'sortField', 'sortDirection']);
    }

    public function render()
    {
        return view(
            'livewire.item-search',     
        );
    }
}
