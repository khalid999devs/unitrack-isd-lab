@php
    $role = 'admin';
    $title = 'Admin Dashboard';
    $active = 'dashboard';
@endphp

@extends('layouts.app')

@section('title', 'Admin Dashboard - UniTrack')

@section('content')
    <div class="space-y-6">
        <x-alert type="success">
            Admin dashboard starter page is ready for system management modules and summary counts.
        </x-alert>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-card title="Total Students" value="0" description="Student records." />
            <x-card title="Total Teachers" value="0" description="Teacher records." />
            <x-card title="Total Courses" value="0" description="Course catalog." />
            <x-card title="Total Routines" value="0" description="Class schedules." />
            <x-card title="Total Notices" value="0" description="Academic notices." />
            <x-card title="Study Materials" value="0" description="Uploaded resources." />
            <x-card title="Assignments" value="0" description="Academic tasks." />
            <x-card title="Pending Reviews" value="0" description="Admin review area." />
        </section>

        <x-card title="Quick Management Links" description="Starter actions for admin modules">
            <div class="flex flex-wrap gap-3">
                <x-button variant="secondary">Students</x-button>
                <x-button variant="secondary">Teachers</x-button>
                <x-button variant="secondary">Courses</x-button>
                <x-button variant="secondary">Routines</x-button>
                <x-button variant="secondary">Notices</x-button>
            </div>
        </x-card>
    </div>
@endsection
