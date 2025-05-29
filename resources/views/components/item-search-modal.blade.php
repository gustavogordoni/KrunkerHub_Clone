@props(['show' => false])

<div x-data="{ show: @js($show) }" x-show="show" @open-item-search-modal.window="show = true"
    @close-item-search-modal.window="show = false" x-on:keydown.escape.window="show = false"
    class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

    <div class="fixed inset-0 bg-black bg-opacity-60 dark:bg-gray-900 dark:bg-opacity-75" @click="show = false"></div>

    <div class="relative mx-auto mt-10 bg-white dark:bg-gray-900 rounded-lg shadow-xl w-full max-w-sm p-4 overflow-y-auto max-h-[90vh]"
        x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
        {{ $slot }}
    </div>
</div>
