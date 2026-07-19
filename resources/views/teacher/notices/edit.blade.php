@php
    $role = 'teacher';
    $title = 'Edit Notice';
    $active = 'notices';
@endphp

@extends('layouts.app')

@section('title', 'Edit Notice - UniTrack')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <x-button variant="secondary" href="{{ route('teacher.notices') }}" class="h-9 px-3">
                <i class="ti ti-arrow-left text-base"></i>
                Back
            </x-button>
            <div>
                <h1 class="text-2xl font-bold text-primary-navy">Edit Notice</h1>
                <p class="text-sm text-secondary-text">Update an announcement posted from your account.</p>
            </div>
        </div>

        <x-form-group title="Notice Details" description="Choose the audience that should receive this announcement.">
            <form method="POST" action="{{ route('teacher.notices.update', $notice) }}" class="space-y-4">
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
                    @foreach (['student' => 'Students', 'teacher' => 'Teachers', 'all' => 'All Roles'] as $value => $label)
                        <option value="{{ $value }}" {{ old('target_role', $notice->target_role) === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
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
                    <x-button variant="secondary" href="{{ route('teacher.notices') }}">Cancel</x-button>
                </div>
            </form>
        </x-form-group>
    </div>
@endsection
