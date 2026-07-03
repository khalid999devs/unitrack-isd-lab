@php
    $role = 'admin';
    $title = 'Routine Management';
    $active = 'routines';
@endphp

@extends('layouts.app')

@section('title', 'Routine Management - UniTrack')

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @endif

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-main-text">Class Routines</h1>
                <p class="text-sm text-secondary-text">Manage academic schedules and classroom distributions.</p>
            </div>
            <x-button href="{{ route('admin.routines.create') }}" class="sm:self-start">
                <i class="ti ti-plus mr-1"></i> Add Routine
            </x-button>
        </div>

        <!-- Filters -->
        <div class="rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card">
            <form method="GET" action="{{ route('admin.routines') }}" class="grid gap-4 sm:grid-cols-3 items-end">
                <div>
                    <label for="semester" class="mb-2 block text-sm font-semibold text-main-text">Semester</label>
                    <input type="text" name="semester" id="semester" value="{{ request('semester') }}" placeholder="e.g., 6th" class="h-11 w-full rounded-[10px] border border-input-border px-3 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                </div>
                <div>
                    <label for="batch" class="mb-2 block text-sm font-semibold text-main-text">Batch</label>
                    <input type="text" name="batch" id="batch" value="{{ request('batch') }}" placeholder="e.g., 2022" class="h-11 w-full rounded-[10px] border border-input-border px-3 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                </div>
                <div class="flex gap-2">
                    <x-button type="submit" class="flex-1">Filter</x-button>
                    @if(request()->filled('semester') || request()->filled('batch'))
                        <x-button href="{{ route('admin.routines') }}" variant="secondary">Clear</x-button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table -->
        <x-table :headers="['Day', 'Time', 'Room', 'Course', 'Instructor', 'Semester', 'Batch', 'Actions']" emptyMessage="No routines found matching the criteria.">
            @foreach ($routines as $routine)
                <tr class="hover:bg-muted-bg transition border-b border-border-soft last:border-b-0">
                    <td class="px-4 py-4 text-sm font-bold text-main-text">{{ $routine->day }}</td>
                    <td class="px-4 py-4 text-sm text-main-text">
                        {{ date('h:i A', strtotime($routine->start_time)) }} - {{ date('h:i A', strtotime($routine->end_time)) }}
                    </td>
                    <td class="px-4 py-4 text-sm text-secondary-text">{{ $routine->room }}</td>
                    <td class="px-4 py-4 text-sm">
                        <span class="font-bold text-primary-blue">{{ $routine->course->course_code }}</span><br>
                        <span class="text-xs text-secondary-text">{{ $routine->course->course_title }}</span>
                    </td>
                    <td class="px-4 py-4 text-sm text-main-text">
                        {{ $routine->teacher->user->name }}
                    </td>
                    <td class="px-4 py-4 text-sm text-secondary-text">{{ $routine->semester }}</td>
                    <td class="px-4 py-4 text-sm text-secondary-text">{{ $routine->batch }}</td>
                    <td class="px-4 py-4 text-sm">
                        <div class="flex items-center gap-2">
                            <x-button href="{{ route('admin.routines.edit', $routine->id) }}" variant="secondary" class="h-9 px-3 text-xs font-bold">
                                Edit
                            </x-button>
                            <form action="{{ route('admin.routines.destroy', $routine->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this routine?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger" class="h-9 px-3 text-xs font-bold">
                                    Delete
                                </x-button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>

        @if ($routines->hasPages())
            <div class="mt-4">
                {{ $routines->links() }}
            </div>
        @endif
    </div>
@endsection
