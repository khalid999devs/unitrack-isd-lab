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
            <x-card title="My Courses" value="0" description="Assigned courses will appear here." icon="book-2" />
            <x-card title="Today's Classes" value="0" description="Routine preview for the day." icon="calendar-event" />
            <x-card title="New Notices" value="0" description="Latest academic announcements." icon="bell" />
            <x-card title="Upcoming Assignments" value="0" description="Deadline-aware task preview." icon="clipboard-list" />
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <x-card title="Routine Preview" description="Class schedule starter area" icon="table">
                <p class="text-sm leading-6 text-secondary-text">Routine data will be filtered by semester and batch after the routine module is implemented.</p>
            </x-card>
            <x-card title="Recent Study Materials" description="Course material starter area" icon="files">
                <p class="text-sm leading-6 text-secondary-text">Uploaded materials will be listed here with view and download actions.</p>
            </x-card>
        </section>
    </div>
@endsection
