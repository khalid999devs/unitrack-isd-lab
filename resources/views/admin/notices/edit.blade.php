@php
    $role = 'admin';
    $title = 'Edit Notice';
    $active = 'notices';
@endphp

@extends('layouts.app')

@section('title', 'Edit Notice - UniTrack')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <x-button variant="secondary" href="{{ route('admin.notices') }}" class="h-9 px-3">
                <i class="ti ti-arrow-left text-base"></i>
                Back
            </x-button>
            <div>
                <h1 class="text-2xl font-bold text-primary-navy">Edit Notice</h1>
                <p class="text-sm text-secondary-text">Update the announcement content and audience.</p>
            </div>
        </div>

        <x-form-group title="Notice Details" description="Changes are visible on the role notice boards.">
            <form method="POST" action="{{ route('admin.notices.update', $notice) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <x-form-input
                    name="title"
                    label="Title"
                    required
                    :value="old('title', $notice->title)"
                    :error="$errors->first('title')"
                />

                <x-form-input type="select" name="target_role" label="Target Audience" required :error="$errors->first('target_role')">
                    <option value="all" {{ old('target_role', $notice->target_role) === 'all' ? 'selected' : '' }}>All Roles</option>
                    <option value="student" {{ old('target_role', $notice->target_role) === 'student' ? 'selected' : '' }}>Students</option>
                    <option value="teacher" {{ old('target_role', $notice->target_role) === 'teacher' ? 'selected' : '' }}>Teachers</option>
                    <option value="admin" {{ old('target_role', $notice->target_role) === 'admin' ? 'selected' : '' }}>Admins</option>
                </x-form-input>

                <x-form-input
                    type="textarea"
                    name="description"
                    label="Description"
                    required
                    :value="old('description', $notice->description)"
                    :error="$errors->first('description')"
                />

                <div class="flex gap-3 pt-4">
                    <x-button type="submit">Save Changes</x-button>
                    <x-button variant="secondary" href="{{ route('admin.notices') }}">Cancel</x-button>
                </div>
            </form>
        </x-form-group>
    </div>
@endsection
