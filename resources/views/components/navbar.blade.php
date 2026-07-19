@props([
    'title' => 'Dashboard',
    'role' => 'student',
])

@php
    $user = auth()->user();
    $displayName = $user?->name ?? ucfirst($role).' User';
    $nameParts = preg_split('/\s+/', trim($displayName)) ?: [];
    $initials = strtoupper(substr($nameParts[0] ?? ucfirst($role), 0, 1).substr($nameParts[1] ?? '', 0, 1));
    $roleClasses = match ($role) {
        'teacher' => 'bg-role-teacher-bg text-role-teacher-text',
        'admin' => 'bg-role-admin-bg text-role-admin-text',
        default => 'bg-role-student-bg text-role-student-text',
    };
    $profileHref = match ($role) {
        'teacher' => route('teacher.profile'),
        'student' => route('student.profile'),
        default => route('admin.dashboard'),
    };
@endphp

<header class="border-b border-info-border bg-card-bg">
    <div class="mx-auto flex min-h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <div>
            <h1 class="text-xl font-bold text-main-text sm:text-2xl">{{ $title }}</h1>
            <p class="text-sm text-secondary-text">Student Academic Resource Management System</p>
        </div>

        <div class="hidden items-center gap-2 sm:flex">
            <a href="{{ $profileHref }}" class="flex items-center gap-2 rounded-full outline-none transition focus:ring-4 focus:ring-focus-ring" aria-label="Open {{ $displayName }} profile">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary-blue text-xs font-bold text-on-primary shadow-sm" title="{{ $displayName }}{{ $user?->email ? ' - '.$user->email : '' }}">
                    {{ $initials }}
                </div>
                <div class="hidden min-w-0 lg:block">
                    <p class="max-w-36 truncate text-sm font-bold text-main-text">{{ $displayName }}</p>
                </div>
            </a>
            <span class="{{ $roleClasses }} inline-flex h-8 items-center rounded-full px-3 text-xs font-bold uppercase tracking-wide">
                {{ ucfirst($role) }}
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex h-9 items-center gap-2 rounded-lg border border-error-border px-3 text-xs font-semibold text-error transition hover:bg-error-bg">
                    <i class="ti ti-logout text-sm"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>
