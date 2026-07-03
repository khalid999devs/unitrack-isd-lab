@php
    $role = 'teacher';
    $title = 'Upload Material';
    $active = 'materials';
@endphp

@extends('layouts.app')

@section('title', 'Upload Material - UniTrack')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <x-button variant="secondary" href="{{ route('teacher.materials') }}" class="h-9 px-3">
                <i class="ti ti-arrow-left text-base"></i>
                Back
            </x-button>
            <div>
                <h1 class="text-2xl font-bold text-primary-navy">Upload Material</h1>
                <p class="text-sm text-secondary-text">Create a study material record for an assigned course.</p>
            </div>
        </div>

        <x-form-group title="Material Details" description="Use a file path or reference name for the V1 demo record.">
            <form method="POST" action="{{ route('teacher.materials.store') }}" class="space-y-4">
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
                    label="Material Title"
                    placeholder="e.g. Week 5 lecture notes"
                    required
                    :value="old('title')"
                    :error="$errors->first('title')"
                />

                <x-form-input
                    type="textarea"
                    name="description"
                    label="Description"
                    placeholder="Short description for students"
                    :value="old('description')"
                    :error="$errors->first('description')"
                />

                <x-form-input
                    name="file_path"
                    label="File Path"
                    placeholder="materials/week-5-notes.pdf"
                    :value="old('file_path')"
                    :error="$errors->first('file_path')"
                    hint="V1 stores a file reference; physical upload storage can be added later."
                />

                <div class="flex gap-3 pt-4">
                    <x-button type="submit">Upload Material</x-button>
                    <x-button variant="secondary" href="{{ route('teacher.materials') }}">Cancel</x-button>
                </div>
            </form>
        </x-form-group>
    </div>
@endsection
