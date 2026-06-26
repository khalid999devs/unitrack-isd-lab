@php
    $role = 'admin';
    $title = 'Add New Course';
    $active = 'courses';
@endphp

@extends('layouts.app')

@section('title', 'Add New Course - UniTrack')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <x-button variant="secondary" href="{{ route('admin.courses') }}" class="h-9 px-3">
                <i class="ti ti-arrow-left text-base"></i> Back
            </x-button>
            <div>
                <h1 class="text-2xl font-bold text-primary-navy">Add New Course</h1>
                <p class="text-sm text-secondary-text">Create a new course and allocate an instructor.</p>
            </div>
        </div>

        <!-- Form Card -->
        <x-form-group title="Course Information" description="Fill out the syllabus and administrative details for this course">
            <form method="POST" action="{{ route('admin.courses.store') }}" class="space-y-4">
                @csrf

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-form-input
                        name="course_code"
                        label="Course Code"
                        placeholder="e.g. CSE-3200"
                        required
                        :value="old('course_code')"
                        :error="$errors->first('course_code')"
                    />

                    <x-form-input
                        name="course_title"
                        label="Course Title"
                        placeholder="e.g. Information System Design Lab"
                        required
                        :value="old('course_title')"
                        :error="$errors->first('course_title')"
                    />
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <x-form-input
                        name="department"
                        label="Department"
                        placeholder="e.g. Computer Science and Engineering"
                        required
                        :value="old('department')"
                        :error="$errors->first('department')"
                    />

                    <x-form-input
                        name="semester"
                        label="Semester"
                        placeholder="e.g. 6th"
                        required
                        :value="old('semester')"
                        :error="$errors->first('semester')"
                    />

                    <x-form-input
                        type="number"
                        step="0.1"
                        name="credit"
                        label="Credits"
                        placeholder="e.g. 1.5 or 3.0"
                        required
                        :value="old('credit')"
                        :error="$errors->first('credit')"
                    />
                </div>

                <x-form-input
                    type="select"
                    name="teacher_id"
                    label="Assigned Teacher"
                    :error="$errors->first('teacher_id')"
                >
                    <option value="">Unassigned</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->user->name }} ({{ $teacher->teacher_id }})
                        </option>
                    @endforeach
                </x-form-input>

                <div class="pt-4 flex gap-3">
                    <x-button type="submit">Create Course</x-button>
                    <x-button variant="secondary" href="{{ route('admin.courses') }}">Cancel</x-button>
                </div>
            </form>
        </x-form-group>
    </div>
@endsection
