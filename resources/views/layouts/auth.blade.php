<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'UniTrack Login')</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen font-sans text-main-text antialiased">
    <main class="flex min-h-screen items-center justify-center overflow-y-auto bg-gradient-to-br from-soft-blue-bg via-white to-muted-bg px-4 py-6 md:px-6">
        @yield('content')
    </main>
</body>
</html>
