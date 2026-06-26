@php
    $role = 'teacher';
    $title = 'Class Routine';
    $active = 'routine';
    $teacher = auth()->user()->teacher;
@endphp

@extends('layouts.app')

@section('title', 'Class Routine - UniTrack')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-main-text">My Class Routine</h1>
                <p class="text-sm text-secondary-text">Weekly academic schedule for your assigned lectures and lab sessions.</p>
            </div>
            @if ($teacher)
                <div class="inline-flex items-center gap-2 rounded-xl border border-border-soft bg-card-bg px-4 py-2 text-sm font-semibold shadow-card">
                    <span class="text-secondary-text">Department:</span>
                    <x-badge variant="info">{{ $teacher->department }}</x-badge>
                    <span class="text-secondary-text ml-2">Designation:</span>
                    <x-badge variant="success">{{ $teacher->designation }}</x-badge>
                </div>
            @endif
        </div>

        @if ($routines->isEmpty())
            <x-empty-state
                icon="calendar-stats"
                title="No Routine Found"
                message="You have no assigned class routines scheduled at this time."
            />
        @else
            <x-table :headers="['Day', 'Time', 'Room', 'Course', 'Semester', 'Batch']" emptyMessage="No routines scheduled.">
                @foreach ($routines as $routine)
                    <tr class="hover:bg-muted-bg transition border-b border-border-soft last:border-b-0">
                        <td class="px-4 py-4 text-sm font-bold text-main-text">{{ $routine->day }}</td>
                        <td class="px-4 py-4 text-sm text-main-text font-medium">
                            {{ date('h:i A', strtotime($routine->start_time)) }} - {{ date('h:i A', strtotime($routine->end_time)) }}
                        </td>
                        <td class="px-4 py-4 text-sm text-secondary-text font-semibold">{{ $routine->room }}</td>
                        <td class="px-4 py-4 text-sm">
                            <span class="font-bold text-primary-blue">{{ $routine->course->course_code }}</span><br>
                            <span class="text-xs text-secondary-text">{{ $routine->course->course_title }}</span>
                        </td>
                        <td class="px-4 py-4 text-sm text-secondary-text font-medium">{{ $routine->semester }}</td>
                        <td class="px-4 py-4 text-sm text-secondary-text font-medium">{{ $routine->batch }}</td>
                    </tr>
                @endforeach
            </x-table>
        @endif
    </div>
@endsection
