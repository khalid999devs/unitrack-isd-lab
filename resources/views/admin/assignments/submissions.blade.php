@php
    $role = 'admin';
    $title = 'Assignment Submissions';
    $active = 'assignments';
    $submittedCount = $submissions->count();
@endphp

@extends('layouts.app')

@section('title', 'Assignment Submissions - UniTrack')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-4"><x-button href="{{ route('admin.assignments') }}" variant="secondary" class="h-9 px-3"><i class="ti ti-arrow-left" aria-hidden="true"></i> Back</x-button><div><h2 class="text-xl font-bold text-primary-navy">{{ $assignment->title }}</h2><p class="text-sm text-secondary-text">{{ $assignment->course->course_code }} - {{ $assignment->course->course_title }}</p></div></div>
        <section class="grid gap-4 sm:grid-cols-3">
            <x-card title="Eligible Students" :value="$students->count()" description="Matching department and semester." icon="users" />
            <x-card title="Recorded Submissions" :value="$submittedCount" description="Current submitted records." icon="upload" />
            <x-card title="Deadline" :value="$assignment->deadline->format('d M')" description="{{ $assignment->deadline->format('Y h:i A') }}" icon="calendar-due" />
        </section>
        <x-table :headers="['Student ID', 'Name', 'Status', 'Submitted At', 'Submission', 'File']">
            @foreach ($students as $student)
                @php($submission = $submissions->get($student->id))
                <tr class="border-b border-border-soft transition last:border-b-0 hover:bg-muted-bg">
                    <td class="px-4 py-4 text-sm font-bold text-main-text">{{ $student->student_id }}</td>
                    <td class="px-4 py-4 text-sm text-main-text">{{ $student->user->name }}</td>
                    <td class="px-4 py-4"><x-badge :variant="$submission ? 'success' : 'warning'">{{ $submission ? 'Submitted' : 'Pending' }}</x-badge></td>
                    <td class="px-4 py-4 text-sm text-secondary-text">{{ $submission?->submitted_at?->format('d M Y, h:i A') ?? '-' }}</td>
                    <td class="max-w-sm px-4 py-4 text-sm text-secondary-text">{{ $submission?->submission_text ?: '-' }}</td>
                    <td class="px-4 py-4">@if ($submission?->file_path)<x-button href="{{ route('admin.assignments.submissions.download', $submission) }}" variant="secondary" class="h-9 px-3"><i class="ti ti-download" aria-hidden="true"></i> Download</x-button>@else<span class="text-sm text-placeholder-text">No file</span>@endif</td>
                </tr>
            @endforeach
        </x-table>
    </div>
@endsection
