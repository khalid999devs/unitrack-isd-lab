@props([
    'role' => 'student',
    'active' => 'dashboard',
])

@php
    $roleLabel = ucfirst($role);
    $items = [
        'student' => [
            ['key' => 'dashboard', 'label' => 'Dashboard', 'href' => route('student.dashboard'), 'icon' => 'layout-dashboard'],
            ['key' => 'profile', 'label' => 'Profile', 'href' => route('student.profile'), 'icon' => 'user-circle'],
            ['key' => 'courses', 'label' => 'Courses', 'href' => route('student.courses'), 'icon' => 'book-2'],
            ['key' => 'routine', 'label' => 'Routine', 'href' => route('student.routine'), 'icon' => 'calendar-event'],
            ['key' => 'notices', 'label' => 'Notices', 'href' => route('student.notices'), 'icon' => 'bell'],
            ['key' => 'materials', 'label' => 'Materials', 'href' => route('student.materials'), 'icon' => 'files'],
            ['key' => 'assignments', 'label' => 'Assignments', 'href' => route('student.assignments'), 'icon' => 'clipboard-list'],
        ],
        'teacher' => [
            ['key' => 'dashboard', 'label' => 'Dashboard', 'href' => route('teacher.dashboard'), 'icon' => 'layout-dashboard'],
            ['key' => 'profile', 'label' => 'Profile', 'href' => route('teacher.profile'), 'icon' => 'user-circle'],
            ['key' => 'courses', 'label' => 'Assigned Courses', 'href' => route('teacher.courses'), 'icon' => 'book-2'],
            ['key' => 'routine', 'label' => 'Routine', 'href' => route('teacher.routine'), 'icon' => 'calendar-event'],
            ['key' => 'materials', 'label' => 'Materials', 'href' => route('teacher.materials'), 'icon' => 'files'],
            ['key' => 'assignments', 'label' => 'Assignments', 'href' => route('teacher.assignments'), 'icon' => 'clipboard-list'],
            ['key' => 'notices', 'label' => 'Notices', 'href' => route('teacher.notices'), 'icon' => 'bell'],
        ],
        'admin' => [
            ['key' => 'dashboard', 'label' => 'Dashboard', 'href' => route('admin.dashboard'), 'icon' => 'layout-dashboard'],
            ['key' => 'students', 'label' => 'Students', 'href' => route('admin.students'), 'icon' => 'users'],
            ['key' => 'teachers', 'label' => 'Teachers', 'href' => route('admin.teachers'), 'icon' => 'user-star'],
            ['key' => 'courses', 'label' => 'Courses', 'href' => route('admin.courses'), 'icon' => 'book-2'],
            ['key' => 'routines', 'label' => 'Routines', 'href' => route('admin.routines'), 'icon' => 'calendar-stats'],
            ['key' => 'notices', 'label' => 'Notices', 'href' => route('admin.notices'), 'icon' => 'bell'],
        ],
    ][$role] ?? [];

    $dashboardHref = $items[0]['href'] ?? route('login');
@endphp

<aside class="bg-[#3B5BDB] px-4 py-5 text-white lg:min-h-screen lg:w-[260px] lg:shrink-0">
    <div class="flex items-center justify-between lg:block">
        <div>
            <a href="{{ $dashboardHref }}" class="text-xl font-bold uppercase tracking-[0.2em]">
                <span class="text-white">UNI</span><span class="text-blue-100">TRACK</span>
            </a>
            <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-blue-200">{{ $roleLabel }} Panel</p>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="lg:hidden">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-white/40 px-3 py-2 text-sm font-semibold text-white">
                <i class="ti ti-logout text-base"></i>
                Logout
            </button>
        </form>
    </div>

    <nav class="mt-6 grid gap-1 sm:grid-cols-2 lg:grid-cols-1">
        @foreach ($items as $item)
            <a
                href="{{ $item['href'] }}"
                class="{{ $active === $item['key'] ? 'bg-white text-[#3B5BDB]' : 'text-white hover:bg-white/10 hover:text-white' }} inline-flex items-center gap-3 rounded-[10px] px-4 py-3 text-sm font-semibold transition"
            >
                <i class="ti ti-{{ $item['icon'] }} text-base"></i>
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
</aside>
