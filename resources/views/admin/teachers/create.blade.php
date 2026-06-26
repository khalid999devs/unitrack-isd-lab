@php
    $role = 'admin';
    $title = 'Add New Teacher';
    $active = 'teachers';
@endphp

@extends('layouts.app')

@section('title', 'Add New Teacher - UniTrack')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <x-button variant="secondary" href="{{ route('admin.teachers') }}" class="h-9 px-3">
                <i class="ti ti-arrow-left text-base"></i> Back
            </x-button>
            <div>
                <h1 class="text-2xl font-bold text-primary-navy">Add New Teacher</h1>
                <p class="text-sm text-secondary-text">Create a new teacher account and profile record.</p>
            </div>
        </div>

        <!-- Form Card -->
        <x-form-group title="Teacher Information" description="Fill out the teacher's personal and academic details">
            <form method="POST" action="{{ route('admin.teachers.store') }}" class="space-y-4">
                @csrf

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-form-input
                        name="name"
                        label="Full Name"
                        placeholder="e.g. Dr. Khalid Hossein"
                        required
                        :value="old('name')"
                        :error="$errors->first('name')"
                    />

                    <x-form-input
                        type="email"
                        name="email"
                        label="Email Address"
                        placeholder="e.g. khalid@domain.com"
                        required
                        :value="old('email')"
                        :error="$errors->first('email')"
                    />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-form-input
                        type="password"
                        name="password"
                        label="Password"
                        placeholder="••••••••"
                        required
                        :error="$errors->first('password')"
                        hint="Minimum 6 characters."
                    />

                    <x-form-input
                        name="teacher_id"
                        label="Teacher ID"
                        placeholder="e.g. TCH-101"
                        required
                        :value="old('teacher_id')"
                        :error="$errors->first('teacher_id')"
                    />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-form-input
                        name="department"
                        label="Department"
                        placeholder="e.g. Computer Science and Engineering"
                        required
                        :value="old('department')"
                        :error="$errors->first('department')"
                    />

                    <x-form-input
                        name="designation"
                        label="Designation"
                        placeholder="e.g. Assistant Professor"
                        required
                        :value="old('designation')"
                        :error="$errors->first('designation')"
                    />
                </div>

                <x-form-input
                    name="phone"
                    label="Phone Number"
                    placeholder="e.g. 01700000002"
                    :value="old('phone')"
                    :error="$errors->first('phone')"
                />

                <div class="pt-4 flex gap-3">
                    <x-button type="submit">Create Teacher</x-button>
                    <x-button variant="secondary" href="{{ route('admin.teachers') }}">Cancel</x-button>
                </div>
            </form>
        </x-form-group>
    </div>
@endsection
