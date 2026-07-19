@php
    $role = 'teacher';
    $title = 'Assignments';
    $active = 'assignments';
@endphp

@extends('layouts.app')

@section('title', 'Assignments - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold text-main-text">Coursework and submissions</p>
                <p class="text-sm text-secondary-text">Create, update, close, and review assignments for your courses.</p>
            </div>
            <x-button href="{{ route('teacher.assignments.create') }}">
                <i class="ti ti-plus text-base"></i>
                Add Assignment
            </x-button>
        </section>

        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        <section class="rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card">
            <form method="GET" action="{{ route('teacher.assignments') }}" class="grid gap-3 lg:grid-cols-[1fr_220px_180px_auto] lg:items-end">
                <div>
                    <label for="assignment-search" class="mb-2 block text-sm font-semibold text-main-text">Search</label>
                    <input id="assignment-search" name="search" value="{{ request('search') }}" placeholder="Title or description" class="h-11 w-full rounded-[10px] border border-input-border px-3 text-sm outline-none transition placeholder:text-placeholder-text focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                </div>
                <div>
                    <label for="assignment-course" class="mb-2 block text-sm font-semibold text-main-text">Course</label>
                    <select id="assignment-course" name="course_id" class="h-11 w-full rounded-[10px] border border-input-border bg-card-bg px-3 text-sm outline-none focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                        <option value="">All courses</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @selected((string) request('course_id') === (string) $course->id)>{{ $course->course_code }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="assignment-deadline" class="mb-2 block text-sm font-semibold text-main-text">Deadline</label>
                    <select id="assignment-deadline" name="deadline" class="h-11 w-full rounded-[10px] border border-input-border bg-card-bg px-3 text-sm outline-none focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                        <option value="">All deadlines</option>
                        <option value="upcoming" @selected(request('deadline') === 'upcoming')>Upcoming</option>
                        <option value="past" @selected(request('deadline') === 'past')>Past</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <x-button type="submit">Filter</x-button>
                    @if (request()->hasAny(['search', 'course_id', 'deadline']))
                        <x-button href="{{ route('teacher.assignments') }}" variant="secondary">Clear</x-button>
                    @endif
                </div>
            </form>
        </section>

        @if ($assignments->isEmpty())
            <x-empty-state
                icon="clipboard-list"
                title="No Assignments Created"
                message="Create an assignment for one of your assigned courses."
            />
        @else
            <section class="grid gap-6 lg:grid-cols-2">
                @foreach ($assignments as $assignment)
                    <x-card class="h-full border-t-4 border-t-primary-blue">
                        <div class="flex h-full flex-col gap-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="text-lg font-bold text-main-text">{{ $assignment->title }}</h2>
                                    <p class="text-sm text-secondary-text">{{ $assignment->course->course_code }} - {{ $assignment->course->course_title }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-main-text">Due {{ $assignment->deadline->format('d M Y') }}</p>
                                    <p class="text-sm text-secondary-text">{{ $assignment->deadline->format('h:i A') }}</p>
                                    <x-badge :variant="$assignment->deadline->isPast() ? 'warning' : 'success'">{{ $assignment->deadline->isPast() ? 'Closed' : 'Open' }}</x-badge>
                                </div>
                            </div>

                            <p class="text-sm leading-6 text-secondary-text">{{ $assignment->description }}</p>

                            <div class="mt-auto flex flex-wrap justify-end gap-2">
                                <x-button href="{{ route('teacher.assignments.submissions', $assignment) }}" class="h-10">
                                    Submissions ({{ $assignment->submissions_count }})
                                </x-button>
                                <x-button href="{{ route('teacher.assignments.edit', $assignment) }}" variant="secondary" class="h-10">Edit</x-button>
                                <form method="POST" action="{{ route('teacher.assignments.destroy', $assignment) }}" onsubmit="return confirm('Delete this assignment and all submissions?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger" class="h-10">Delete</x-button>
                                </form>
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </section>
            @if ($assignments->hasPages())
                <div>{{ $assignments->links() }}</div>
            @endif
        @endif
    </div>
@endsection
