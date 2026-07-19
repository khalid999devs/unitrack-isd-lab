<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'UniTrack Login')</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-card-bg font-sans text-main-text antialiased">
    <main class="min-h-screen">
        @yield('content')
    </main>
</body>
</html>
