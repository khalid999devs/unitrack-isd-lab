@props([
    'id' => 'modal',
    'title' => 'Confirmation',
    'message' => 'Are you sure?',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'confirmAction' => '#',
])

<div
    id="{{ $id }}"
    class="hidden fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50 px-4 py-10 flex"
>
    <div class="w-full max-w-sm rounded-2xl border border-border-soft bg-card-bg p-6 shadow-auth-card">
        <h3 class="text-lg font-bold text-main-text">{{ $title }}</h3>
        <p class="mt-2 text-sm text-secondary-text">{{ $message }}</p>

        {{ $slot }}

        <div class="mt-6 flex gap-3 sm:flex-row-reverse">
            <form action="{{ $confirmAction }}" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-error text-on-primary hover:bg-danger-hover rounded-[10px] px-4 py-2 text-sm font-bold transition">
                    {{ $confirmText }}
                </button>
            </form>
            <button
                type="button"
                onclick="document.getElementById('{{ $id }}').classList.add('hidden')"
                class="flex-1 border border-input-border bg-card-bg text-secondary-action-text hover:bg-muted-bg rounded-[10px] px-4 py-2 text-sm font-bold transition"
            >
                {{ $cancelText }}
            </button>
        </div>
    </div>
</div>
