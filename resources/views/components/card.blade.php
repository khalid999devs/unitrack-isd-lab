@props([
    'title' => null,
    'description' => null,
    'value' => null,
    'icon' => null,
])

<section {{ $attributes->merge(['class' => 'rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card']) }}>
    @if ($title || $description || $value !== null)
        <div class="mb-4">
            @if ($icon)
                <div class="mb-4 inline-flex h-9 w-9 items-center justify-center rounded-lg bg-soft-blue-bg text-primary-blue">
                    <i class="ti ti-{{ $icon }} text-[20px]"></i>
                </div>
            @endif
            @if ($title)
                <h2 class="text-base font-bold text-main-text">{{ $title }}</h2>
            @endif
            @if ($description)
                <p class="mt-1 text-sm text-secondary-text">{{ $description }}</p>
            @endif
            @if ($value !== null)
                <p class="mt-3 text-3xl font-bold text-primary-blue">{{ $value }}</p>
            @endif
        </div>
    @endif

    {{ $slot }}
</section>
