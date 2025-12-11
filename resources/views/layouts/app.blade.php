<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'MuslimApp' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    @include('layouts.navbar')
    <main class="max-w-5xl mx-auto px-4">
        @yield('content')
    </main>
    <footer class="mt-12 text-center text-gray-400 text-sm">
        &copy; {{ date('Y') }} MuslimApp. All rights reserved.
    </footer>
</body>
</html>