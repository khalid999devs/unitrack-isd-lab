@php
    $role = 'teacher';
    $title = 'Assigned Courses';
    $active = 'courses';
@endphp

@extends('layouts.app')

@section('title', 'Assigned Courses - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-primary-blue">Assigned Courses</p>
                <h1 class="mt-1 text-2xl font-bold text-main-text">Courses you're teaching</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-secondary-text">
                    Courses are filtered by your teacher profile{{ $teacher ? ' ('.$teacher->teacher_id.')' : '' }}.
                </p>
            </div>

            <div class="w-full max-w-md">
                <label for="course-search" class="mb-2 block text-sm font-semibold text-main-text">Search courses</label>
                <form method="GET" action="{{ route('teacher.courses') }}" class="flex gap-2">
                    <div class="relative flex-1">
                        <i class="ti ti-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[18px] text-primary-blue"></i>
                        <input
                            id="course-search"
                            name="search"
                            type="text"
                            value="{{ request('search') }}"
                            placeholder="Search by code, title, or semester"
                            class="w-full rounded-xl border border-input-border bg-card-bg py-3 pl-11 pr-4 text-sm text-main-text shadow-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                        >
                    </div>
                    <x-button type="submit" class="h-auto">Search</x-button>
                </form>
            </div>
        </section>

        @if ($courses->isEmpty())
            <x-empty-state
                icon="book-2"
                title="No Assigned Courses"
                message="No courses match your teacher profile or search filter yet."
            />
        @else
            <section class="grid gap-6 lg:grid-cols-3">
                @foreach ($courses as $course)
                    <x-card class="h-full border-t-4 border-t-primary-blue">
                        <div class="flex h-full flex-col gap-4">
                            <div class="flex items-center justify-between gap-4 overflow-hidden">
                                <div class="min-w-0">
                                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-primary-blue">{{ $course->course_code }}</p>
                                    <h2 class="mt-1 text-lg font-bold text-main-text">{{ $course->course_title }}</h2>
                                </div>
                                <span class="shrink-0 inline-flex items-center rounded-full bg-soft-blue-bg px-3 py-1 text-xs font-bold uppercase tracking-wide text-primary-blue">Active</span>
                            </div>

                            <div class="grid gap-4 text-sm text-secondary-text sm:grid-cols-2">
                                <div>
                                    <p class="font-semibold text-main-text">Department</p>
                                    <p>{{ $course->department }}</p>
                                </div>
                                <div>
                                    <p class="font-semibold text-main-text">Semester</p>
                                    <p>{{ $course->semester }}</p>
                                </div>
                                <div>
                                    <p class="font-semibold text-main-text">Credit</p>
                                    <p>{{ $course->credit }} credits</p>
                                </div>
                            </div>

                            <div class="mt-auto flex items-center justify-end gap-2">
                                <x-button href="{{ route('teacher.materials.create') }}">Upload Material</x-button>
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </section>
        @endif
    </div>
@endsection
