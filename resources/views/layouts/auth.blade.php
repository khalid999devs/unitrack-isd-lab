<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'UniTrack Login')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-white font-sans text-main-text antialiased">
    <main class="min-h-screen">
        @yield('content')
    </main>
</body>
</html>
