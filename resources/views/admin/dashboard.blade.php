@php
    $role = 'admin';
    $title = 'Admin Dashboard';
    $active = 'dashboard';
@endphp

@extends('layouts.app')

@section('title', 'Admin Dashboard - UniTrack')

@section('content')
    <div class="space-y-6">
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-card title="Total Students" :value="$studentCount ?? 0" description="Student records." icon="users" />
            <x-card title="Total Teachers" :value="$teacherCount ?? 0" description="Teacher records." icon="user-star" />
            <x-card title="Total Courses" :value="$courseCount ?? 0" description="Course catalog." icon="book-2" />
            <x-card title="Total Routines" :value="$routineCount ?? 0" description="Class schedules." icon="calendar-stats" />
            <x-card title="Total Notices" :value="$noticeCount ?? 0" description="Academic notices." icon="bell" />
            <x-card title="Study Materials" :value="$materialCount ?? 0" description="Uploaded resources." icon="files" />
            <x-card title="Assignments" :value="$assignmentCount ?? 0" description="Academic tasks." icon="clipboard-list" />
            <x-card title="Pending Reviews" value="0" description="Admin review area." icon="clock" />
        </section>

        <x-card title="Quick Management Links" description="Starter actions for admin modules" icon="link">
            <div class="flex flex-wrap gap-3">
                <x-button href="{{ route('admin.students') }}">Students</x-button>
                <x-button href="{{ route('admin.teachers') }}">Teachers</x-button>
                <x-button href="{{ route('admin.courses') }}">Courses</x-button>
                <x-button href="{{ route('admin.routines') }}">Routines</x-button>
                <x-button href="{{ route('admin.notices') }}">Notices</x-button>
            </div>
        </x-card>
    </div>
@endsection
