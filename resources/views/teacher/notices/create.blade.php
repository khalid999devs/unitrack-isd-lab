@php
    $role = 'teacher';
    $title = 'Post Notice';
    $active = 'notices';
@endphp

@extends('layouts.app')

@section('title', 'Post Notice - UniTrack')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <x-button variant="secondary" href="{{ route('teacher.notices') }}" class="h-9 px-3">
                <i class="ti ti-arrow-left text-base"></i>
                Back
            </x-button>
            <div>
                <h1 class="text-2xl font-bold text-primary-navy">Post Notice</h1>
                <p class="text-sm text-secondary-text">Publish an announcement from your teacher account.</p>
            </div>
        </div>

        <x-form-group title="Notice Details" description="Choose who should see this announcement.">
            <form method="POST" action="{{ route('teacher.notices.store') }}" class="space-y-4">
                @csrf

                <x-form-input
                    name="title"
                    label="Title"
                    placeholder="e.g. Lab schedule update"
                    required
                    :value="old('title')"
                    :error="$errors->first('title')"
                />

                <x-form-input type="select" name="target_role" label="Target Audience" required :error="$errors->first('target_role')">
                    <option value="student" {{ old('target_role', 'student') === 'student' ? 'selected' : '' }}>Students</option>
                    <option value="teacher" {{ old('target_role') === 'teacher' ? 'selected' : '' }}>Teachers</option>
                    <option value="all" {{ old('target_role') === 'all' ? 'selected' : '' }}>All Roles</option>
                </x-form-input>

                <x-form-input
                    type="textarea"
                    name="description"
                    label="Description"
                    placeholder="Write the notice details"
                    required
                    :value="old('description')"
                    :error="$errors->first('description')"
                />

                <div class="flex gap-3 pt-4">
                    <x-button type="submit">Post Notice</x-button>
                    <x-button variant="secondary" href="{{ route('teacher.notices') }}">Cancel</x-button>
                </div>
            </form>
        </x-form-group>
    </div>
@endsection
