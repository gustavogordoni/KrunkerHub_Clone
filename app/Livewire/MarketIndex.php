<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;

use function Laravel\Prompts\search;

class MarketIndex extends Component
{
    use WithPagination;

    public $rarities = [];
    public $categories = [];
    public $season = 0;
    public $authors = [];
    public $sortField = '';

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

    public function search()
    {
        $this->showFilterModal = false;
    }

    public function getSalesProperty()
    {
        $query = Sale::with('item')
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
                $this->season,
                fn($query) => $query->whereHas('item', fn($q) => $q->where('season', $this->season))
            )
            ->when(
                $this->search,
                fn($query) => $query->whereHas('item', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            );

        if ($this->sortField == 'low') {
            $query->orderBy('price', 'asc');
        } elseif ($this->sortField == 'high') {
            $query->orderBy('price', 'desc');
        }

        return $query->paginate(30);
    }

    public function resetFilters()
    {
        $this->rarities = [];
        $this->categories = [];
        $this->season = 0;
        $this->search = '';
        $this->sortField = '';
        $this->activeTab = 'rarities';
    }

    public function toggleFilters()
    {
        $this->{$this->activeTab} = [];
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
