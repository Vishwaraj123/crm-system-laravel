<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- LineAwesome -->
    <link rel="stylesheet" href="{{ asset('admin/css/line-awesome.min.css') }}">
    
    <!-- DataTables CSS -->
    <link href="{{ asset('admin/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    
    <!-- App CSS (WAM Style) -->
    <link rel="stylesheet" href="{{ asset('admin/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/responsive.min.css') }}">
    
    @stack('css')
    
    <style>
        /* Custom spacing for fixed layout */
        .main-wrapper {
            padding-left: 250px;
            transition: all 0.3s;
        }
        .header-position {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: white;
            z-index: 1050;
            border-right: 1px solid #e5e7eb;
            transition: all 0.3s;
        }
        @media (max-width: 991px) {
            .main-wrapper { padding-left: 0; }
            .header-position { left: -250px; }
            .header-position.active { left: 0; }
        }
    </style>
</head>
<body>

    @include('layouts.sidebar')

    <div class="main-wrapper">
        @include('layouts.header')

        <div class="container-fluid py-4 min-vh-100">
            @if(isset($header))
                <header class="mb-4">
                    {{ $header }}
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>

        @include('layouts.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/js/dataTables.responsive.min.js') }}"></script>
    
    <!-- App JS (WAM Style) -->
    <script src="{{ asset('admin/js/app.js') }}"></script>

    @stack('scripts')
    
    <script>
        $(document).ready(function() {
            $('.sidebar-toggler').on('click', function() {
                $('.header-position').toggleClass('active');
            });
        });
    </script>
</body>
</html>
