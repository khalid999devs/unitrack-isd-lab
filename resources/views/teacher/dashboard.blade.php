@php
    $role = 'teacher';
    $title = 'Teacher Dashboard';
    $active = 'dashboard';
@endphp

@extends('layouts.app')

@section('title', 'Teacher Dashboard - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-card title="Assigned Courses" :value="$courseCount ?? 0" description="Courses assigned by admin." icon="book-2" />
            <x-card title="Today's Classes" :value="$todayClassCount ?? 0" description="Classes scheduled for today." icon="calendar-event" />
            <x-card title="Uploaded Materials" :value="$materialCount ?? 0" description="Study materials count." icon="files" />
            <x-card title="Active Assignments" :value="$assignmentCount ?? 0" description="Published academic tasks." icon="clipboard-list" />
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <x-card title="Content Management" description="Teacher workflow shortcuts" icon="settings">
                <div class="flex flex-wrap gap-3">
                    <x-button href="{{ route('teacher.materials') }}">Upload Material</x-button>
                    <x-button href="{{ route('teacher.assignments') }}">Create Assignment</x-button>
                    <x-button href="{{ route('teacher.notices') }}">Create Notice</x-button>
                </div>
            </x-card>
            <x-card title="Class Schedule" description="Assigned class schedule starter area" icon="table">
                <p class="text-sm leading-6 text-secondary-text">Assigned routines are filtered by your teacher profile.</p>
                <x-button href="{{ route('teacher.routine') }}" class="mt-4">View Routine</x-button>
            </x-card>
        </section>
    </div>
@endsection
