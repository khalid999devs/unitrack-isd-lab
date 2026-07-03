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
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">Assignment Board</p>
            <h1 class="mt-2 text-2xl font-bold text-main-text">Upcoming coursework</h1>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-secondary-text">Assignments are loaded from courses in your current semester.</p>
        </section>

        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

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

                    <x-card class="h-full border-t-4 border-t-[#3B5BDB]">
                        <div class="flex h-full flex-col gap-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#3B5BDB]">{{ $assignment->course->course_code }}</p>
                                    <h2 class="mt-2 text-lg font-bold text-main-text">{{ $assignment->title }}</h2>
                                </div>
                                <x-badge variant="{{ $submission ? 'success' : ($isOverdue ? 'warning' : 'info') }}">
                                    {{ $submission ? 'Submitted' : ($isOverdue ? 'Closed' : 'Open') }}
                                </x-badge>
                            </div>

                            <p class="text-sm leading-6 text-secondary-text">{{ $assignment->description }}</p>

                            <div class="rounded-xl bg-[#F8FBFF] px-4 py-3 text-sm text-secondary-text">
                                <span class="font-semibold text-main-text">Due date:</span> {{ $assignment->deadline->format('d M Y h:i A') }}
                            </div>

                            @if ($submission)
                                <div class="rounded-xl border border-success-border bg-success-bg px-4 py-3 text-sm text-success-text">
                                    Submitted {{ $submission->submitted_at?->format('d M Y h:i A') }}
                                </div>
                            @endif

                            @if (! $isOverdue)
                                <details class="mt-auto rounded-xl border border-border-soft bg-white p-4">
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
                                                class="block w-full rounded-[10px] border border-input-border bg-white px-3 py-2 text-sm outline-none transition file:mr-4 file:rounded-lg file:border-0 file:bg-primary-blue file:px-4 file:py-2 file:text-sm file:font-bold file:text-white focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                                            >
                                            @if ($submission?->file_path)
                                                <p class="mt-1 text-xs text-secondary-text">Current file: {{ basename($submission->file_path) }}</p>
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
    </div>
@endsection
