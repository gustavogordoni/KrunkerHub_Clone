<div class="p-6 bg-white text-black dark:bg-gray-900 dark:text-white min-h-screen">
    <h1 class="text-2xl font-bold mb-4">Inventory</h1>
    <p>Items: {{ count($items) }} / {{ $itemsTotal }}</p>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-3">
        @forelse ($items as $item)
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
            <div wire:key="item-{{ $item->id }}"
                class="bg-gray-100 dark:bg-gray-800 rounded shadow p-2 border-4 {{ $borderColor }}">
                <h2 class="text-xl text-center {{ $classColor }}"><strong>{{ $item->name }}</strong></h2>
                <h3 class="text text-gray-600 text-center dark:text-gray-300">{{ $item->category }}</h3>
                <img src="{{ $item->image_path }}" alt="{{ $item->name }}" class="w-full h-48 object-contain mb-2">
                <p class="text-gray-600 dark:text-gray-300 text-center">
                    <strong class="text-lg">{{ number_format($item->market_avg_price) }} KR</strong>
                </p>
                <div class="block w-full text-center">
                    <button wire:click="selectItem({{ $item->id }})"
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" type="button"
                        class="p-1 m-1 rounded">List</button>


                    <a href="{{ route('item.show', $item->id) }}" class="p-1 m-1 rounded">Info</a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-gray-800 text-white p-6 rounded text-center">
                <h3 class="text-lg font-semibold">Você não possui itens em seu inventário.</h3>
                <p class="text-sm text-gray-400 mt-1">Adquira itens no mercado para que apareçam aqui.</p>
            </div>
        @endforelse

        <x-modal name="confirm-user-deletion" :show="$selectedItem !== null" focusable x-data
            x-on:close-modal.window="$dispatch('close')">
            <div class="p-6">
                @if ($selectedItem)
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Listar item para venda
                    </h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <strong>Nome:</strong> {{ $selectedItem['name'] }} <br>
                        <strong>Categoria:</strong> {{ $selectedItem['category'] }} <br>
                        <strong>Raridade:</strong> {{ $selectedItem['rarity'] }}
                    </p>

                    <div class="mt-4">
                        <x-input-label for="price" value="Preço (KR)" />
                        <x-text-input id="price" wire:model.defer="selectedPrice" type="number"
                            class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('selectedPrice')" class="mt-2" />

                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            Cancelar
                        </x-secondary-button>

                        <x-danger-button class="ml-3" wire:click="listSelectedItem">
                            Listar
                        </x-danger-button>
                    </div>
                @endif
            </div>
        </x-modal>

    </div>
</div>
