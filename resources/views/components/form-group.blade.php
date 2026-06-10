@props([
    'title' => null,
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card']) }}>
    @if ($title || $description)
        <div class="mb-6">
            @if ($title)
                <h2 class="text-lg font-bold text-main-text">{{ $title }}</h2>
            @endif
            @if ($description)
                <p class="mt-1 text-sm text-secondary-text">{{ $description }}</p>
            @endif
        </div>
    @endif

    {{ $slot }}
</div>
