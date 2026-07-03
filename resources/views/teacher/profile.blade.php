@php
    $role = 'teacher';
    $title = 'Teacher Profile';
    $active = 'profile';
    $teacherName = $teacher->user->name;
    $nameParts = preg_split('/\s+/', trim($teacherName)) ?: [];
    $teacherInitials = strtoupper(substr($nameParts[0] ?? 'T', 0, 1).substr($nameParts[1] ?? '', 0, 1));
@endphp

@extends('layouts.app')

@section('title', 'Teacher Profile - UniTrack')

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @endif

        <section class="rounded-2xl border border-border-soft bg-white p-6 shadow-card">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex min-w-0 items-center gap-4">
                    <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-indigo-accent text-2xl font-bold text-white shadow-lg shadow-indigo-200">
                        {{ $teacherInitials }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-indigo-accent">Teacher Account</p>
                        <h2 class="mt-1 break-words text-2xl font-bold text-primary-navy">{{ $teacherName }}</h2>
                        <p class="mt-1 break-words text-sm text-secondary-text">{{ $teacher->user->email }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-3 sm:min-w-72 sm:grid-cols-2">
                    <div class="rounded-xl border border-border-soft bg-muted-bg px-4 py-3">
                        <p class="text-xs font-bold uppercase tracking-wide text-secondary-text">Teacher ID</p>
                        <p class="mt-1 break-words text-lg font-bold text-main-text">{{ $teacher->teacher_id }}</p>
                    </div>
                    <div class="rounded-xl border border-border-soft bg-muted-bg px-4 py-3">
                        <p class="text-xs font-bold uppercase tracking-wide text-secondary-text">Designation</p>
                        <p class="mt-1 break-words text-lg font-bold text-main-text">{{ $teacher->designation }}</p>
                    </div>
                </div>
            </div>
        </section>

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
