@php
    $role = 'admin';
    $title = 'Admin Dashboard';
    $active = 'dashboard';
    $adminName = auth()->user()?->name ?? 'Admin User';
    $overviewStats = [
        ['label' => 'Students', 'value' => $studentCount ?? 0, 'icon' => 'users', 'accent' => 'bg-primary-blue', 'surface' => 'bg-soft-blue-bg', 'text' => 'text-primary-blue'],
        ['label' => 'Teachers', 'value' => $teacherCount ?? 0, 'icon' => 'user-star', 'accent' => 'bg-indigo-accent', 'surface' => 'bg-violet-50', 'text' => 'text-indigo-accent'],
        ['label' => 'Courses', 'value' => $courseCount ?? 0, 'icon' => 'book-2', 'accent' => 'bg-success', 'surface' => 'bg-success-bg', 'text' => 'text-success-text'],
        ['label' => 'Routines', 'value' => $routineCount ?? 0, 'icon' => 'calendar-stats', 'accent' => 'bg-warning', 'surface' => 'bg-warning-bg', 'text' => 'text-warning-text'],
    ];
    $academicStats = [
        ['label' => 'Notices', 'value' => $noticeCount ?? 0, 'color' => 'bg-primary-blue'],
        ['label' => 'Study Materials', 'value' => $materialCount ?? 0, 'color' => 'bg-success'],
        ['label' => 'Assignments', 'value' => $assignmentCount ?? 0, 'color' => 'bg-warning'],
        ['label' => 'Submissions', 'value' => $submissionCount ?? 0, 'color' => 'bg-indigo-accent'],
    ];
    $maxAcademicValue = max(1, ...array_column($academicStats, 'value'));
@endphp

@extends('layouts.app')

@section('title', 'Admin Dashboard - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="overflow-hidden rounded-2xl border border-border-soft bg-primary-navy shadow-card">
            <div class="grid gap-6 p-6 lg:grid-cols-[1fr_360px] lg:p-7">
                <div class="min-w-0">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-200">Control Center</p>
                    <h2 class="mt-3 text-2xl font-bold text-white sm:text-3xl">Welcome back, {{ $adminName }}</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-blue-100">
                        Monitor the Minimum V1 academic data, verify module readiness, and jump into management areas.
                    </p>
                    <div class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                        @foreach ($overviewStats as $stat)
                            <div class="rounded-xl border border-white/10 bg-white/10 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/15 text-white">
                                        <i class="ti ti-{{ $stat['icon'] }} text-xl"></i>
                                    </div>
                                    <span class="h-2.5 w-2.5 rounded-full {{ $stat['accent'] }}"></span>
                                </div>
                                <p class="mt-4 text-3xl font-bold text-white">{{ $stat['value'] }}</p>
                                <p class="mt-1 text-xs font-bold uppercase tracking-wide text-blue-100">{{ $stat['label'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white p-5 shadow-lg">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-bold text-primary-navy">Academic Data Mix</p>
                            <p class="text-xs text-secondary-text">Live V1 records</p>
                        </div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-soft-blue-bg text-primary-blue">
                            <i class="ti ti-chart-bar text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-5 space-y-4">
                        @foreach ($academicStats as $stat)
                            @php
                                $width = max(8, round(($stat['value'] / $maxAcademicValue) * 100));
                            @endphp
                            <div>
                                <div class="mb-1 flex items-center justify-between gap-3">
                                    <span class="text-xs font-bold uppercase tracking-wide text-secondary-text">{{ $stat['label'] }}</span>
                                    <span class="text-sm font-bold text-main-text">{{ $stat['value'] }}</span>
                                </div>
                                <div class="h-3 overflow-hidden rounded-full bg-muted-bg">
                                    <div class="h-full rounded-full {{ $stat['color'] }}" style="width: {{ $width }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-card title="Total Notices" :value="$noticeCount ?? 0" description="Academic notices." icon="bell" />
            <x-card title="Study Materials" :value="$materialCount ?? 0" description="Uploaded resources." icon="files" />
            <x-card title="Assignments" :value="$assignmentCount ?? 0" description="Academic tasks." icon="clipboard-list" />
            <x-card title="Submissions" :value="$submissionCount ?? 0" description="Student assignment submissions." icon="upload" />
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
            <a href="{{ route('admin.students') }}" class="rounded-2xl border border-border-soft bg-white p-5 shadow-card transition hover:-translate-y-0.5 hover:border-primary-blue">
                <i class="ti ti-users text-2xl text-primary-blue"></i>
                <p class="mt-4 text-sm font-bold text-main-text">Students</p>
                <p class="mt-1 text-xs text-secondary-text">Manage accounts and academic profiles.</p>
            </a>
            <a href="{{ route('admin.teachers') }}" class="rounded-2xl border border-border-soft bg-white p-5 shadow-card transition hover:-translate-y-0.5 hover:border-indigo-accent">
                <i class="ti ti-user-star text-2xl text-indigo-accent"></i>
                <p class="mt-4 text-sm font-bold text-main-text">Teachers</p>
                <p class="mt-1 text-xs text-secondary-text">Maintain teacher records and contacts.</p>
            </a>
            <a href="{{ route('admin.courses') }}" class="rounded-2xl border border-border-soft bg-white p-5 shadow-card transition hover:-translate-y-0.5 hover:border-success">
                <i class="ti ti-book-2 text-2xl text-success"></i>
                <p class="mt-4 text-sm font-bold text-main-text">Courses</p>
                <p class="mt-1 text-xs text-secondary-text">Review course catalog and assignments.</p>
            </a>
            <a href="{{ route('admin.routines') }}" class="rounded-2xl border border-border-soft bg-white p-5 shadow-card transition hover:-translate-y-0.5 hover:border-warning">
                <i class="ti ti-calendar-stats text-2xl text-warning"></i>
                <p class="mt-4 text-sm font-bold text-main-text">Routines</p>
                <p class="mt-1 text-xs text-secondary-text">Inspect class schedules and rooms.</p>
            </a>
            <a href="{{ route('admin.notices') }}" class="rounded-2xl border border-border-soft bg-white p-5 shadow-card transition hover:-translate-y-0.5 hover:border-error">
                <i class="ti ti-bell text-2xl text-error"></i>
                <p class="mt-4 text-sm font-bold text-main-text">Notices</p>
                <p class="mt-1 text-xs text-secondary-text">Review announcements and updates.</p>
            </a>
        </section>
    </div>
@endsection
