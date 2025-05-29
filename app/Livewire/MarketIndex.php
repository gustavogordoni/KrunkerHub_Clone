<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Sale;
use Livewire\Component;

class MarketIndex extends Component
{
    public $rarities = [];
    public $categories = [];
    public $seasons = [];
    public $authors = [];
    
    public $search = '';

    public $showFilterModal = false;

    public $activeTab = 'rarities';

    public $rarityColors = [
        'Uncommon' => [
            'bg' => 'bg-green-500',
            'text' => 'text-green-500',
            'border' => 'border-green-500',
        ],
        'Rare' => [
            'bg' => 'bg-blue-500',
            'text' => 'text-blue-500',
            'border' => 'border-blue-500',
        ],
        'Epic' => [
            'bg' => 'bg-purple-500',
            'text' => 'text-purple-500',
            'border' => 'border-purple-500',
        ],
        'Legendary' => [
            'bg' => 'bg-yellow-400',
            'text' => 'text-yellow-400',
            'border' => 'border-yellow-400',
        ],
        'Relic' => [
            'bg' => 'bg-red-500',
            'text' => 'text-red-500',
            'border' => 'border-red-500',
        ],
        'Contraband' => [
            'bg' => 'bg-black',
            'text' => 'text-black',
            'border' => 'border-black',
        ],
        'Unobtainable' => [
            'bg' => 'rainbowBG',
            'text' => 'rainbowText',
            'border' => 'rainbowBorder',
        ],
    ];

    public function mount()
    {
        
    }

    public function getSalesProperty()
    {
        return Sale::with('item')
            ->where('status', 'on_sale')
            ->when(
                count($this->rarities),
                fn($query) => $query->whereHas('item', fn($q) => $q->whereIn('rarity', $this->rarities))
            )
            ->when(
                count($this->categories),
                fn($query) => $query->whereHas('item', fn($q) => $q->whereIn('category', $this->categories))
            )
            ->when(
                count($this->seasons),
                fn($query) => $query->whereHas('item', fn($q) => $q->whereIn('season', $this->seasons))
            )
            ->when(
                count($this->authors),
                fn($query) => $query->whereHas('item', fn($q) => $q->whereIn('author', $this->authors))
            )
            ->when(
                $this->search,
                fn($query) => $query->whereHas('item', fn($q) => $q->where('name', 'like', '%' . $this->search . '%')                )
            )
            ->get();
    }

    public function resetFilters()
    {
        $this->rarities = [];
        $this->categories = [];
        $this->seasons = [];
        $this->authors = [];
        $this->search = '';
    }

    public function tabs($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.market-index', [
            'sales' => $this->sales,
        ]);
    }
}
