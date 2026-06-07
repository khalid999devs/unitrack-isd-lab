@props([
    'type' => 'info',
])

@php
    $classes = [
        'success' => 'border-success-border bg-success-bg text-success-text',
        'error' => 'border-error-border bg-error-bg text-error-text',
        'warning' => 'border-warning-border bg-warning-bg text-warning-text',
        'info' => 'border-info-border bg-info-bg text-info-text',
    ][$type] ?? 'border-info-border bg-info-bg text-info-text';
@endphp

<div {{ $attributes->merge(['class' => $classes.' rounded-xl border px-4 py-3 text-sm font-medium']) }}>
    {{ $slot }}
</div>
