@props([
    'title' => 'Dashboard',
    'role' => 'student',
])

@php
    $roleClasses = 'bg-[#3B5BDB] text-white';
@endphp

<header class="border-b border-blue-100 bg-card-bg">
    <div class="mx-auto flex min-h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <div>
            <h1 class="text-xl font-bold text-main-text sm:text-2xl">{{ $title }}</h1>
            <p class="text-sm text-secondary-text">Student Academic Resource Management System</p>
        </div>

        <div class="hidden items-center gap-3 sm:flex">
            <span class="{{ $roleClasses }} rounded-full px-3 py-1 text-xs font-bold uppercase">
                {{ ucfirst($role) }}
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">
                    <i class="ti ti-logout text-sm"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>
