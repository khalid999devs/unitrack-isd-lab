@php
    $role = 'teacher';
    $title = 'Assignment Submissions';
    $active = 'assignments';
@endphp

@extends('layouts.app')

@section('title', 'Assignment Submissions - UniTrack')

@section('content')
    <div class="space-y-6">
        @php
            $submittedCount = $submissions->count();
        @endphp

        <div class="flex items-center gap-4">
            <x-button variant="secondary" href="{{ route('teacher.assignments') }}" class="h-9 px-3">
                <i class="ti ti-arrow-left text-base"></i>
                Back
            </x-button>
            <div>
                <h1 class="text-2xl font-bold text-primary-navy">{{ $assignment->title }}</h1>
                <p class="text-sm text-secondary-text">{{ $assignment->course->course_code }} submissions overview</p>
            </div>
        </div>

        <section class="grid gap-4 sm:grid-cols-3">
            <x-card title="Eligible Students" :value="$students->count()" description="Same semester roster." icon="users" />
            <x-card title="Recorded Submissions" :value="$submittedCount" description="Submitted assignment records." icon="upload" />
            <x-card title="Deadline" :value="$assignment->deadline->format('d M')" description="{{ $assignment->deadline->format('Y h:i A') }}" icon="calendar-due" />
        </section>

        <x-table :headers="['Student ID', 'Name', 'Status', 'Submission Note', 'Submitted At', 'File']" emptyMessage="No students found for this course semester.">
            @foreach ($students as $student)
                @php
                    $submission = $submissions->get($student->id);
                    $hasFile = $submission?->file_path && \Illuminate\Support\Facades\Storage::exists($submission->file_path);
                @endphp
                <tr class="hover:bg-muted-bg transition border-b border-border-soft last:border-b-0">
                    <td class="px-4 py-4 text-sm font-semibold text-main-text">{{ $student->student_id }}</td>
                    <td class="px-4 py-4 text-sm text-secondary-text">{{ $student->user->name }}</td>
                    <td class="px-4 py-4">
                        <x-badge variant="{{ $submission ? 'success' : 'warning' }}">
                            {{ $submission ? 'Submitted' : 'Pending' }}
                        </x-badge>
                    </td>
                    <td class="max-w-sm px-4 py-4 text-sm leading-6 text-secondary-text">
                        {{ $submission?->submission_text ?: '-' }}
                    </td>
                    <td class="px-4 py-4 text-sm text-secondary-text">
                        {{ $submission?->submitted_at?->format('d M Y h:i A') ?? '-' }}
                    </td>
                    <td class="px-4 py-4">
                        @if ($hasFile)
                            <a href="{{ route('teacher.assignments.submissions.download', $submission) }}" class="inline-flex h-9 items-center gap-2 rounded-[10px] bg-primary-blue px-3 text-sm font-bold text-on-primary transition hover:bg-royal-blue">
                                <i class="ti ti-download text-base"></i>
                                Download
                            </a>
                        @else
                            <span class="text-sm text-secondary-text">No file</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>
@endsection
