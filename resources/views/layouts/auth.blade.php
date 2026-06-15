<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'UniTrack Login')</title>
    @vite(['resources/css/app.css'])
</head>
<body class="h-screen overflow-hidden font-sans text-main-text antialiased">
    <main class="flex h-screen items-center justify-center overflow-hidden bg-gradient-to-br from-gray-300 to-white px-4 py-4 md:px-6 md:py-6">
        @yield('content')
    </main>
</body>
</html>
