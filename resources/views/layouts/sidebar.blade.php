<header class="navbar-dark-v1 shadow-sm">
    <div class="header-position">
        <span class="sidebar-toggler">
            <i class="las la-times"></i>
        </span>
        <div class="dashboard-logo d-flex justify-content-center align-items-center py-20">
            <a class="logo" href="{{ route('dashboard') }}">
                <div class="d-flex align-items-center">
                    <!-- Logo placeholder or simple icon as requested to remove iDURAR name -->
                    <div class="bg-primary rounded p-2 text-white">
                        <i class="las la-briefcase fs-3"></i>
                    </div>
                </div>
            </a>
        </div>

        <nav class="side-nav">
            <ul id="accordionSidebar" class="list-unstyled px-3">
                <li class="mb-2">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center p-2 rounded {{ request()->routeIs('dashboard') ? 'bg-light text-dark fw-bold' : 'text-muted' }} text-decoration-none">
                        <i class="las la-tachometer-alt fs-4 me-3"></i>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>
                
                <li class="mb-2">
                    <a href="{{ route('clients.index') }}" class="d-flex align-items-center p-2 rounded {{ request()->routeIs('clients.*') ? 'bg-light text-dark fw-bold' : 'text-muted' }} text-decoration-none">
                        <i class="las la-user fs-4 me-3"></i>
                        <span>{{ __('Customers') }}</span>
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('invoices.index') }}" class="d-flex align-items-center p-2 rounded {{ request()->routeIs('invoices.*') ? 'bg-light text-dark fw-bold' : 'text-muted' }} text-decoration-none">
                        <i class="las la-file-invoice-dollar fs-4 me-3"></i>
                        <span>{{ __('Invoices') }}</span>
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('offers.index') }}" class="d-flex align-items-center p-2 rounded {{ request()->routeIs('offers.*') ? 'bg-light text-dark fw-bold' : 'text-muted' }} text-decoration-none">
                        <i class="las la-file-alt fs-4 me-3"></i>
                        <span>{{ __('Quotes') }}</span>
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('payments.index') }}" class="d-flex align-items-center p-2 rounded {{ request()->routeIs('payments.*') ? 'bg-light text-dark fw-bold' : 'text-muted' }} text-decoration-none">
                        <i class="las la-credit-card fs-4 me-3"></i>
                        <span>{{ __('Payments') }}</span>
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('payment-modes.index') }}" class="d-flex align-items-center p-2 rounded {{ request()->routeIs('payment-modes.*') ? 'bg-light text-dark fw-bold' : 'text-muted' }} text-decoration-none">
                        <i class="las la-wallet fs-4 me-3"></i>
                        <span>{{ __('Payments Mode') }}</span>
                    </a>
                </li>

                {{-- <li class="mb-2">
                    <a href="#" class="d-flex align-items-center p-2 rounded text-muted text-decoration-none">
                        <i class="las la-percent fs-4 me-3"></i>
                        <span>{{ __('Taxes') }}</span>
                    </a>
                </li> --}}

                {{-- <li class="mb-2">
                    <a href="#" class="d-flex align-items-center p-2 rounded text-muted text-decoration-none">
                        <i class="las la-cog fs-4 me-3"></i>
                        <span>{{ __('Settings') }}</span>
                    </a>
                </li> --}}

                <li class="mb-2">
                    <a href="#" class="d-flex align-items-center p-2 rounded text-muted text-decoration-none">
                        <i class="las la-info-circle fs-4 me-3"></i>
                        <span>{{ __('About') }}</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
