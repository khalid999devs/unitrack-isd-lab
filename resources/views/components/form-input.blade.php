@props([
    'name' => '',
    'label' => null,
    'type' => 'text',
    'placeholder' => null,
    'value' => null,
    'required' => false,
    'disabled' => false,
    'error' => null,
    'hint' => null,
])

<div class="mb-4">
    @if ($label)
        <label for="{{ $name }}" class="mb-2 block text-sm font-semibold text-main-text">
            {{ $label }}
            @if ($required)
                <span class="text-error">*</span>
            @endif
        </label>
    @endif

    @if ($type === 'textarea')
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            {{ $disabled ? 'disabled' : '' }}
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'min-h-24 w-full rounded-[10px] border px-3 py-2 text-sm outline-none transition placeholder:text-placeholder-text disabled:bg-muted-bg disabled:text-placeholder-text ' . ($error ? 'border-error focus:border-error focus:ring-4 focus:ring-red-100' : 'border-input-border focus:border-primary-blue focus:ring-4 focus:ring-focus-ring')]) }}
        >{{ $value }}</textarea>
    @elseif ($type === 'select')
        <select
            id="{{ $name }}"
            name="{{ $name }}"
            {{ $disabled ? 'disabled' : '' }}
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'h-11 w-full rounded-[10px] border px-3 text-sm outline-none transition disabled:bg-muted-bg disabled:text-placeholder-text ' . ($error ? 'border-error focus:border-error focus:ring-4 focus:ring-red-100' : 'border-input-border focus:border-primary-blue focus:ring-4 focus:ring-focus-ring')]) }}
        >
            {{ $slot }}
        </select>
    @else
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            {{ $disabled ? 'disabled' : '' }}
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'h-11 w-full rounded-[10px] border px-3 text-sm outline-none transition placeholder:text-placeholder-text disabled:bg-muted-bg disabled:text-placeholder-text ' . ($error ? 'border-error focus:border-error focus:ring-4 focus:ring-red-100' : 'border-input-border focus:border-primary-blue focus:ring-4 focus:ring-focus-ring')]) }}
        >
    @endif

    @if ($error)
        <p class="mt-1 text-xs font-medium text-error">{{ $error }}</p>
    @elseif ($hint)
        <p class="mt-1 text-xs text-secondary-text">{{ $hint }}</p>
    @endif
</div>
