@extends('layouts.auth')

@section('title', 'Login - UniTrack')

@section('content')
    <section class="grid min-h-[640px] w-full max-w-6xl overflow-hidden rounded-[28px] border border-border-soft bg-white shadow-2xl shadow-slate-300/50 lg:grid-cols-2">
        <div class="flex items-center justify-center px-6 py-10 sm:px-10 lg:px-16">
            <div class="w-full max-w-md">
                <div class="mb-12 flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-blue text-white shadow-lg shadow-blue-200">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l8 4-8 4-8-4 8-4z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 11l8 4 8-4"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15l8 4 8-4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-primary-navy">UniTrack</p>
                        <p class="text-sm font-semibold text-secondary-text">Academic Resource System</p>
                    </div>
                </div>

                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-primary-navy">Welcome back</h1>
                    <p class="mt-3 text-sm leading-6 text-secondary-text">Sign in with your UniTrack account. Your role is detected automatically after authentication.</p>
                </div>

                @if ($errors->any())
                    <x-alert type="error" class="mb-6">
                        {{ $errors->first() }}
                    </x-alert>
                @endif

                <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-main-text">Email address</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            required
                            class="h-12 w-full rounded-xl border border-input-border bg-white px-4 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                        >
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-main-text">Password</label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                class="h-12 w-full rounded-xl border border-input-border bg-white px-4 pr-12 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                            >
                            <button
                                type="button"
                                id="toggle-password"
                                class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-secondary-text transition hover:text-primary-blue"
                                aria-label="Show password"
                                aria-pressed="false"
                            >
                                <i id="toggle-password-icon" class="ti ti-eye text-xl"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <label class="flex items-center gap-3 text-sm font-medium text-main-text">
                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                class="h-4 w-4 rounded border-input-border text-primary-blue focus:ring-focus-ring"
                            >
                            Remember me
                        </label>
                        <span class="text-sm text-secondary-text">Need access? Contact admin</span>
                    </div>

                    <x-button type="submit" class="h-12 w-full rounded-xl">Sign in</x-button>
                </form>
            </div>
        </div>

        <div class="relative hidden overflow-hidden bg-gradient-to-br from-primary-blue via-royal-blue to-primary-navy p-10 text-white lg:block">
            <div class="relative z-10 flex h-full flex-col justify-between">
                <div class="max-w-sm">
                    <p class="text-sm font-semibold text-blue-100">Role-based academic operations</p>
                    <h2 class="mt-4 text-4xl font-bold leading-tight">One workspace for students, teachers, and admins.</h2>
                    <p class="mt-4 text-sm leading-6 text-blue-100">UniTrack connects course data, routines, notices, materials, assignments, and submissions from a single Laravel backend.</p>
                </div>

                <div class="rounded-3xl border border-white/20 bg-white/10 p-6 backdrop-blur">
                    <div class="mb-5 flex items-center justify-between">
                        <p class="text-sm font-bold">Live modules</p>
                        <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-bold">V1</span>
                    </div>
                    <div class="grid gap-3">
                        <div class="flex items-center justify-between rounded-2xl bg-white p-4 text-primary-navy">
                            <span class="font-bold">Course & routine flow</span>
                            <i class="ti ti-check text-2xl text-success"></i>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl bg-white/15 p-4">
                            <span class="font-bold">Materials & assignments</span>
                            <i class="ti ti-cloud-upload text-2xl"></i>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl bg-white/15 p-4">
                            <span class="font-bold">Role protected dashboards</span>
                            <i class="ti ti-shield-check text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <svg class="absolute bottom-12 right-10 h-72 w-72 text-white/20" viewBox="0 0 240 240" fill="none" aria-hidden="true">
                <rect x="42" y="58" width="156" height="108" rx="18" stroke="currentColor" stroke-width="8"/>
                <path d="M78 188h84" stroke="currentColor" stroke-width="8" stroke-linecap="round"/>
                <path d="M104 166l-8 22h48l-8-22" stroke="currentColor" stroke-width="8" stroke-linejoin="round"/>
                <circle cx="120" cy="112" r="34" fill="currentColor"/>
                <path d="M102 113l13 13 27-31" stroke="#ffffff" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M39 36h42M160 37h26M185 190h22M28 174h34" stroke="currentColor" stroke-width="6" stroke-linecap="round"/>
                <circle cx="198" cy="74" r="10" stroke="currentColor" stroke-width="6"/>
                <circle cx="47" cy="117" r="8" stroke="currentColor" stroke-width="6"/>
            </svg>
        </div>
    </section>

    <script>
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('toggle-password');
        const toggleIcon = document.getElementById('toggle-password-icon');

        toggleButton?.addEventListener('click', () => {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            toggleButton.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
            toggleButton.setAttribute('aria-pressed', String(isHidden));
            toggleIcon.className = isHidden ? 'ti ti-eye-off text-xl' : 'ti ti-eye text-xl';
        });
    </script>
@endsection
