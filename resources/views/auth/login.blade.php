@extends('layouts.auth')

@section('title', 'Login - UniTrack')

@section('content')
    <section class="grid min-h-screen bg-white lg:grid-cols-[0.92fr_1.08fr]">
        <div class="flex min-h-screen items-center justify-center px-6 py-10 sm:px-10 lg:px-16">
            <div class="w-full max-w-[440px]">
                <a href="{{ route('login') }}" class="mb-12 inline-flex items-center gap-3">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-blue text-white shadow-lg shadow-blue-200">
                        <i class="ti ti-layers-intersect text-2xl"></i>
                    </span>
                    <span>
                        <span class="block text-2xl font-black tracking-[0.18em] text-primary-navy">UNITRACK</span>
                        <span class="block text-xs font-bold uppercase tracking-[0.18em] text-secondary-text">Academic Resource System</span>
                    </span>
                </a>

                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-primary-blue">Secure sign in</p>
                    <h1 class="mt-4 text-4xl font-black tracking-normal text-primary-navy sm:text-5xl">Welcome back</h1>
                    <p class="mt-4 text-base leading-7 text-secondary-text">
                        Sign in once and UniTrack opens the right workspace from your approved account role.
                    </p>
                </div>

                @if (session('success'))
                    <x-alert type="success" class="mt-7">
                        {{ session('success') }}
                    </x-alert>
                @endif

                @if ($errors->any())
                    <x-alert type="error" class="mt-7">
                        {{ $errors->first() }}
                    </x-alert>
                @endif

                <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-bold text-main-text">Email address</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            required
                            class="h-[52px] w-full rounded-xl border border-input-border bg-white px-4 text-base outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                        >
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-bold text-main-text">Password</label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                class="h-[52px] w-full rounded-xl border border-input-border bg-white px-4 pr-12 text-base outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
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
                        <label class="flex items-center gap-3 text-sm font-semibold text-main-text">
                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                class="h-4 w-4 rounded border-input-border text-primary-blue focus:ring-focus-ring"
                            >
                            Remember me
                        </label>
                        <a href="{{ route('register') }}" class="text-sm font-bold text-primary-blue transition hover:text-royal-blue">
                            Request access
                        </a>
                    </div>

                    <button type="submit" class="inline-flex h-[52px] w-full items-center justify-center rounded-xl bg-primary-blue px-5 text-base font-black text-white transition hover:bg-royal-blue focus:outline-none focus:ring-4 focus:ring-focus-ring">
                        Sign in
                    </button>
                </form>
            </div>
        </div>

        <aside class="hidden min-h-screen items-center justify-center bg-soft-blue-bg px-10 py-12 lg:flex">
            <div class="relative flex h-full max-h-[880px] w-full max-w-[720px] flex-col justify-between overflow-hidden rounded-[32px] bg-primary-navy p-10 text-white shadow-2xl shadow-slate-300/60 xl:p-14">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-[0.22em] text-blue-100">Role-aware access</p>
                        <h2 class="mt-4 max-w-xl text-4xl font-black leading-tight xl:text-5xl">
                            One doorway into every academic workspace.
                        </h2>
                    </div>
                    <span class="shrink-0 rounded-full border border-white/20 px-4 py-2 text-xs font-black uppercase tracking-wide text-blue-100">V1 Core</span>
                </div>

                <div class="my-8 flex min-h-0 flex-1 items-center justify-center">
                    <img
                        src="{{ asset('images/auth-illustration.svg') }}"
                        alt="Secure academic login illustration"
                        class="max-h-[390px] w-full object-contain"
                    >
                </div>

                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="rounded-2xl bg-white p-4 text-primary-navy">
                        <p class="text-xs font-black uppercase tracking-wide text-primary-blue">Students</p>
                        <p class="mt-2 text-sm font-bold">Courses, routines, materials, assignments</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 p-4">
                        <p class="text-xs font-black uppercase tracking-wide text-blue-100">Teachers</p>
                        <p class="mt-2 text-sm font-bold">Content publishing and submissions</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 p-4">
                        <p class="text-xs font-black uppercase tracking-wide text-blue-100">Admins</p>
                        <p class="mt-2 text-sm font-bold">Approvals and academic management</p>
                    </div>
                </div>
            </div>
        </aside>
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
