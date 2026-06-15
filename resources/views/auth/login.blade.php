@extends('layouts.auth')

@section('title', 'Login - UniTrack')

@section('content')
    <section class="w-full max-w-[420px] rounded-[20px] border border-border-soft bg-card-bg p-8 shadow-auth-card">
        <div class="mb-8 text-center">
            <p class="text-sm font-bold uppercase tracking-[0.18em] text-primary-blue">UniTrack</p>
            <h1 class="mt-3 text-3xl font-bold text-primary-navy">Academic Login</h1>
            <p class="mt-2 text-sm leading-6 text-secondary-text">Student Academic Resource Management System</p>
        </div>

        @if ($errors->any())
            <x-alert type="error" class="mb-6">
                {{ $errors->first() }}
            </x-alert>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-main-text">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    placeholder="name@example.com"
                    required
                    class="h-11 w-full rounded-[10px] border border-input-border px-3 text-sm outline-none transition placeholder:text-placeholder-text focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                >
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-main-text">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Enter password"
                    required
                    class="h-11 w-full rounded-[10px] border border-input-border px-3 text-sm outline-none transition placeholder:text-placeholder-text focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                >
            </div>

            <x-button type="submit" class="w-full">Login</x-button>
        </form>

        <div class="mt-6 grid gap-3 sm:grid-cols-3">
            <x-button href="{{ route('student.dashboard') }}" variant="secondary" class="h-10 px-3 text-xs">Student</x-button>
            <x-button href="{{ route('teacher.dashboard') }}" variant="secondary" class="h-10 px-3 text-xs">Teacher</x-button>
            <x-button href="{{ route('admin.dashboard') }}" variant="secondary" class="h-10 px-3 text-xs">Admin</x-button>
        </div>
    </section>
@endsection
