<div class="p-6 bg-white text-black dark:bg-gray-900 dark:text-white min-h-screen">
    @if (!$showFilterModal)
        <h1 class="text-2xl font-bold mb-4 flex justify-between items-center">
            Market
            <button wire:click="$toggle('showFilterModal')" class="bg-blue-600 text-white px-4 py-2 rounded">
                Search
            </button>
        </h1>
    @endif

    @if ($showFilterModal)
        <div class="text-white text-sm mb-2 w-1/3 mx-auto" x-data="{ tab: 'rarities' }">

            <div class="w-full flex justify-end">
                <button class="py-2 px-3 rounded bg-red-600" wire:click="$toggle('showFilterModal')">X</button>
            </div>

            <form wire:submit.prevent="search">
                <div class="bg-gray-100 dark:bg-gray-800 text-black dark:text-white p-2 space-y-2 rounded-b-md">

                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm">Filter/Sort</label>
                        <select wire:model.live="sortField"
                            class="text-xs bg-gray-400 dark:bg-gray-700 border border-gray-500 rounded px-2 py-1">
                            <option value="low">Lowest Price</option>
                            <option value="high">Highest Price</option>
                        </select>
                    </div>

                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm">Season</label>
                        <select wire:model.live="season"
                            class="text-xs bg-gray-400 dark:bg-gray-700 border border-gray-500 rounded px-2 py-1">
                            <option value="">All Seasons</option>
                            @for ($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}">Season {{ $i }}</option>
                            @endfor
                        </select>
                    </div>


                    <div class="space-y-1">
                        <input type="text" wire:model.live="search" placeholder="Keyword: Sniper, Plasma, Wings"
                            class="w-full px-2 py-1 text-xs bg-gray-100 dark:bg-gray-800 border border-gray-500 rounded" />
                    </div>

                    <div>
                        <div class="flex justify-between space-x-1 mb-2">
                            <button wire:click="tabs('rarities')"
                                class="px-2 py-1 bg-gray-400 dark:bg-gray-700 rounded text-xs">Rarities</button>
                            <button wire:click="tabs('weapons')"
                                class="px-2 py-1 bg-gray-400 dark:bg-gray-700 rounded text-xs">Weapons</button>
                            <button wire:click="tabs('cosmetics')"
                                class="px-2 py-1 bg-gray-400 dark:bg-gray-700 rounded text-xs">Cosmetics</button>
                            <button wire:click="toggleFilters"
                                class="ml-auto px-2 py-1 bg-blue-500 text-white text-xs rounded">Toggle</button>
                        </div>

                        @if ($activeTab == 'rarities')
                            <div class="space-y-1">
                                @foreach (['Unobtainable', 'Contraband', 'Relic', 'Legendary', 'Epic', 'Rare', 'Uncommon'] as $rarity)
                                    @php
                                        $bg = $rarityColors[$rarity]['bg'] ?? '';
                                        $text = $rarityColors[$rarity]['text'] ?? '';
                                    @endphp

                                    <div class="flex justify-between items-center mb-1">
                                        <span class="flex items-center space-x-2">
                                            <span class="colCub {{ $bg }}"></span>
                                            <span
                                                class="text-sm font-semibold {{ $text }}">{{ $rarity }}</span>
                                        </span>
                                        <input type="checkbox" wire:model.live="rarities" value="{{ $rarity }}"
                                            class="mr-2">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if ($activeTab == 'weapons')
                            <div class="space-y-1">
                                @foreach (['Sniper Rifle', 'Assault Rifle', 'Pistol', 'Submachine Gun', 'Revolver', 'Shotgun', 'Machine Gun', 'Semi Auto', 'Rocket Launcher', 'Akimbo Uzi'] as $weapon)
                                    <div class="flex justify-between items-center">
                                        <span>{{ $weapon }}</span>
                                        <input type="checkbox" wire:model.live="categories" value="{{ $weapon }}"
                                            class="mr-2">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if ($activeTab == 'cosmetics')
                            <div class="space-y-1">
                                @foreach (['Hats', 'Body', 'Melee', 'Sprays', 'Dyes', 'Waist', 'Faces', 'Shoes', 'Pets', 'Collectibles', 'Wrist', 'Charms', 'Tickets', 'Back', 'Head', 'Playercards'] as $cosmetic)
                                    <div class="flex justify-between items-center">
                                        <span>{{ $cosmetic }}</span>
                                        <input type="checkbox" wire:model.live="categories" value="{{ $cosmetic }}"
                                            class="mr-2">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-center mt-2 space-x-2">
                        <button type="submit" wire:click="$set('showFilterModal', false)"
                            class="bg-green-500 text-white px-4 py-1 rounded text-xs w-4/5">Search</button>
                        <button wire:click="resetFilters" class="bg-red-500 text-white px-4 py-1 rounded text-xs">
                            Reset
                        </button>

                    </div>
                </div>
            </form>
        </div>
    @endif

    @if (!$showFilterModal)
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-3 mt-6">
            @foreach ($sales as $sale)
                @php
                    $classColor = match ($sale->item->rarity) {
                        'Uncommon' => 'text-green-500',
                        'Rare' => 'text-blue-500',
                        'Epic' => 'text-purple-500',
                        'Legendary' => 'text-yellow-400',
                        'Relic' => 'text-red-500',
                        'Contraband' => 'text-black dark:white',
                        'Unobtainable' => 'rainbowText',
                        default => '',
                    };
                    $borderColor = match ($sale->item->rarity) {
                        'Uncommon' => 'border-green-500',
                        'Rare' => 'border-blue-500',
                        'Epic' => 'border-purple-500',
                        'Legendary' => 'border-yellow-400',
                        'Relic' => 'border-red-500',
                        'Contraband' => 'border-black dark:white',
                        'Unobtainable' => 'rainbowBorder',
                        default => '',
                    };
                @endphp
                <div class="bg-gray-100 dark:bg-gray-800 rounded shadow p-2 border-4 {{ $borderColor }}">
                    <h2 class="text-xl text-center {{ $classColor }}"><strong>{{ $sale->item->name }}</strong>
                    </h2>
                    <h3 class="text text-gray-600 text-center dark:text-gray-300">{{ $sale->item->category }}</h3>
                    <img src="https://assets.krunker.io/textures/previews/weapons/weapon_2_6.png"
                        alt="{{ $sale->item->name }}" class="w-full h-48 object-contain mb-2">
                    <p class="text-gray-600 dark:text-gray-300 text-center">
                        <strong class="text-lg">{{ number_format($sale->price) }} KR</strong>
                    </p>
                    <div class="block w-full text-center">
                        <a href="" class="p-1 m-1 rounded">Purchase</a>
                        <a href="" class="p-1 m-1 rounded">Search</a>
                        <a href="" class="p-1 m-1 rounded">Share</a>
                        <a href="" class="p-1 m-1 rounded">Info</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-5">
            {{ $sales->links() }}
        </div>
    @endif
</div>
