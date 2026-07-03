@php
    $role = 'student';
    $title = 'Student Profile';
    $active = 'profile';
    $studentName = $student->user->name;
    $nameParts = preg_split('/\s+/', trim($studentName)) ?: [];
    $studentInitials = strtoupper(substr($nameParts[0] ?? 'S', 0, 1).substr($nameParts[1] ?? '', 0, 1));
@endphp

@extends('layouts.app')

@section('title', 'Student Profile - UniTrack')

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
                    <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-primary-blue text-2xl font-bold text-white shadow-lg shadow-blue-200">
                        {{ $studentInitials }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-primary-blue">Student Account</p>
                        <h2 class="mt-1 break-words text-2xl font-bold text-primary-navy">{{ $studentName }}</h2>
                        <p class="mt-1 break-words text-sm text-secondary-text">{{ $student->user->email }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 sm:min-w-64">
                    <div class="rounded-xl border border-border-soft bg-muted-bg px-4 py-3">
                        <p class="text-xs font-bold uppercase tracking-wide text-secondary-text">Semester</p>
                        <p class="mt-1 text-lg font-bold text-main-text">{{ $student->semester }}</p>
                    </div>
                    <div class="rounded-xl border border-border-soft bg-muted-bg px-4 py-3">
                        <p class="text-xs font-bold uppercase tracking-wide text-secondary-text">Batch</p>
                        <p class="mt-1 text-lg font-bold text-main-text">{{ $student->batch }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card">
                <i class="ti ti-id text-2xl text-primary-blue"></i>
                <p class="mt-3 text-xs font-bold uppercase tracking-wide text-secondary-text">Student ID</p>
                <p class="mt-1 break-words text-base font-bold text-main-text">{{ $student->student_id }}</p>
            </div>

            <div class="rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card">
                <i class="ti ti-building-community text-2xl text-primary-blue"></i>
                <p class="mt-3 text-xs font-bold uppercase tracking-wide text-secondary-text">Department</p>
                <p class="mt-1 break-words text-base font-bold text-main-text">{{ $student->department }}</p>
            </div>

            <div class="rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card">
                <i class="ti ti-school text-2xl text-primary-blue"></i>
                <p class="mt-3 text-xs font-bold uppercase tracking-wide text-secondary-text">Semester</p>
                <p class="mt-1 break-words text-base font-bold text-main-text">{{ $student->semester }}</p>
            </div>

            <div class="rounded-2xl border border-border-soft bg-card-bg p-5 shadow-card">
                <i class="ti ti-users-group text-2xl text-primary-blue"></i>
                <p class="mt-3 text-xs font-bold uppercase tracking-wide text-secondary-text">Batch</p>
                <p class="mt-1 break-words text-base font-bold text-main-text">{{ $student->batch }}</p>
            </div>
        </section>

        <x-form-group title="Profile Information" description="Update your name, email, phone, and address">
            <form method="POST" action="{{ route('student.profile.update') }}" class="space-y-4">
                @csrf

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-form-input
                        name="student_id"
                        label="Student ID"
                        :value="$student->student_id"
                        disabled
                    />

                    <x-form-input
                        name="department"
                        label="Department"
                        :value="$student->department"
                        disabled
                    />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-form-input
                        name="semester"
                        label="Semester"
                        :value="$student->semester"
                        disabled
                    />

                    <x-form-input
                        name="batch"
                        label="Batch"
                        :value="$student->batch"
                        disabled
                    />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-form-input
                        name="name"
                        label="Full Name"
                        required
                        :value="old('name', $student->user->name)"
                        :error="$errors->first('name')"
                    />

                    <x-form-input
                        type="email"
                        name="email"
                        label="Email Address"
                        required
                        :value="old('email', $student->user->email)"
                        :error="$errors->first('email')"
                    />
                </div>

                <x-form-input
                    name="phone"
                    label="Phone Number"
                    :value="old('phone', $student->phone)"
                    :error="$errors->first('phone')"
                />

                <x-form-input
                    type="textarea"
                    name="address"
                    label="Address"
                    :value="old('address', $student->address)"
                    :error="$errors->first('address')"
                />

                <div class="pt-4">
                    <x-button type="submit">Update Profile</x-button>
                </div>
            </form>
        </x-form-group>
    </div>
@endsection
