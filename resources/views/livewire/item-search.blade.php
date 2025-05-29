<div class="text-white font-['Press_Start_2P'] text-sm mb-2">
    <div class="flex justify-between bg-black dark:bg-gray-700 rounded-t-md px-2 py-1">
        <div></div>
        <span>Market Search</span>
        <button class="p-1 rounded bg-red-600" @click="$dispatch('close-item-search-modal')">X</button>
    </div>

    <div class="bg-gray-900 p-2 space-y-2 rounded-b-md">

        <div class="flex justify-between items-center mb-2">
            <label class="text-sm text-white">Filter/Sort</label>
            <select wire:model="sortField" class="text-xs bg-gray-800 border border-gray-600 rounded px-2 py-1">
                <option value="price">Lowest Price</option>
                <option value="name">Name</option>
            </select>
        </div>

        <div class="flex justify-between items-center mb-2">
            <label class="text-sm text-white">Season</label>
            <select wire:model="season" class="text-xs bg-gray-800 border border-gray-600 rounded px-2 py-1">
                <option value="">All Seasons</option>
                @for ($i = 1; $i <= 8; $i++)
                    <option value="{{ $i }}">Season {{ $i }}</option>
                @endfor
            </select>
        </div>


        <div class="space-y-1">
            <input type="text" wire:model="search" placeholder="Keyword: Sniper, Plasma, Wings"
                class="w-full px-2 py-1 text-xs bg-gray-800 text-white border border-gray-600 rounded" />
        </div>

        <div x-data="{ tab: 'rarities' }">
            <div class="flex justify-between space-x-1 mb-2">
                <button @click="tab = 'rarities'" class="px-2 py-1 bg-gray-700 rounded text-xs"
                    :class="{ 'bg-blue-600': tab === 'rarities' }">Rarities</button>
                <button @click="tab = 'weapons'" class="px-2 py-1 bg-gray-700 rounded text-xs"
                    :class="{ 'bg-blue-600': tab === 'weapons' }">Weapons</button>
                <button @click="tab = 'cosmetics'" class="px-2 py-1 bg-gray-700 rounded text-xs"
                    :class="{ 'bg-blue-600': tab === 'cosmetics' }">Cosmetics</button>
                <button wire:click="resetFilters"
                    class="ml-auto px-2 py-1 bg-blue-500 text-white text-xs rounded">Toggle</button>
            </div>

            <div x-show="tab === 'rarities'" class="space-y-1">
                @php
                    $rarityColors = [
                        'Uncommon' => [
                            'bg' => 'bg-green-500',
                            'text' => 'text-green-500',
                            'border' => 'border-green-500',
                        ],
                        'Rare' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-500', 'border' => 'border-blue-500'],
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
                        'Relic' => ['bg' => 'bg-red-500', 'text' => 'text-red-500', 'border' => 'border-red-500'],
                        'Contraband' => [
                            'bg' => 'bg-black',
                            'text' => 'text-black dark:text-white',
                            'border' => 'border-black dark:border-white',
                        ],
                        'Unobtainable' => ['bg' => 'rainbowBG', 'text' => 'rainbowText', 'border' => 'rainbowBorder'],
                    ];
                @endphp

                @foreach (['Unobtainable', 'Contraband', 'Relic', 'Legendary', 'Epic', 'Rare', 'Uncommon'] as $rarity)
                    @php
                        $bg = $rarityColors[$rarity]['bg'] ?? '';
                        $text = $rarityColors[$rarity]['text'] ?? '';
                    @endphp

                    <div class="flex justify-between items-center mb-1">
                        <span class="flex items-center space-x-2">
                            <span class="colCub {{ $bg }}"></span>
                            <span class="text-sm font-semibold {{ $text }}">{{ $rarity }}</span>
                        </span>
                        <input type="checkbox" wire:model="rarities" value="{{ $rarity }}" class="mr-2">
                    </div>
                @endforeach
            </div>

            <div x-show="tab === 'weapons'" class="space-y-1">
                @foreach (['Sniper Rifle', 'Assault Rifle', 'Pistol', 'Submachine Gun', 'Revolver', 'Shotgun', 'Machine Gun', 'Semi Auto', 'Rocket Launcher', 'Akimbo Uzi'] as $weapon)
                    <div class="flex justify-between items-center">
                        <span>{{ $weapon }}</span>
                        <input type="checkbox" wire:model="categories" value="{{ $weapon }}" class="mr-2">
                    </div>
                @endforeach
            </div>

            <div x-show="tab === 'cosmetics'" class="space-y-1">
                @foreach (['Hats', 'Body', 'Melee', 'Sprays', 'Dyes', 'Waist', 'Faces', 'Shoes', 'Pets', 'Collectibles', 'Wrist', 'Charms', 'Tickets', 'Back', 'Head', 'Playercards'] as $cosmetic)
                    <div class="flex justify-between items-center">
                        <span>{{ $cosmetic }}</span>
                        <input type="checkbox" wire:model="categories" value="{{ $cosmetic }}" class="mr-2">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-center mt-2 space-x-2">
            <button wire:click="$refresh" class="bg-green-500 :text-white px-4 py-1 rounded text-xs w-4/5">Search</button>
            <button wire:click="resetFilters" class="bg-red-500 text-white px-4 py-1 rounded text-xs">Reset</button>
        </div>
    </div>
</div>
