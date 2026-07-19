@php
    $role = 'student';
    $title = 'Assignments';
    $active = 'assignments';
@endphp

@extends('layouts.app')

@section('title', 'Assignments - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="rounded-2xl border border-border-soft bg-card-bg p-6 shadow-card">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-primary-blue">Assignment Board</p>
            <h1 class="mt-2 text-2xl font-bold text-main-text">Coursework and submissions</h1>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-secondary-text">Review coursework for courses matched to your department and semester.</p>
        </section>

        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        @if ($errors->any())
            <x-alert type="error">{{ $errors->first() }}</x-alert>
        @endif

        <section class="rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card">
            <form method="GET" action="{{ route('student.assignments') }}" class="grid gap-4 sm:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_auto] sm:items-end">
                <div>
                    <label for="course_id" class="mb-2 block text-sm font-semibold text-main-text">Course</label>
                    <select id="course_id" name="course_id" class="h-11 w-full rounded-[10px] border border-input-border bg-card-bg px-3 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                        <option value="">All courses</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ (string) request('course_id') === (string) $course->id ? 'selected' : '' }}>{{ $course->course_code }} - {{ $course->course_title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="deadline" class="mb-2 block text-sm font-semibold text-main-text">Status</label>
                    <select id="deadline" name="deadline" class="h-11 w-full rounded-[10px] border border-input-border bg-card-bg px-3 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                        <option value="">All assignments</option>
                        <option value="upcoming" {{ request('deadline') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="past" {{ request('deadline') === 'past' ? 'selected' : '' }}>Past deadline</option>
                        <option value="submitted" {{ request('deadline') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <x-button type="submit">Filter</x-button>
                    @if (request()->hasAny(['course_id', 'deadline']))
                        <x-button href="{{ route('student.assignments') }}" variant="secondary">Clear</x-button>
                    @endif
                </div>
            </form>
        </section>

        @if ($assignments->isEmpty())
            <x-empty-state
                icon="clipboard-list"
                title="No Assignments Found"
                message="There are no assignments for your semester right now."
            />
        @else
            <section class="grid gap-6 lg:grid-cols-2">
                @foreach ($assignments as $assignment)
                    @php
                        $isOverdue = $assignment->deadline->isPast();
                        $submission = $assignment->submissions->first();
                    @endphp

                    <x-card class="h-full border-t-4 border-t-primary-blue">
                        <div class="flex h-full flex-col gap-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-primary-blue">{{ $assignment->course->course_code }}</p>
                                    <h2 class="mt-2 text-lg font-bold text-main-text">{{ $assignment->title }}</h2>
                                </div>
                                <x-badge variant="{{ $submission ? 'success' : ($isOverdue ? 'warning' : 'info') }}">
                                    {{ $submission ? 'Submitted' : ($isOverdue ? 'Closed' : 'Open') }}
                                </x-badge>
                            </div>

                            <p class="text-sm leading-6 text-secondary-text">{{ $assignment->description }}</p>

                            <div class="rounded-xl bg-page-bg px-4 py-3 text-sm text-secondary-text">
                                <span class="font-semibold text-main-text">Due date:</span> {{ $assignment->deadline->format('d M Y h:i A') }}
                            </div>

                            @if ($submission)
                                <div class="rounded-xl border border-success-border bg-success-bg px-4 py-3 text-sm text-success-text">
                                    Submitted {{ $submission->submitted_at?->format('d M Y h:i A') }}
                                </div>
                            @endif

                            @if (! $isOverdue)
                                <details class="mt-auto rounded-xl border border-border-soft bg-card-bg p-4">
                                    <summary class="cursor-pointer text-sm font-bold text-primary-blue">
                                        {{ $submission ? 'Update Submission' : 'Submit Assignment' }}
                                    </summary>
                                    <form method="POST" action="{{ route('student.assignments.submit', $assignment) }}" enctype="multipart/form-data" class="mt-4 space-y-3">
                                        @csrf

                                        <div>
                                            <label for="submission_text_{{ $assignment->id }}" class="mb-2 block text-sm font-semibold text-main-text">Submission Note</label>
                                            <textarea
                                                id="submission_text_{{ $assignment->id }}"
                                                name="submission_text"
                                                rows="3"
                                                class="w-full rounded-[10px] border border-input-border px-3 py-2 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                                            >{{ old('submission_text', $submission?->submission_text) }}</textarea>
                                        </div>

                                        <div>
                                            <label for="submission_file_{{ $assignment->id }}" class="mb-2 block text-sm font-semibold text-main-text">Attachment</label>
                                            <input
                                                id="submission_file_{{ $assignment->id }}"
                                                name="submission_file"
                                                type="file"
                                                accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.zip"
                                                class="block w-full rounded-[10px] border border-input-border bg-card-bg px-3 py-2 text-sm outline-none transition file:mr-4 file:rounded-lg file:border-0 file:bg-primary-blue file:px-4 file:py-2 file:text-sm file:font-bold file:text-on-primary focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                                            >
                                            @if ($submission?->file_path)
                                                <p class="mt-1 text-xs font-semibold text-success-text">An attachment is on file. Upload a new file to replace it.</p>
                                            @endif
                                        </div>

                                        <x-button type="submit" class="h-10">
                                            {{ $submission ? 'Update Submission' : 'Submit Assignment' }}
                                        </x-button>
                                    </form>
                                </details>
                            @else
                                <div class="mt-auto flex items-center gap-2 text-sm font-semibold text-warning-text">
                                    <i class="ti ti-clock-exclamation text-[18px]"></i>
                                    <span>Submission deadline has passed</span>
                                </div>
                            @endif
                        </div>
                    </x-card>
                @endforeach
            </section>
        @endif

        @if ($assignments->hasPages())
            {{ $assignments->links() }}
        @endif
    </div>
@endsection
