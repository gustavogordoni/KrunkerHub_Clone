<div class="p-6 bg-white text-black dark:bg-gray-900 dark:text-white min-h-screen">
    <h1 class="text-2xl font-bold mb-4">Inventory</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($items as $item)
            @php
                $classColor = match ($item->rarity) {
                    'Uncommon' => 'text-green-500',
                    'Rare' => 'text-blue-500',
                    'Epic' => 'text-purple-500',
                    'Legendary' => 'text-yellow-400',
                    'Relic' => 'text-red-500',
                    'Contraband' => 'text-black dark:text-white',
                    'Unobtainable' => 'rainbowText',
                    default => '',
                };
            @endphp
            <div class="bg-gray-100 dark:bg-gray-800 rounded shadow p-4">
                <img src="https://assets.krunker.io/textures/previews/weapons/weapon_2_6.png?build=fSwEfH0D9W0S93nf0DkA59ACuaTmQnlw"
                    alt="{{ $item->name }}" class="w-full h-48 object-contain mb-2">
                <h2 class="text-lg font-semibold">{{ $item->name }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-300">

                    <strong class="{{ $classColor }}">{{ $item->rarity }}</strong> | Season {{ $item->season }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $item->category }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300">Tag: {{ $item->tag ?? 'None' }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300 text-center"><strong>{{ $item->price }} KR</strong>
                </p>
            </div>
        @endforeach
    </div>
</div>
