<div id="sidebar-wrapper">
    <div class="sidebar-heading">
        <div class="d-flex align-items-center">
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-2">
                <path d="M5 10C5 7.23858 7.23858 5 10 5H20L35 20V30C35 32.7614 32.7614 35 30 35H10C7.23858 35 5 32.7614 5 30V10Z" fill="#2563EB"/>
                <path d="M15 15L25 25M25 15L15 25" stroke="white" stroke-width="3" stroke-linecap="round"/>
            </svg>
        </div>
    </div>
    
    <div class="list-group list-group-flush mt-2">
        <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="las la-tachometer-alt fs-4 me-2"></i> {{ __('Dashboard') }}
        </a>
        <a href="{{ route('clients.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('clients.*') ? 'active' : '' }}">
            <i class="las la-user fs-4 me-2"></i> {{ __('Customers') }}
        </a>
        <a href="{{ route('invoices.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
            <i class="las la-file-invoice-dollar fs-4 me-2"></i> {{ __('Invoices') }}
        </a>
        <a href="{{ route('offers.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('offers.*') ? 'active' : '' }}">
            <i class="las la-file-alt fs-4 me-2"></i> {{ __('Quotes') }}
        </a>
        <a href="{{ route('payments.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('payments.*') ? 'active' : '' }}">
            <i class="las la-credit-card fs-4 me-2"></i> {{ __('Payments') }}
        </a>
        <a href="#" class="list-group-item list-group-item-action">
            <i class="las la-wallet fs-4 me-2"></i> {{ __('Payments Mode') }}
        </a>
        <a href="#" class="list-group-item list-group-item-action">
            <i class="las la-percent fs-4 me-2"></i> {{ __('Taxes') }}
        </a>
        <a href="{{ route('about') }}" class="list-group-item list-group-item-action">
            <i class="las la-info-circle fs-4 me-2"></i> {{ __('About') }}
        </a>
    </div>
</div>

<!-- Top Navigation Bar -->
<nav class="top-navbar d-flex align-items-center px-3">
    <div class="user-avatar dropdown ms-auto">
        <a href="#" class="text-decoration-none text-inherit stretched-link" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
             {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </a>
        <span class="badge-notification">1</span>
        
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3" aria-labelledby="userMenu">
            <li class="px-3 py-2 fw-bold text-dark border-bottom mb-2">{{ Auth::user()->name }}</li>
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="las la-user me-2"></i> {{ __('Profile') }}</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="las la-sign-out-alt me-2"></i> {{ __('Log Out') }}
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                document.getElementById('wrapper').classList.toggle('toggled');
            });
        }
    });
</script>
