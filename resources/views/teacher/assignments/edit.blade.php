@php
    $role = 'teacher';
    $title = 'Edit Assignment';
    $active = 'assignments';
@endphp

@extends('layouts.app')

@section('title', 'Edit Assignment - UniTrack')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <x-button variant="secondary" href="{{ route('teacher.assignments') }}" class="h-9 px-3">
                <i class="ti ti-arrow-left text-base"></i>
                Back
            </x-button>
            <div>
                <h1 class="text-2xl font-bold text-primary-navy">Edit Assignment</h1>
                <p class="text-sm text-secondary-text">Update the coursework details shown to eligible students.</p>
            </div>
        </div>

        <x-form-group title="Assignment Details" description="The assigned course must belong to your teacher profile.">
            <form method="POST" action="{{ route('teacher.assignments.update', $assignment) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <x-form-input type="select" name="course_id" label="Course" required :error="$errors->first('course_id')">
                    <option value="">Select course</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ (string) old('course_id', $assignment->course_id) === (string) $course->id ? 'selected' : '' }}>
                            {{ $course->course_code }} - {{ $course->course_title }}
                        </option>
                    @endforeach
                </x-form-input>

                <x-form-input
                    name="title"
                    label="Assignment Title"
                    required
                    :value="old('title', $assignment->title)"
                    :error="$errors->first('title')"
                />

                <x-form-input
                    type="textarea"
                    name="description"
                    label="Description"
                    required
                    :value="old('description', $assignment->description)"
                    :error="$errors->first('description')"
                />

                <x-form-input
                    type="datetime-local"
                    name="deadline"
                    label="Deadline"
                    required
                    :value="old('deadline', $assignment->deadline->format('Y-m-d\\TH:i'))"
                    :error="$errors->first('deadline')"
                />

                <div class="flex gap-3 pt-4">
                    <x-button type="submit">Save Changes</x-button>
                    <x-button variant="secondary" href="{{ route('teacher.assignments') }}">Cancel</x-button>
                </div>
            </form>
        </x-form-group>
    </div>
@endsection
