<nav class="navbar navbar-top navbar-expand-lg bg-white sticky-top shadow-sm py-2 px-4">
    <div class="container-fluid">
        <span class="sidebar-toggler me-3" style="cursor: pointer;">
            <i class="las la-bars fs-4"></i>
        </span>
        
        <div class="ms-auto d-flex align-items-center gap-3">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle text-dark" data-bs-toggle="dropdown">
                    <div class="bg-warning text-dark fw-bold rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 35px; height: 35px; border: 2px solid white;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-2">
                    <li class="px-3 py-2 border-bottom">
                        <strong class="d-block">{{ Auth::user()->name }}</strong>
                        <small class="text-muted">{{ Auth::user()->email }}</small>
                    </li>
                    <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="las la-user-circle me-2"></i> {{ __('Profile') }}</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger py-2">
                                <i class="las la-sign-out-alt me-2"></i> {{ __('Sign Out') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
