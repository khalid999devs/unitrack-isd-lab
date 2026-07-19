@php
    $role = 'student';
    $title = 'Student Dashboard';
    $active = 'dashboard';
@endphp

@extends('layouts.app')

@section('title', 'Student Dashboard - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-card title="My Courses" :value="$courseCount ?? 0" description="Courses matched to your semester." icon="book-2" />
            <x-card title="Today's Classes" :value="$todayClassCount ?? 0" description="Classes scheduled for today." icon="calendar-event" />
            <x-card title="New Notices" :value="$noticeCount ?? 0" description="Announcements visible to students." icon="bell" />
            <x-card title="Upcoming Assignments" :value="$assignmentCount ?? 0" description="Open tasks for your courses." icon="clipboard-list" />
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <x-card title="Today's Schedule" description="Classes matched to your department, semester, and batch" icon="calendar-event">
                <div class="space-y-3">
                    @forelse ($todayRoutines as $routine)
                        <div class="flex items-center justify-between gap-4 border-b border-border-soft pb-3 last:border-0 last:pb-0">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-bold text-main-text">{{ $routine->course->course_code }} · {{ $routine->course->course_title }}</p>
                                <p class="mt-1 text-xs text-secondary-text">{{ date('h:i A', strtotime($routine->start_time)) }} - {{ date('h:i A', strtotime($routine->end_time)) }} · {{ $routine->room }}</p>
                            </div>
                            <x-badge variant="info">{{ $routine->day }}</x-badge>
                        </div>
                    @empty
                        <p class="text-sm text-secondary-text">No classes are scheduled for today.</p>
                    @endforelse
                </div>
                <x-button href="{{ route('student.routine') }}" variant="secondary" class="mt-5">Full Routine</x-button>
            </x-card>

            <x-card title="Upcoming Assignments" description="Next coursework deadlines" icon="clipboard-list">
                <div class="space-y-3">
                    @forelse ($upcomingAssignments as $assignment)
                        <div class="flex items-center justify-between gap-4 border-b border-border-soft pb-3 last:border-0 last:pb-0">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-bold text-main-text">{{ $assignment->title }}</p>
                                <p class="mt-1 text-xs text-secondary-text">{{ $assignment->course->course_code }}</p>
                            </div>
                            <span class="shrink-0 text-xs font-semibold text-warning-text">{{ $assignment->deadline->format('d M, h:i A') }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-secondary-text">No upcoming assignments.</p>
                    @endforelse
                </div>
                <x-button href="{{ route('student.assignments') }}" variant="secondary" class="mt-5">View Assignments</x-button>
            </x-card>
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <x-card title="Recent Materials" description="Latest files from your courses" icon="files">
                <div class="space-y-3">
                    @forelse ($recentMaterials as $material)
                        <div class="flex items-center gap-3 border-b border-border-soft pb-3 last:border-0 last:pb-0">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-soft-blue-bg text-primary-blue">
                                <i class="ti ti-file-text text-lg"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-bold text-main-text">{{ $material->title }}</p>
                                <p class="mt-1 text-xs text-secondary-text">{{ $material->course->course_code }} · {{ $material->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-secondary-text">No materials have been uploaded yet.</p>
                    @endforelse
                </div>
                <x-button href="{{ route('student.materials') }}" variant="secondary" class="mt-5">View Materials</x-button>
            </x-card>

            <x-card title="Latest Notices" description="Announcements visible to students" icon="bell">
                <div class="space-y-3">
                    @forelse ($latestNotices as $notice)
                        <div class="border-b border-border-soft pb-3 last:border-0 last:pb-0">
                            <p class="text-sm font-bold text-main-text">{{ $notice->title }}</p>
                            <p class="mt-1 line-clamp-2 text-xs leading-5 text-secondary-text">{{ $notice->description }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-secondary-text">No announcements are available.</p>
                    @endforelse
                </div>
                <x-button href="{{ route('student.notices') }}" variant="secondary" class="mt-5">View Notices</x-button>
            </x-card>
        </section>
    </div>
@endsection
