@php
    $role = 'student';
    $title = 'Class Routine';
    $active = 'routine';
    $student = auth()->user()->student;
@endphp

@extends('layouts.app')

@section('title', 'Class Routine - UniTrack')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-main-text">My Class Routine</h1>
                <p class="text-sm text-secondary-text">Weekly academic schedule for your enrolled semester and batch.</p>
            </div>
            @if ($student)
                <div class="inline-flex items-center gap-2 rounded-xl border border-border-soft bg-card-bg px-4 py-2 text-sm font-semibold shadow-card">
                    <span class="text-secondary-text">Semester:</span>
                    <x-badge variant="success">{{ $student->semester }}</x-badge>
                    <span class="text-secondary-text ml-2">Batch:</span>
                    <x-badge variant="info">{{ $student->batch }}</x-badge>
                </div>
            @endif
        </div>

        @if ($routines->isEmpty())
            <x-empty-state
                icon="calendar-stats"
                title="No Routine Found"
                message="There are no class routines scheduled for your semester ({{ $student->semester ?? 'N/A' }}) and batch ({{ $student->batch ?? 'N/A' }})."
            />
        @else
            <x-table :headers="['Day', 'Time', 'Room', 'Course', 'Instructor']" emptyMessage="No routines scheduled.">
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
                        <td class="px-4 py-4 text-sm text-main-text">
                            {{ $routine->teacher->user->name }}
                        </td>
                    </tr>
                @endforeach
            </x-table>
        @endif
    </div>
@endsection
