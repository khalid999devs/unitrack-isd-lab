@php
    $role = 'admin';
    $title = 'Edit Teacher';
    $active = 'teachers';
@endphp

@extends('layouts.app')

@section('title', 'Edit Teacher - UniTrack')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <x-button variant="secondary" href="{{ route('admin.teachers') }}" class="h-9 px-3">
                <i class="ti ti-arrow-left text-base"></i> Back
            </x-button>
            <div>
                <h1 class="text-2xl font-bold text-primary-navy">Edit Teacher</h1>
                <p class="text-sm text-secondary-text">Modify profile details or update teacher credentials.</p>
            </div>
        </div>

        <!-- Form Card -->
        <x-form-group title="Teacher Information" description="Update the teacher's personal and academic details">
            <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-form-input
                        name="name"
                        label="Full Name"
                        placeholder="e.g. Dr. Khalid Hossein"
                        required
                        :value="old('name', $teacher->user->name)"
                        :error="$errors->first('name')"
                    />

                    <x-form-input
                        type="email"
                        name="email"
                        label="Email Address"
                        placeholder="e.g. khalid@domain.com"
                        required
                        :value="old('email', $teacher->user->email)"
                        :error="$errors->first('email')"
                    />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-form-input
                        type="password"
                        name="password"
                        label="Password"
                        placeholder="••••••••"
                        :error="$errors->first('password')"
                        hint="Leave blank to keep the current password."
                    />

                    <x-form-input
                        name="teacher_id"
                        label="Teacher ID"
                        placeholder="e.g. TCH-101"
                        required
                        :value="old('teacher_id', $teacher->teacher_id)"
                        :error="$errors->first('teacher_id')"
                    />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-form-input
                        name="department"
                        label="Department"
                        placeholder="e.g. Computer Science and Engineering"
                        required
                        :value="old('department', $teacher->department)"
                        :error="$errors->first('department')"
                    />

                    <x-form-input
                        name="designation"
                        label="Designation"
                        placeholder="e.g. Assistant Professor"
                        required
                        :value="old('designation', $teacher->designation)"
                        :error="$errors->first('designation')"
                    />
                </div>

                <x-form-input
                    name="phone"
                    label="Phone Number"
                    placeholder="e.g. 01700000002"
                    :value="old('phone', $teacher->phone)"
                    :error="$errors->first('phone')"
                />

                <div class="pt-4 flex gap-3">
                    <x-button type="submit">Update Teacher</x-button>
                    <x-button variant="secondary" href="{{ route('admin.teachers') }}">Cancel</x-button>
                </div>
            </form>
        </x-form-group>
    </div>
@endsection
