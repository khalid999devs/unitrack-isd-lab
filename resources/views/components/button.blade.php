@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
])

@php
    $classes = [
        'primary' => 'bg-primary-blue text-on-primary hover:bg-royal-blue',
        'secondary' => 'border border-input-border bg-card-bg text-secondary-action-text hover:bg-muted-bg',
        'danger' => 'bg-error text-on-primary hover:bg-danger-hover',
    ][$variant] ?? 'bg-primary-blue text-on-primary hover:bg-royal-blue';

    $baseClasses = $classes.' inline-flex h-11 items-center justify-center rounded-[10px] px-4 text-sm font-bold transition focus:outline-none focus:ring-4 focus:ring-focus-ring';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $baseClasses]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $baseClasses]) }}>
        {{ $slot }}
    </button>
@endif
