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
            <x-card title="Routine Preview" description="Class schedule starter area" icon="table">
                <p class="text-sm leading-6 text-secondary-text">Routine data is filtered by your semester and batch.</p>
                <x-button href="{{ route('student.routine') }}" class="mt-4">View Routine</x-button>
            </x-card>
            <x-card title="Recent Study Materials" description="Course material starter area" icon="files">
                <p class="text-sm leading-6 text-secondary-text">Study materials are available from the materials page.</p>
                <x-button href="{{ route('student.materials') }}" class="mt-4">View Materials</x-button>
            </x-card>
        </section>
    </div>
@endsection
