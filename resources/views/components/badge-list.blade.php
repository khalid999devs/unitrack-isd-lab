@props([
    'items' => [],
])

<div {{ $attributes->merge(['class' => 'flex flex-wrap gap-2']) }}>
    @foreach ($items as $item)
        <x-badge variant="{{ $item['variant'] ?? 'default' }}">
            {{ $item['label'] ?? $item }}
        </x-badge>
    @endforeach
</div>
