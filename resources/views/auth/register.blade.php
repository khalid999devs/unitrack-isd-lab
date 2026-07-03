@extends('layouts.auth')

@section('title', 'Request Access - UniTrack')

@section('content')
    <section class="grid min-h-screen bg-white lg:grid-cols-[1.04fr_0.96fr]">
        <div class="flex min-h-screen items-center justify-center overflow-y-auto px-6 py-10 sm:px-10 lg:px-16">
            <div class="w-full max-w-2xl">
                <a href="{{ route('login') }}" class="mb-10 inline-flex items-center gap-3">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-blue text-white shadow-lg shadow-blue-200">
                        <i class="ti ti-layers-intersect text-2xl"></i>
                    </span>
                    <span>
                        <span class="block text-2xl font-black tracking-[0.18em] text-primary-navy">UNITRACK</span>
                        <span class="block text-xs font-bold uppercase tracking-[0.18em] text-secondary-text">Academic Resource System</span>
                    </span>
                </a>

                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-primary-blue">Access request</p>
                    <h1 class="mt-4 text-4xl font-black tracking-normal text-primary-navy sm:text-5xl">Create your account request</h1>
                    <p class="mt-4 max-w-xl text-base leading-7 text-secondary-text">
                        Student and teacher registrations are reviewed by an admin before dashboard access is enabled.
                    </p>
                </div>

                @if ($errors->any())
                    <x-alert type="error" class="mt-7">
                        {{ $errors->first() }}
                    </x-alert>
                @endif

                <form method="POST" action="{{ route('register.store') }}" class="mt-8 space-y-5">
                    @csrf

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="role" class="mb-2 block text-sm font-bold text-main-text">Account type</label>
                            <select
                                id="role"
                                name="role"
                                class="h-12 w-full rounded-xl border border-input-border bg-white px-4 text-sm font-semibold outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                                required
                            >
                                <option value="student" @selected(old('role', 'student') === 'student')>Student</option>
                                <option value="teacher" @selected(old('role') === 'teacher')>Teacher</option>
                            </select>
                        </div>

                        <div>
                            <label for="department" class="mb-2 block text-sm font-bold text-main-text">Department</label>
                            <input
                                id="department"
                                name="department"
                                type="text"
                                value="{{ old('department') }}"
                                required
                                class="h-12 w-full rounded-xl border border-input-border bg-white px-4 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                            >
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="name" class="mb-2 block text-sm font-bold text-main-text">Full name</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                autocomplete="name"
                                required
                                class="h-12 w-full rounded-xl border border-input-border bg-white px-4 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                            >
                        </div>

                        <div>
                            <label for="email" class="mb-2 block text-sm font-bold text-main-text">Email address</label>
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
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="password" class="mb-2 block text-sm font-bold text-main-text">Password</label>
                            <div class="relative">
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    autocomplete="new-password"
                                    required
                                    class="h-12 w-full rounded-xl border border-input-border bg-white px-4 pr-12 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                                >
                                <button type="button" data-password-toggle="password" class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-secondary-text transition hover:text-primary-blue" aria-label="Show password" aria-pressed="false">
                                    <i class="ti ti-eye text-xl"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-2 block text-sm font-bold text-main-text">Confirm password</label>
                            <div class="relative">
                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    autocomplete="new-password"
                                    required
                                    class="h-12 w-full rounded-xl border border-input-border bg-white px-4 pr-12 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                                >
                                <button type="button" data-password-toggle="password_confirmation" class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-secondary-text transition hover:text-primary-blue" aria-label="Show password confirmation" aria-pressed="false">
                                    <i class="ti ti-eye text-xl"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2" data-role-fields="student">
                        <div>
                            <label for="student_id" class="mb-2 block text-sm font-bold text-main-text">Student ID</label>
                            <input id="student_id" name="student_id" type="text" value="{{ old('student_id') }}" class="h-12 w-full rounded-xl border border-input-border bg-white px-4 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                        </div>
                        <div>
                            <label for="semester" class="mb-2 block text-sm font-bold text-main-text">Semester</label>
                            <input id="semester" name="semester" type="text" value="{{ old('semester') }}" class="h-12 w-full rounded-xl border border-input-border bg-white px-4 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                        </div>
                        <div>
                            <label for="batch" class="mb-2 block text-sm font-bold text-main-text">Batch</label>
                            <input id="batch" name="batch" type="text" value="{{ old('batch') }}" class="h-12 w-full rounded-xl border border-input-border bg-white px-4 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                        </div>
                        <div>
                            <label for="address" class="mb-2 block text-sm font-bold text-main-text">Address</label>
                            <input id="address" name="address" type="text" value="{{ old('address') }}" class="h-12 w-full rounded-xl border border-input-border bg-white px-4 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2" data-role-fields="teacher">
                        <div>
                            <label for="teacher_id" class="mb-2 block text-sm font-bold text-main-text">Teacher ID</label>
                            <input id="teacher_id" name="teacher_id" type="text" value="{{ old('teacher_id') }}" class="h-12 w-full rounded-xl border border-input-border bg-white px-4 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                        </div>
                        <div>
                            <label for="designation" class="mb-2 block text-sm font-bold text-main-text">Designation</label>
                            <input id="designation" name="designation" type="text" value="{{ old('designation') }}" class="h-12 w-full rounded-xl border border-input-border bg-white px-4 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring">
                        </div>
                    </div>

                    <div>
                        <label for="phone" class="mb-2 block text-sm font-bold text-main-text">Phone</label>
                        <input
                            id="phone"
                            name="phone"
                            type="text"
                            value="{{ old('phone') }}"
                            class="h-12 w-full rounded-xl border border-input-border bg-white px-4 text-sm outline-none transition focus:border-primary-blue focus:ring-4 focus:ring-focus-ring"
                        >
                    </div>

                    <button type="submit" class="inline-flex h-12 w-full items-center justify-center rounded-xl bg-primary-blue px-5 text-base font-black text-white transition hover:bg-royal-blue focus:outline-none focus:ring-4 focus:ring-focus-ring">
                        Submit request
                    </button>

                    <p class="text-center text-sm font-semibold text-secondary-text">
                        Already approved?
                        <a href="{{ route('login') }}" class="font-black text-primary-blue transition hover:text-royal-blue">Sign in</a>
                    </p>
                </form>
            </div>
        </div>

        <aside class="hidden min-h-screen items-center justify-center bg-soft-blue-bg px-10 py-12 lg:flex">
            <div class="flex h-full max-h-[880px] w-full max-w-[650px] flex-col justify-between overflow-hidden rounded-[32px] bg-primary-navy p-10 text-white shadow-2xl shadow-slate-300/60 xl:p-14">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.22em] text-blue-100">Admin-approved onboarding</p>
                    <h2 class="mt-4 max-w-lg text-4xl font-black leading-tight xl:text-5xl">
                        Request access, then enter through the correct role flow.
                    </h2>
                    <p class="mt-5 max-w-md text-base leading-7 text-blue-100">
                        Admins review each request before UniTrack creates the connected account and academic profile.
                    </p>
                </div>

                <div class="my-8 flex min-h-0 flex-1 items-center justify-center">
                    <img
                        src="{{ asset('images/auth-illustration.svg') }}"
                        alt="Account approval illustration"
                        class="max-h-[390px] w-full object-contain"
                    >
                </div>

                <div class="grid gap-3">
                    <div class="rounded-2xl bg-white p-4 text-primary-navy">
                        <p class="text-xs font-black uppercase tracking-wide text-primary-blue">Approval flow</p>
                        <p class="mt-2 text-sm font-bold">Pending request to approved account, all from the database.</p>
                    </div>
                </div>
            </div>
        </aside>
    </section>

    <script>
        const roleSelect = document.getElementById('role');
        const fieldGroups = document.querySelectorAll('[data-role-fields]');

        const syncRoleFields = () => {
            fieldGroups.forEach((group) => {
                const isActive = group.dataset.roleFields === roleSelect.value;
                group.classList.toggle('hidden', !isActive);
                group.querySelectorAll('input').forEach((input) => {
                    input.disabled = !isActive;
                    input.required = isActive && ['student_id', 'semester', 'batch', 'teacher_id', 'designation'].includes(input.name);
                });
            });
        };

        roleSelect?.addEventListener('change', syncRoleFields);
        syncRoleFields();

        document.querySelectorAll('[data-password-toggle]').forEach((button) => {
            const input = document.getElementById(button.dataset.passwordToggle);
            const icon = button.querySelector('i');

            button.addEventListener('click', () => {
                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                button.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
                button.setAttribute('aria-pressed', String(isHidden));
                icon.className = isHidden ? 'ti ti-eye-off text-xl' : 'ti ti-eye text-xl';
            });
        });
    </script>
@endsection
