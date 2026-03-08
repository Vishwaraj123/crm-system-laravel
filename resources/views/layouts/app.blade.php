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
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/toastr.min.css') }}">
    
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
        
        /* Global Square Theme */
        :root {
            --bs-border-radius: 0 !important;
            --bs-border-radius-sm: 0 !important;
            --bs-border-radius-lg: 0 !important;
            --bs-border-radius-xl: 0 !important;
            --bs-border-radius-2xl: 0 !important;
            --bs-border-radius-pill: 0 !important;
        }
        
        *, *::before, *::after {
            border-radius: 0 !important;
        }

        /* Fix duplicate toastr icons and giant 'V' glitch */
        .toast-success {
            background-image: none !important;
            padding-left: 50px !important;
        }
        .toast-success:before {
            content: "\f00c" !important; /* LineAwesome check icon */
            font-family: 'Line Awesome Free' !important;
            font-weight: 900 !important;
            position: absolute !important;
            left: 15px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            font-size: 20px !important;
            color: white !important;
            display: block !important;
        }
        .toast-success:after {
            display: none !important;
        }
        /* Ensure close button doesn't inherit LineAwesome and isn't glitched */
        button.toast-close-button {
            font-family: Arial, sans-serif !important;
            opacity: 0.8 !important;
            text-shadow: none !important;
            background: none !important;
            border: none !important;
            font-size: 20px !important;
            line-height: 1 !important;
        }

        /* Fix dropdown item hover text disappearance */
        .dropdown-item:hover, .dropdown-item:focus {
            color: #ffffff !important;
            background-color: #3f52e3 !important; /* Force a dark background */
        }
        .dropdown-item:hover i, .dropdown-item:focus i {
            color: #ffffff !important;
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

    <!-- Toastr JS -->
    <script src="{{ asset('admin/js/toastr.min.js') }}"></script>

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
