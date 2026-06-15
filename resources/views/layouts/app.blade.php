<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'UniTrack')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-page-bg font-sans text-main-text antialiased">
    <div class="min-h-screen lg:flex">
        <x-sidebar :role="$role ?? 'student'" :active="$active ?? 'dashboard'" />

        <div class="min-w-0 flex-1">
            <x-navbar :title="$title ?? 'Dashboard'" :role="$role ?? 'student'" />

            <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
