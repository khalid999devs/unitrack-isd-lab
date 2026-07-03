@php
    $role = 'teacher';
    $title = 'Teacher Profile';
    $active = 'profile';
@endphp

@extends('layouts.app')

@section('title', 'Teacher Profile - UniTrack')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-primary-navy">My Profile</h1>
            <p class="text-sm text-secondary-text">Review your teacher profile and update your contact information.</p>
        </div>

        @if (session('success'))
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @endif

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <div class="rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card">
                <i class="ti ti-id text-2xl text-primary-blue"></i>
                <p class="mt-3 text-xs font-bold uppercase tracking-wide text-secondary-text">Teacher ID</p>
                <p class="mt-1 break-words text-base font-bold text-main-text">{{ $teacher->teacher_id }}</p>
            </div>

            <div class="rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card">
                <i class="ti ti-building-community text-2xl text-primary-blue"></i>
                <p class="mt-3 text-xs font-bold uppercase tracking-wide text-secondary-text">Department</p>
                <p class="mt-1 break-words text-base font-bold text-main-text">{{ $teacher->department }}</p>
            </div>

            <div class="rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card">
                <i class="ti ti-briefcase text-2xl text-primary-blue"></i>
                <p class="mt-3 text-xs font-bold uppercase tracking-wide text-secondary-text">Designation</p>
                <p class="mt-1 break-words text-base font-bold text-main-text">{{ $teacher->designation }}</p>
            </div>
        </section>

        <x-form-group title="Profile Information" description="Update your name, email, and phone number">
            <form method="POST" action="{{ route('teacher.profile.update') }}" class="space-y-4">
                @csrf

                <div class="grid gap-4 sm:grid-cols-3">
                    <x-form-input
                        name="teacher_id"
                        label="Teacher ID"
                        :value="$teacher->teacher_id"
                        disabled
                    />

                    <x-form-input
                        name="department"
                        label="Department"
                        :value="$teacher->department"
                        disabled
                    />

                    <x-form-input
                        name="designation"
                        label="Designation"
                        :value="$teacher->designation"
                        disabled
                    />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-form-input
                        name="name"
                        label="Full Name"
                        required
                        :value="old('name', $teacher->user->name)"
                        :error="$errors->first('name')"
                    />

                    <x-form-input
                        type="email"
                        name="email"
                        label="Email Address"
                        required
                        :value="old('email', $teacher->user->email)"
                        :error="$errors->first('email')"
                    />
                </div>

                <x-form-input
                    name="phone"
                    label="Phone Number"
                    :value="old('phone', $teacher->phone)"
                    :error="$errors->first('phone')"
                />

                <div class="pt-4">
                    <x-button type="submit">Update Profile</x-button>
                </div>
            </form>
        </x-form-group>
    </div>
@endsection
