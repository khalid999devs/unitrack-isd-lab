@php
    $role = 'admin';
    $title = 'Add New Student';
    $active = 'students';
@endphp

@extends('layouts.app')

@section('title', 'Add New Student - UniTrack')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <x-button variant="secondary" href="{{ route('admin.students') }}" class="h-9 px-3">
                <i class="ti ti-arrow-left text-base"></i> Back
            </x-button>
            <div>
                <h1 class="text-2xl font-bold text-primary-navy">Add New Student</h1>
                <p class="text-sm text-secondary-text">Create a new student account and profile record.</p>
            </div>
        </div>

        <!-- Form Card -->
        <x-form-group title="Student Information" description="Fill out the student's personal and academic details">
            <form method="POST" action="{{ route('admin.students.store') }}" class="space-y-4">
                @csrf

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-form-input
                        name="name"
                        label="Full Name"
                        placeholder="e.g. John Doe"
                        required
                        :value="old('name')"
                        :error="$errors->first('name')"
                    />

                    <x-form-input
                        type="email"
                        name="email"
                        label="Email Address"
                        placeholder="e.g. john@example.com"
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
                        name="student_id"
                        label="Student ID"
                        placeholder="e.g. STU-2207035"
                        required
                        :value="old('student_id')"
                        :error="$errors->first('student_id')"
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
                        name="batch"
                        label="Batch"
                        placeholder="e.g. 2022"
                        required
                        :value="old('batch')"
                        :error="$errors->first('batch')"
                    />
                </div>

                <x-form-input
                    name="phone"
                    label="Phone Number"
                    placeholder="e.g. 01700000001"
                    :value="old('phone')"
                    :error="$errors->first('phone')"
                />

                <x-form-input
                    type="textarea"
                    name="address"
                    label="Home Address"
                    placeholder="e.g. KUET Campus, Khulna"
                    :value="old('address')"
                    :error="$errors->first('address')"
                />

                <div class="pt-4 flex gap-3">
                    <x-button type="submit">Create Student</x-button>
                    <x-button variant="secondary" href="{{ route('admin.students') }}">Cancel</x-button>
                </div>
            </form>
        </x-form-group>
    </div>
@endsection
