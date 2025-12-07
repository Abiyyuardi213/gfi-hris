<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo -->
    <a href="#" class="brand-link d-flex flex-column align-items-center p-2" style="overflow: hidden;">
        <img src="{{ asset('image/gfi-putih.png') }}"
             alt="Logo Dropcore"
             class="img-fluid d-none d-md-block"
             style="max-height: 40px; object-fit: contain;">
        <img src="{{ asset('image/gfi-putih.png') }}"
             alt="Logo Mini Dropcore"
             class="img-fluid d-block d-md-none"
             style="max-height: 100px; object-fit: contain;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- User Info -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <img src="{{ Auth::user()->profile_picture ? asset('uploads/profile/' . Auth::user()->profile_picture) : asset('image/default-user.png') }}"
                    class="img-circle elevation-2"
                    alt="User"
                    style="width: 45px; height: 45px; object-fit: cover; border: 2px solid white;">
            </div>
            <div class="info">
                <a href="#" class="d-block text-white font-weight-bold">
                    {{ Auth::user()->name }}
                </a>
                <span class="badge badge-success">Online</span>
                <span class="d-block" style="color: #f39c12; font-size: 14px; font-weight: 600;">
                    {{ Auth::user()->role->role_name ?? 'Tanpa Role' }}
                </span>
            </div>
        </div>

        <!-- Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" data-accordion="false" role="menu">
                <li class="nav-item">
                    <a href="{{ url('dashboard') }}"
                    class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-truck-loading"></i>
                        <p>Dashboard Utama</p>
                    </a>
                </li>

                @php
                    $isMaster = request()->is('dashboard-master*') ||
                                request()->is('role*') ||
                                request()->is('user*');
                @endphp

                <li class="nav-item has-treeview {{ $isMaster ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $isMaster ? 'active' : '' }} font-weight-bold">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview" style="{{ $isMaster ? 'display:block;' : '' }}">

                        <li class="nav-item">
                            <a href="{{ url('dashboard-master') }}" class="nav-link text-sm pl-4">
                                <i class="nav-icon fas fa-warehouse"></i>
                                <p>Dashboard Master</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('role') }}" class="nav-link text-sm pl-4">
                                <i class="nav-icon fas fa-user-shield"></i>
                                <p>Master Peran</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('user') }}" class="nav-link text-sm pl-4">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>Master Pengguna</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('kota.index') }}" class="nav-link text-sm pl-4">
                                <i class="nav-icon fas fa-city"></i>
                                <p>Master Kota</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @php
                    $isOffice = request()->is('dashboardOffice*') ||
                                request()->is('kantor*') ||
                                request()->is('divisi*') ||
                                request()->is('jabatan*') ||
                                request()->is('pegawai*');
                @endphp

                <li class="nav-item has-treeview {{ $isOffice ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $isOffice ? 'active' : '' }} font-weight-bold">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Master Office
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview" style="{{ $isOffice ? 'display: block;' : '' }}">

                        <li class="nav-item">
                            <a href="{{ url('dashboardOffice') }}" class="nav-link text-sm pl-4">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Dashboard Office</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('kantor') }}" class="nav-link text-sm pl-4">
                                <i class="nav-icon fas fa-building"></i>
                                <p>Master Kantor</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('divisi') }}" class="nav-link text-sm pl-4">
                                <i class="nav-icon fas fa-sitemap"></i>
                                <p>Master Divisi</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('jabatan') }}" class="nav-link text-sm pl-4">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>Master Jabatan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('pegawai') }}" class="nav-link text-sm pl-4">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>Master Pegawai</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
