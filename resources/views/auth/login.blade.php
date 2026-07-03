@extends('layouts.auth')

@section('title', 'Login - UniTrack')

@section('content')
    <section class="w-full max-w-[860px] h-[calc(100vh-2rem)] max-h-[calc(100vh-2rem)] overflow-hidden rounded-[24px] border border-white/60 bg-white shadow-2xl shadow-slate-300/40 md:h-[calc(100vh-3rem)] md:max-h-[calc(100vh-3rem)]">
        <div class="grid h-full min-h-0 md:grid-cols-2">
            <div class="flex h-full min-h-0 items-center justify-center bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700 px-6 py-8 text-center text-white md:px-8 md:py-10">
                <div class="max-w-sm">
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-white/15 text-white ring-1 ring-white/20 md:mb-6 md:h-16 md:w-16">
                        <svg class="h-8 w-8 md:h-9 md:w-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l8 4-8 4-8-4 8-4z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 11l8 4 8-4"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15l8 4 8-4"></path>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold tracking-[0.28em] sm:text-4xl md:text-5xl">UNITRACK</p>
                    <p class="mx-auto mt-3 max-w-xs text-xs leading-5 text-white/90 sm:text-sm md:text-[0.95rem]">Student Academic Resource Management System</p>
                </div>
            </div>

            <div class="flex h-full min-h-0 items-center justify-center bg-white px-6 py-8 md:px-8 md:py-10">
                <div class="w-full max-w-[360px]">
                    <div class="mb-6 text-center md:mb-8">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-primary-blue md:text-sm">UniTrack</p>
                        <h1 class="mt-2 text-2xl font-bold text-primary-navy md:mt-3 md:text-3xl">Academic Login</h1>
                        <p class="mt-2 text-xs leading-5 text-secondary-text md:text-sm md:leading-6">Student Academic Resource Management System</p>
                    </div>

                    @if ($errors->any())
                        <x-alert type="error" class="mb-6">
                            {{ $errors->first() }}
                        </x-alert>
                    @endif

                    <form method="POST" action="{{ route('login.store') }}" class="space-y-4 md:space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-xs font-semibold text-main-text md:text-sm">Email</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                placeholder="name@example.com"
                                required
                                class="h-10 w-full rounded-[10px] border border-input-border px-3 text-sm outline-none transition placeholder:text-placeholder-text focus:border-primary-blue focus:ring-4 focus:ring-focus-ring md:h-11"
                            >
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-xs font-semibold text-main-text md:text-sm">Password</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                placeholder="Enter password"
                                required
                                class="h-10 w-full rounded-[10px] border border-input-border px-3 text-sm outline-none transition placeholder:text-placeholder-text focus:border-primary-blue focus:ring-4 focus:ring-focus-ring md:h-11"
                            >
                        </div>

                        <x-button type="submit" class="w-full">Login</x-button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
