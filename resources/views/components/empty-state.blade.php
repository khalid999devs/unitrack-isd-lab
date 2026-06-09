@props([
    'icon' => '📋',
    'title' => 'No Data',
    'message' => 'Nothing to display at the moment.',
])

<div {{ $attributes->merge(['class' => 'rounded-2xl border-2 border-dashed border-border-soft bg-muted-bg p-8 text-center']) }}>
    <div class="text-4xl">{{ $icon }}</div>
    <h3 class="mt-4 text-lg font-bold text-main-text">{{ $title }}</h3>
    <p class="mt-2 text-sm text-secondary-text">{{ $message }}</p>

    @if ($slot->isNotEmpty())
        <div class="mt-4">
            {{ $slot }}
        </div>
    @endif
</div>
