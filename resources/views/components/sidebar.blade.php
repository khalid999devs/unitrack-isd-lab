@props([
    'role' => 'student',
    'active' => 'dashboard',
])

@php
    $roleLabel = ucfirst($role);
    $items = [
        'student' => [
            ['key' => 'dashboard', 'label' => 'Dashboard', 'href' => route('student.dashboard')],
            ['key' => 'courses', 'label' => 'Courses', 'href' => '#'],
            ['key' => 'routine', 'label' => 'Routine', 'href' => '#'],
            ['key' => 'notices', 'label' => 'Notices', 'href' => '#'],
            ['key' => 'materials', 'label' => 'Materials', 'href' => '#'],
            ['key' => 'assignments', 'label' => 'Assignments', 'href' => '#'],
        ],
        'teacher' => [
            ['key' => 'dashboard', 'label' => 'Dashboard', 'href' => route('teacher.dashboard')],
            ['key' => 'courses', 'label' => 'Assigned Courses', 'href' => '#'],
            ['key' => 'routine', 'label' => 'Routine', 'href' => '#'],
            ['key' => 'materials', 'label' => 'Materials', 'href' => '#'],
            ['key' => 'assignments', 'label' => 'Assignments', 'href' => '#'],
            ['key' => 'notices', 'label' => 'Notices', 'href' => '#'],
        ],
        'admin' => [
            ['key' => 'dashboard', 'label' => 'Dashboard', 'href' => route('admin.dashboard')],
            ['key' => 'students', 'label' => 'Students', 'href' => '#'],
            ['key' => 'teachers', 'label' => 'Teachers', 'href' => '#'],
            ['key' => 'courses', 'label' => 'Courses', 'href' => '#'],
            ['key' => 'routines', 'label' => 'Routines', 'href' => '#'],
            ['key' => 'notices', 'label' => 'Notices', 'href' => '#'],
        ],
    ][$role] ?? [];
@endphp

<aside class="bg-primary-navy px-4 py-5 text-sidebar-text lg:min-h-screen lg:w-[260px] lg:shrink-0">
    <div class="flex items-center justify-between lg:block">
        <div>
            <a href="{{ route('login') }}" class="text-xl font-bold text-on-primary">UniTrack</a>
            <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-placeholder-text">{{ $roleLabel }} Panel</p>
        </div>
        <a href="{{ route('login') }}" class="rounded-lg border border-sidebar-divider px-3 py-2 text-sm font-semibold text-on-primary lg:hidden">
            Login
        </a>
    </div>

    <nav class="mt-6 grid gap-1 sm:grid-cols-2 lg:grid-cols-1">
        @foreach ($items as $item)
            <a
                href="{{ $item['href'] }}"
                class="{{ $active === $item['key'] ? 'bg-primary-blue text-on-primary' : 'text-sidebar-text hover:bg-sidebar-hover-bg hover:text-on-primary' }} rounded-[10px] px-4 py-3 text-sm font-semibold transition"
            >
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
</aside>
