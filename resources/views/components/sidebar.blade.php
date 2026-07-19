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
            ['key' => 'registration-requests', 'label' => 'Registrations', 'href' => route('admin.registration-requests'), 'icon' => 'user-plus'],
            ['key' => 'students', 'label' => 'Students', 'href' => route('admin.students'), 'icon' => 'users'],
            ['key' => 'teachers', 'label' => 'Teachers', 'href' => route('admin.teachers'), 'icon' => 'user-star'],
            ['key' => 'courses', 'label' => 'Courses', 'href' => route('admin.courses'), 'icon' => 'book-2'],
            ['key' => 'routines', 'label' => 'Routines', 'href' => route('admin.routines'), 'icon' => 'calendar-stats'],
            ['key' => 'notices', 'label' => 'Notices', 'href' => route('admin.notices'), 'icon' => 'bell'],
            ['key' => 'materials', 'label' => 'Materials', 'href' => route('admin.materials'), 'icon' => 'files'],
            ['key' => 'assignments', 'label' => 'Assignments', 'href' => route('admin.assignments'), 'icon' => 'clipboard-list'],
        ],
    ][$role] ?? [];

    $dashboardHref = $items[0]['href'] ?? route('login');
@endphp

<aside class="bg-primary-navy px-4 py-4 text-on-primary lg:sticky lg:top-0 lg:h-screen lg:w-[260px] lg:shrink-0 lg:overflow-y-auto lg:py-5">
    <div class="flex items-center justify-between gap-3">
        <div>
            <a href="{{ $dashboardHref }}" class="text-xl font-bold uppercase tracking-[0.2em]">
                <span class="text-on-primary">UNI</span><span class="text-info-border">TRACK</span>
            </a>
            <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-sidebar-text">{{ $roleLabel }} Panel</p>
        </div>
        <div class="flex items-center gap-2 lg:hidden">
            <button
                type="button"
                data-sidebar-toggle
                aria-controls="role-sidebar-navigation"
                aria-expanded="false"
                aria-label="Open navigation"
                class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-sidebar-divider text-on-primary transition hover:bg-sidebar-hover-bg"
            >
                <i class="ti ti-menu-2 text-xl" aria-hidden="true"></i>
            </button>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" aria-label="Logout" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-sidebar-divider text-on-primary transition hover:bg-sidebar-hover-bg">
                    <i class="ti ti-logout text-lg" aria-hidden="true"></i>
                </button>
            </form>
        </div>
    </div>

    <nav id="role-sidebar-navigation" class="mt-5 hidden gap-1 lg:grid">
        @foreach ($items as $item)
            <a
                href="{{ $item['href'] }}"
                @if ($active === $item['key']) aria-current="page" @endif
                class="{{ $active === $item['key'] ? 'bg-primary-blue text-on-primary' : 'text-sidebar-text hover:bg-sidebar-hover-bg hover:text-on-primary' }} inline-flex min-h-11 items-center gap-3 rounded-[10px] px-4 py-3 text-sm font-semibold transition"
            >
                <i class="ti ti-{{ $item['icon'] }} text-base" aria-hidden="true"></i>
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
</aside>

<script>
    document.querySelector('[data-sidebar-toggle]')?.addEventListener('click', (event) => {
        const navigation = document.getElementById('role-sidebar-navigation');
        const isOpening = navigation.classList.contains('hidden');

        navigation.classList.toggle('hidden');
        event.currentTarget.setAttribute('aria-expanded', String(isOpening));
        event.currentTarget.setAttribute('aria-label', isOpening ? 'Close navigation' : 'Open navigation');
        event.currentTarget.querySelector('i').className = isOpening ? 'ti ti-x text-xl' : 'ti ti-menu-2 text-xl';
    });
</script>
