<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- LineAwesome -->
    <link rel="stylesheet" href="{{ asset('admin/css/line-awesome.min.css') }}">

    <!-- App CSS (WAM Style) -->
    <link rel="stylesheet" href="{{ asset('admin/css/app.css') }}">

    @vite(['resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        /* Global Square Theme */
        *,
        *::before,
        *::after {
            border-radius: 0 !important;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="antialiased">
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-5">
        <div class="mb-4">
            <a href="/" class="text-decoration-none d-flex align-items-center">
                <div class="bg-primary text-white p-2 me-2 d-flex align-items-center justify-content-center"
                    style="width: 45px; height: 45px;">
                    <i class="las la-rocket fs-2"></i>
                </div>
                <span class="h2 fw-bold text-dark mb-0">{{ config('app.name', 'Laravel') }}</span>
            </a>
        </div>

        <div class="w-100 auth-card p-4 p-md-5" style="max-width: 450px;">
            {{ $slot }}
        </div>

        <div class="mt-4 text-muted small">
            &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
        </div>
    </div>
</body>

</html>
