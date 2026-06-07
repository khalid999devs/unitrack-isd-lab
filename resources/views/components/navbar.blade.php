@props([
    'title' => 'Dashboard',
    'role' => 'student',
])

<header class="border-b border-border-soft bg-white">
    <div class="mx-auto flex min-h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <div>
            <h1 class="text-xl font-bold text-main-text sm:text-2xl">{{ $title }}</h1>
            <p class="text-sm text-secondary-text">Student Academic Resource Management System</p>
        </div>

        <div class="hidden items-center gap-3 sm:flex">
            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold uppercase text-primary-blue">
                {{ ucfirst($role) }}
            </span>
            <a href="{{ route('login') }}" class="text-sm font-semibold text-secondary-text hover:text-primary-blue">
                Login
            </a>
        </div>
    </div>
</header>
