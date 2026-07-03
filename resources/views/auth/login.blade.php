@extends('layouts.auth')

@section('title', 'Login - UniTrack')

@section('content')
    <section class="w-full max-w-5xl overflow-hidden rounded-3xl border border-white/80 bg-white shadow-2xl shadow-slate-300/50 md:grid md:grid-cols-[0.85fr_1.15fr]">
        <div class="hidden bg-primary-navy p-8 text-white md:flex md:flex-col md:justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-primary-blue shadow-lg">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l8 4-8 4-8-4 8-4z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 11l8 4 8-4"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15l8 4 8-4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xl font-bold tracking-[0.22em]">UNITRACK</p>
                        <p class="text-xs font-semibold uppercase tracking-wide text-blue-200">Academic resource system</p>
                    </div>
                </div>

                <div class="mt-12">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-200">Role-aware sign in</p>
                    <h1 class="mt-4 text-4xl font-bold leading-tight text-white">One clean entry point.</h1>
                    <p class="mt-4 max-w-sm text-sm leading-6 text-blue-100">Your saved role opens the right UniTrack workspace automatically.</p>
                </div>
            </div>

            <div class="grid gap-3">
                <div class="rounded-2xl border border-white/10 bg-white/10 p-4">
                    <p class="text-xs font-bold uppercase tracking-wide text-blue-200">Demo password</p>
                    <p class="mt-1 text-2xl font-bold text-white">password</p>
                </div>
                <div class="grid grid-cols-3 gap-2 text-center text-xs font-bold uppercase tracking-wide text-blue-100">
                    <span class="rounded-full border border-white/15 px-3 py-2">Student</span>
                    <span class="rounded-full border border-white/15 px-3 py-2">Teacher</span>
                    <span class="rounded-full border border-white/15 px-3 py-2">Admin</span>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center bg-white px-6 py-8 sm:px-10 lg:px-14">
            <div class="w-full max-w-md">
                <div class="mb-8 md:hidden">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-blue text-white shadow-lg">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l8 4-8 4-8-4 8-4z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 11l8 4 8-4"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15l8 4 8-4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xl font-bold tracking-[0.22em] text-primary-navy">UNITRACK</p>
                            <p class="text-xs font-semibold uppercase tracking-wide text-secondary-text">Academic resource system</p>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-primary-blue">Secure sign in</p>
                    <h2 class="mt-3 text-3xl font-bold text-primary-navy">Open your workspace</h2>
                    <p class="mt-3 text-sm leading-6 text-secondary-text">Enter your email and password. UniTrack will route the account by its stored role.</p>
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
                            class="h-12 w-full rounded-xl border border-input-border bg-white px-4 text-sm outline-none transition placeholder:text-placeholder-text focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
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
                            class="h-12 w-full rounded-xl border border-input-border bg-white px-4 text-sm outline-none transition placeholder:text-placeholder-text focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                        >
                    </div>

                    <x-button type="submit" class="h-12 w-full rounded-xl">Login</x-button>
                </form>

                <div class="mt-6 rounded-2xl border border-border-soft bg-muted-bg p-4">
                    <p class="text-xs font-bold uppercase tracking-wide text-secondary-text">Demo Accounts</p>
                    <div class="mt-3 grid gap-2 text-sm text-main-text">
                        <div class="flex items-center justify-between gap-3">
                            <span>student@unitrack.test</span>
                            <span class="font-bold text-primary-blue">Student</span>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <span>teacher@unitrack.test</span>
                            <span class="font-bold text-primary-blue">Teacher</span>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <span>admin@unitrack.test</span>
                            <span class="font-bold text-primary-blue">Admin</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
