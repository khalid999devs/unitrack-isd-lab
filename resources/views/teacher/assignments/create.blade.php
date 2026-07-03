@php
    $role = 'teacher';
    $title = 'Create Assignment';
    $active = 'assignments';
@endphp

@extends('layouts.app')

@section('title', 'Create Assignment - UniTrack')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <x-button variant="secondary" href="{{ route('teacher.assignments') }}" class="h-9 px-3">
                <i class="ti ti-arrow-left text-base"></i>
                Back
            </x-button>
            <div>
                <h1 class="text-2xl font-bold text-primary-navy">Create Assignment</h1>
                <p class="text-sm text-secondary-text">Publish coursework for one of your assigned courses.</p>
            </div>
        </div>

        <x-form-group title="Assignment Details" description="Students will see the assignment in their assignment board.">
            <form method="POST" action="{{ route('teacher.assignments.store') }}" class="space-y-4">
                @csrf

                <x-form-input type="select" name="course_id" label="Course" required :error="$errors->first('course_id')">
                    <option value="">Select course</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->course_code }} - {{ $course->course_title }}
                        </option>
                    @endforeach
                </x-form-input>

                <x-form-input
                    name="title"
                    label="Assignment Title"
                    placeholder="e.g. Sprint review summary"
                    required
                    :value="old('title')"
                    :error="$errors->first('title')"
                />

                <x-form-input
                    type="textarea"
                    name="description"
                    label="Description"
                    placeholder="Submission instructions"
                    required
                    :value="old('description')"
                    :error="$errors->first('description')"
                />

                <x-form-input
                    type="datetime-local"
                    name="deadline"
                    label="Deadline"
                    required
                    :value="old('deadline')"
                    :error="$errors->first('deadline')"
                />

                <div class="flex gap-3 pt-4">
                    <x-button type="submit">Create Assignment</x-button>
                    <x-button variant="secondary" href="{{ route('teacher.assignments') }}">Cancel</x-button>
                </div>
            </form>
        </x-form-group>
    </div>
@endsection
