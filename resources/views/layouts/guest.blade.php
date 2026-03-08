<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-light font-sans text-dark antialiased">
        <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center pt-5 bg-light">
            <div>
                <a href="/" class="text-decoration-none h1 fw-bold text-secondary">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="w-100 mt-4 px-4 py-4 bg-white shadow-sm overflow-hidden rounded" style="max-width: 400px;">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
