<div class="p-6 bg-white text-black dark:bg-gray-900 dark:text-white min-h-screen">
    <h1 class="text-2xl font-bold mb-4">My Sales</h1>
    <p>Items on sale: {{ count($sales) }}</p>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-3">
        @forelse ($sales as $sale)
            @php
                $item = $sale->item;
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
            <div class="bg-gray-100 dark:bg-gray-800 rounded shadow p-2 border-4 {{ $borderColor }}">
                <h2 class="text-xl text-center {{ $classColor }}"><strong>{{ $item->name }}</strong></h2>
                <h3 class="text text-gray-600 text-center dark:text-gray-300">{{ $item->category }}</h3>
                <img src="{{ $sale->item->image_path }}" alt="{{ $item->name }}"
                    class="w-full h-48 object-contain mb-2">
                <p class="text-gray-600 dark:text-gray-300 text-center">
                    <strong class="text-lg">{{ number_format($sale->price) }} KR</strong>
                </p>
                <div class="block w-full text-center">
                    <a href="#" wire:click="unlistItem({{ $item->id }})" class="p-1 m-1 rounded">Unlist</a>
                    <a href="{{ route('item.show', $item->id) }}" class="p-1 m-1 rounded">Info</a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-gray-800 text-white p-6 rounded text-center">
                <h3 class="text-lg font-semibold">Nenhum item à venda.</h3>
                <p class="text-sm text-gray-400 mt-1">Os itens do seu inventário colocados à venda aparecerão aqui.</p>
            </div>
        @endforelse
    </div>
</div>
