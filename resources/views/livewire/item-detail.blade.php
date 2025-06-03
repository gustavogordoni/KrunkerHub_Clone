<div class="p-6 bg-white text-black dark:bg-gray-900 dark:text-white min-h-screen">
    <div class="flex flex-col md:flex-row md:items-start gap-6">

        @php
            $classColor = match ($item->rarity) {
                'Uncommon' => 'text-green-500',
                'Rare' => 'text-blue-500',
                'Epic' => 'text-purple-500',
                'Legendary' => 'text-yellow-400',
                'Relic' => 'text-red-500',
                'Contraband' => 'text-black dark:white',
                'Unobtainable' => 'rainbowText',
                default => '',
            };
            $borderColor = match ($item->rarity) {
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

        <div class="w-full md:w-1/4 bg-gray-800 rounded p-4 text-center border-4 {{ $borderColor }} my-auto">
            <img src="https://assets.krunker.io/textures/previews/weapons/weapon_2_6.png" alt="{{ $item->name }}"
                class="w-40 h-40 mx-auto">
        </div>

        <div class="w-full md:w-3/4 space-y-4">
            <div class="bg-gray-800 p-4 rounded">
                <h1 class="text-3xl font-bold mt-2 {{ $classColor }}">{{ $item->name }}</h1>
                @if ($author)
                    <p>by <a href="#" class="text-sm text-blue-400">{{ $author->name }}</a></p>
                @endif
                <p class="text-sm">{{ ucfirst($item->category) }}</p>
                <p class="text-sm">Season {{ $item->season }}</p>
                <p class="text-xs italic">{{ $item->rarity }} - {{ $item->tag }}</p>

                <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 text-center text-sm">
                    <div>
                        <p class="font-bold text-green-500">{{ number_format($averagePrice) }} KR</p>
                        <p class="text-gray-400">Avg Price</p>
                    </div>
                    <div>
                        <p class="font-bold text-yellow-400">{{ number_format($minPrice) }} KR</p>
                        <p class="text-gray-400">Min Price</p>
                    </div>
                    <div>
                        <p class="font-bold text-red-400">{{ number_format($maxPrice) }} KR</p>
                        <p class="text-gray-400">Max Price</p>
                    </div>
                    <div>
                        <p class="font-bold text-blue-500">{{ $owners }}</p>
                        <p class="text-gray-400">Owners</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>