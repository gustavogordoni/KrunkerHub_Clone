@props(['label', 'value'])

<div>
    <p class="text-gray-400">{{ $label }}</p>
    <p class="font-bold">{{ is_numeric($value) ? number_format($value) : $value }}</p>
</div>