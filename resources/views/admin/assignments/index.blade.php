@php
    $role = 'admin';
    $title = 'Assignments Management';
    $active = 'assignments';
@endphp

@extends('layouts.app')

@section('title', 'Assignments Management - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold text-main-text">Coursework oversight</p>
                <p class="text-sm text-secondary-text">Manage assignments and inspect student submissions across courses.</p>
            </div>
            <x-button href="{{ route('admin.assignments.create') }}"><i class="ti ti-plus mr-2" aria-hidden="true"></i>Create Assignment</x-button>
        </section>

        @if (session('success'))<x-alert type="success">{{ session('success') }}</x-alert>@endif

        <section class="rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card">
            <form method="GET" action="{{ route('admin.assignments') }}" class="grid gap-3 lg:grid-cols-[1fr_240px_180px_auto] lg:items-end">
                <div>
                    <label for="assignment-search" class="mb-2 block text-sm font-semibold text-main-text">Search</label>
                    <input id="assignment-search" name="search" value="{{ request('search') }}" placeholder="Title, description, or course" class="h-11 w-full rounded-[10px] border border-input-border px-3 text-sm outline-none transition placeholder:text-placeholder-text focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                </div>
                <div>
                    <label for="assignment-course" class="mb-2 block text-sm font-semibold text-main-text">Course</label>
                    <select id="assignment-course" name="course_id" class="h-11 w-full rounded-[10px] border border-input-border bg-card-bg px-3 text-sm outline-none focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                        <option value="">All courses</option>
                        @foreach ($courses as $course)<option value="{{ $course->id }}" @selected((string) request('course_id') === (string) $course->id)>{{ $course->course_code }}</option>@endforeach
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
                    @if (request()->hasAny(['search', 'course_id', 'deadline']))<x-button href="{{ route('admin.assignments') }}" variant="secondary">Clear</x-button>@endif
                </div>
            </form>
        </section>

        @if ($assignments->isEmpty())
            <x-empty-state icon="clipboard-list" title="No Assignments Found" message="Create an assignment or change the current filters." />
        @else
            <x-table :headers="['Assignment', 'Course', 'Teacher', 'Deadline', 'Submissions', 'Actions']">
                @foreach ($assignments as $assignment)
                    <tr class="border-b border-border-soft transition last:border-b-0 hover:bg-muted-bg">
                        <td class="px-4 py-4"><p class="font-semibold text-main-text">{{ $assignment->title }}</p><p class="mt-1 max-w-sm text-xs text-secondary-text">{{ $assignment->description }}</p></td>
                        <td class="px-4 py-4 text-sm"><p class="font-bold text-primary-blue">{{ $assignment->course->course_code }}</p><p class="text-xs text-secondary-text">{{ $assignment->course->course_title }}</p></td>
                        <td class="px-4 py-4 text-sm text-secondary-text">{{ $assignment->teacher->user->name }}</td>
                        <td class="px-4 py-4"><p class="text-sm font-semibold text-main-text">{{ $assignment->deadline->format('d M Y') }}</p><x-badge :variant="$assignment->deadline->isPast() ? 'warning' : 'success'">{{ $assignment->deadline->isPast() ? 'Closed' : 'Open' }}</x-badge></td>
                        <td class="px-4 py-4 text-sm font-bold text-main-text">{{ $assignment->submissions_count }}</td>
                        <td class="px-4 py-4"><div class="flex flex-wrap gap-2">
                            <x-button href="{{ route('admin.assignments.submissions', $assignment) }}" class="h-9 px-3">Submissions</x-button>
                            <x-button href="{{ route('admin.assignments.edit', $assignment) }}" variant="secondary" class="h-9 px-3">Edit</x-button>
                            <form method="POST" action="{{ route('admin.assignments.destroy', $assignment) }}" onsubmit="return confirm('Delete this assignment and all submissions?');">@csrf @method('DELETE')<x-button type="submit" variant="danger" class="h-9 px-3">Delete</x-button></form>
                        </div></td>
                    </tr>
                @endforeach
            </x-table>
            @if ($assignments->hasPages())<div>{{ $assignments->links() }}</div>@endif
        @endif
    </div>
@endsection
