@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
])

@php
    $classes = [
        'primary' => 'bg-primary-blue text-white hover:bg-royal-blue',
        'secondary' => 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-100',
        'danger' => 'bg-error text-white hover:bg-red-700',
    ][$variant] ?? 'bg-primary-blue text-white hover:bg-royal-blue';

    $baseClasses = $classes.' inline-flex h-11 items-center justify-center rounded-[10px] px-4 text-sm font-bold transition focus:outline-none focus:ring-4 focus:ring-blue-200';
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
