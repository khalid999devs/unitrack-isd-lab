@php
    $role = 'admin';
    $title = 'Create Routine';
    $active = 'routines';
@endphp

@extends('layouts.app')

@section('title', 'Create Routine - UniTrack')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6">
        <div class="flex items-center gap-4">
            <x-button href="{{ route('admin.routines') }}" variant="secondary" class="h-10 w-10 p-0 rounded-full flex items-center justify-center">
                <i class="ti ti-arrow-left text-lg"></i>
            </x-button>
            <div>
                <h1 class="text-2xl font-bold text-main-text">Add Class Routine</h1>
                <p class="text-sm text-secondary-text">Define a new schedule slot for a course and teacher.</p>
            </div>
        </div>

        <x-form-group title="Schedule Details" description="Fill in the details below to assign a routine block. All fields marked with * are required.">
            <form method="POST" action="{{ route('admin.routines.store') }}" class="space-y-4">
                @csrf

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-form-input
                        name="course_id"
                        type="select"
                        label="Course"
                        required
                        :error="$errors->first('course_id')"
                    >
                        <option value="">Select Course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                [{{ $course->course_code }}] {{ $course->course_title }}
                            </option>
                        @endforeach
                    </x-form-input>

                    <x-form-input
                        name="teacher_id"
                        type="select"
                        label="Assigned Teacher"
                        required
                        :error="$errors->first('teacher_id')"
                    >
                        <option value="">Select Teacher</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->user->name }} ({{ $teacher->department }})
                            </option>
                        @endforeach
                    </x-form-input>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-form-input
                        name="semester"
                        label="Semester"
                        placeholder="e.g., 6th"
                        required
                        :value="old('semester')"
                        :error="$errors->first('semester')"
                    />

                    <x-form-input
                        name="batch"
                        label="Batch"
                        placeholder="e.g., 2022"
                        required
                        :value="old('batch')"
                        :error="$errors->first('batch')"
                    />
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <x-form-input
                        name="day"
                        type="select"
                        label="Day"
                        required
                        :error="$errors->first('day')"
                    >
                        <option value="">Select Day</option>
                        @foreach (['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                            <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </x-form-input>

                    <x-form-input
                        name="start_time"
                        type="time"
                        label="Start Time"
                        required
                        :value="old('start_time')"
                        :error="$errors->first('start_time')"
                    />

                    <x-form-input
                        name="end_time"
                        type="time"
                        label="End Time"
                        required
                        :value="old('end_time')"
                        :error="$errors->first('end_time')"
                    />
                </div>

                <x-form-input
                    name="room"
                    label="Room"
                    placeholder="e.g., CSE Lab 1, Room 302"
                    required
                    :value="old('room')"
                    :error="$errors->first('room')"
                />

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-border-soft">
                    <x-button href="{{ route('admin.routines') }}" variant="secondary">Cancel</x-button>
                    <x-button type="submit">Create Routine</x-button>
                </div>
            </form>
        </x-form-group>
    </div>
@endsection
