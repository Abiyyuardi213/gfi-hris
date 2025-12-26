<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="{{ route('recruitment.dashboard') }}" class="navbar-brand">
            <span class="brand-text font-weight-light"><b>GFI</b> Career</span>
        </a>
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('recruitment.dashboard') }}"
                        class="nav-link {{ request()->routeIs('recruitment.dashboard') ? 'active' : '' }}">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('recruitment.vacancy.list') }}"
                        class="nav-link {{ request()->routeIs('recruitment.vacancy.*') ? 'active' : '' }}">Lowongan
                        Kerja</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('recruitment.profile') }}"
                        class="nav-link {{ request()->routeIs('recruitment.profile') ? 'active' : '' }}">Profil Saya</a>
                </li>
            </ul>
        </div>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user"></i> {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
