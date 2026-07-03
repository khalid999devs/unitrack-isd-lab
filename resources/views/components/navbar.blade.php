@props([
    'title' => 'Dashboard',
    'role' => 'student',
])

@php
    $user = auth()->user();
    $displayName = $user?->name ?? ucfirst($role).' User';
    $nameParts = preg_split('/\s+/', trim($displayName)) ?: [];
    $initials = strtoupper(substr($nameParts[0] ?? ucfirst($role), 0, 1).substr($nameParts[1] ?? '', 0, 1));
    $roleClasses = 'bg-[#3B5BDB] text-white';
@endphp

<header class="border-b border-blue-100 bg-card-bg">
    <div class="mx-auto flex min-h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <div>
            <h1 class="text-xl font-bold text-main-text sm:text-2xl">{{ $title }}</h1>
            <p class="text-sm text-secondary-text">Student Academic Resource Management System</p>
        </div>

        <div class="hidden items-center gap-2 sm:flex">
            <div class="flex items-center gap-2">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary-blue text-xs font-bold text-white shadow-sm" title="{{ $displayName }}{{ $user?->email ? ' - '.$user->email : '' }}">
                    {{ $initials }}
                </div>
                <div class="hidden min-w-0 xl:block">
                    <p class="max-w-36 truncate text-sm font-bold text-main-text">{{ $displayName }}</p>
                </div>
            </div>
            <span class="{{ $roleClasses }} inline-flex h-9 items-center rounded-full px-4 text-xs font-bold uppercase tracking-wide">
                {{ ucfirst($role) }}
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex h-9 items-center gap-2 rounded-lg border border-red-200 px-3 text-xs font-semibold text-red-600 transition hover:bg-red-50">
                    <i class="ti ti-logout text-sm"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>
