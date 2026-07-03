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
        @if ($teacher)
            <section class="flex flex-col gap-4 rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-soft-blue-bg text-primary-blue">
                        <i class="ti ti-calendar-event text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-main-text">Assigned teaching schedule</p>
                        <p class="text-xs text-secondary-text">{{ $teacher->department }}</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <x-badge variant="info">{{ $routines->count() }} classes</x-badge>
                    <x-badge variant="success">{{ $teacher->designation }}</x-badge>
                </div>
            </section>
        @endif

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
