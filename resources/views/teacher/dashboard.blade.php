@php
    $role = 'teacher';
    $title = 'Teacher Dashboard';
    $active = 'dashboard';
@endphp

@extends('layouts.app')

@section('title', 'Teacher Dashboard - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <x-card title="Assigned Courses" :value="$courseCount ?? 0" description="Courses assigned by admin." icon="book-2" />
            <x-card title="Today's Classes" :value="$todayClassCount ?? 0" description="Classes scheduled for today." icon="calendar-event" />
            <x-card title="Uploaded Materials" :value="$materialCount ?? 0" description="Study materials count." icon="files" />
            <x-card title="Active Assignments" :value="$assignmentCount ?? 0" description="Published academic tasks." icon="clipboard-list" />
            <x-card title="Posted Notices" :value="$noticeCount ?? 0" description="Announcements from your account." icon="bell" />
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <x-card title="Quick Actions" description="Publish course content" icon="settings">
                <div class="flex flex-wrap gap-3">
                    <x-button href="{{ route('teacher.materials.create') }}">Upload Material</x-button>
                    <x-button href="{{ route('teacher.assignments.create') }}">Create Assignment</x-button>
                    <x-button href="{{ route('teacher.notices.create') }}">Create Notice</x-button>
                </div>
            </x-card>

            <x-card title="Today's Schedule" description="Classes assigned to your profile" icon="calendar-event">
                <div class="space-y-3">
                    @forelse ($todayRoutines as $routine)
                        <div class="flex items-center justify-between gap-4 border-b border-border-soft pb-3 last:border-0 last:pb-0">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-bold text-main-text">{{ $routine->course->course_code }} · {{ $routine->course->course_title }}</p>
                                <p class="mt-1 text-xs text-secondary-text">{{ date('h:i A', strtotime($routine->start_time)) }} - {{ date('h:i A', strtotime($routine->end_time)) }}</p>
                            </div>
                            <x-badge variant="info">{{ $routine->room }}</x-badge>
                        </div>
                    @empty
                        <p class="text-sm text-secondary-text">No classes are scheduled for today.</p>
                    @endforelse
                </div>
                <x-button href="{{ route('teacher.routine') }}" variant="secondary" class="mt-5">Full Routine</x-button>
            </x-card>
        </section>

        <section class="grid gap-6 xl:grid-cols-3">
            <x-card title="Recent Materials" description="Your latest uploads" icon="files">
                <div class="space-y-3">
                    @forelse ($recentMaterials as $material)
                        <div class="border-b border-border-soft pb-3 last:border-0 last:pb-0">
                            <p class="truncate text-sm font-bold text-main-text">{{ $material->title }}</p>
                            <p class="mt-1 text-xs text-secondary-text">{{ $material->course->course_code }} · {{ $material->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-secondary-text">No materials uploaded yet.</p>
                    @endforelse
                </div>
                <x-button href="{{ route('teacher.materials') }}" variant="secondary" class="mt-5">Manage Materials</x-button>
            </x-card>

            <x-card title="Upcoming Assignments" description="Nearest deadlines" icon="clipboard-list">
                <div class="space-y-3">
                    @forelse ($upcomingAssignments as $assignment)
                        <div class="border-b border-border-soft pb-3 last:border-0 last:pb-0">
                            <p class="truncate text-sm font-bold text-main-text">{{ $assignment->title }}</p>
                            <p class="mt-1 text-xs text-secondary-text">{{ $assignment->course->course_code }} · {{ $assignment->deadline->format('d M, h:i A') }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-secondary-text">No upcoming assignments.</p>
                    @endforelse
                </div>
                <x-button href="{{ route('teacher.assignments') }}" variant="secondary" class="mt-5">Manage Assignments</x-button>
            </x-card>

            <x-card title="Latest Notices" description="Relevant announcements" icon="bell">
                <div class="space-y-3">
                    @forelse ($latestNotices as $notice)
                        <div class="border-b border-border-soft pb-3 last:border-0 last:pb-0">
                            <p class="truncate text-sm font-bold text-main-text">{{ $notice->title }}</p>
                            <p class="mt-1 text-xs text-secondary-text">{{ $notice->postedBy?->name ?? 'System' }} · {{ $notice->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-secondary-text">No notices are available.</p>
                    @endforelse
                </div>
                <x-button href="{{ route('teacher.notices') }}" variant="secondary" class="mt-5">View Notices</x-button>
            </x-card>
        </section>
    </div>
@endsection
