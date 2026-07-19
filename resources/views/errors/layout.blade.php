<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('code') - UniTrack</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-page-bg font-sans text-main-text antialiased">
    @php
        $homeUrl = match (auth()->user()?->role) {
            'admin' => route('admin.dashboard'),
            'teacher' => route('teacher.dashboard'),
            'student' => route('student.dashboard'),
            default => route('login'),
        };
    @endphp

    <main class="flex min-h-screen items-center justify-center px-6 py-12">
        <section class="w-full max-w-xl rounded-2xl border border-border-soft bg-card-bg p-8 text-center shadow-card sm:p-12">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-soft-blue-bg text-primary-blue">
                <i class="ti @yield('icon', 'ti-alert-circle') text-3xl"></i>
            </div>
            <p class="mt-6 text-sm font-bold uppercase tracking-[0.18em] text-primary-blue">Error @yield('code')</p>
            <h1 class="mt-3 text-3xl font-bold text-primary-navy">@yield('heading')</h1>
            <p class="mx-auto mt-3 max-w-md text-sm leading-6 text-secondary-text">@yield('message')</p>
            <div class="mt-7 flex flex-wrap justify-center gap-3">
                <a href="{{ $homeUrl }}" class="inline-flex h-11 items-center justify-center rounded-[10px] bg-primary-blue px-5 text-sm font-bold text-on-primary transition hover:bg-royal-blue">Go to dashboard</a>
                <button type="button" onclick="history.back()" class="inline-flex h-11 items-center justify-center rounded-[10px] border border-input-border bg-card-bg px-5 text-sm font-bold text-secondary-action-text transition hover:bg-muted-bg">Go back</button>
            </div>
        </section>
    </main>
</body>
</html>
