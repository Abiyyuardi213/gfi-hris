<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo -->
    <a href="#" class="brand-link d-flex flex-column align-items-center p-2" style="overflow: hidden;">
        <img src="{{ asset('image/hris-logo.png') }}" alt="Logo Dropcore" class="img-fluid d-none d-md-block"
            style="max-height: 40px; object-fit: contain;">
        <img src="{{ asset('image/hris-logo.png') }}" alt="Logo Mini Dropcore" class="img-fluid d-block d-md-none"
            style="max-height: 100px; object-fit: contain;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- User Info -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                @if (Auth::user()->foto)
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="img-circle elevation-2"
                        alt="User Image" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid white;">
                @else
                    <img src="{{ asset('image/default-user.png') }}" class="img-circle elevation-2" alt="User Image"
                        style="width: 45px; height: 45px; object-fit: cover; border: 2px solid white;">
                @endif
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
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" data-accordion="false"
                role="menu">
                <li class="nav-item">
                    <a href="{{ Auth::user()->role->role_name == 'Pegawai' ? route('dashboard') : route('admin.dashboard') }}"
                        class="nav-link {{ Request::routeIs('dashboard') || Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-truck-loading"></i>
                        <p>Dashboard Utama</p>
                    </a>
                </li>

                @if (in_array(strtolower(Auth::user()->role->role_name), ['super admin', 'admin']))
                    <li class="nav-item">
                        <a href="{{ route('activity-log.index') }}"
                            class="nav-link {{ request()->routeIs('activity-log.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Log Aktivitas</p>
                        </a>
                    </li>
                @endif

                @if (strtolower(Auth::user()->role->role_name) != 'pegawai')
                    @php
                        $isMaster =
                            request()->routeIs('master.dashboard') ||
                            request()->routeIs('role.*') ||
                            request()->routeIs('user.*') ||
                            request()->routeIs('kota.*');
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
                                <a href="{{ route('master.dashboard') }}"
                                    class="nav-link text-sm pl-4 {{ request()->routeIs('master.dashboard') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-warehouse"></i>
                                    <p>Dashboard Master</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('kota.index') }}"
                                    class="nav-link text-sm pl-4 {{ request()->routeIs('kota.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-map-marker-alt"></i>
                                    <p>Master Kota / Kab</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('role.index') }}"
                                    class="nav-link text-sm pl-4 {{ request()->routeIs('role.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-shield"></i>
                                    <p>Master Peran</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('user.index') }}"
                                    class="nav-link text-sm pl-4 {{ request()->routeIs('user.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p>Master Pengguna</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    @php
                        $isOffice =
                            request()->routeIs('master.office.dashboard') ||
                            request()->routeIs('assets.*') ||
                            request()->routeIs('kantor.*') ||
                            request()->routeIs('divisi.*') ||
                            request()->routeIs('jabatan.*') ||
                            request()->routeIs('status-pegawai.*') ||
                            request()->routeIs('pegawai.*') ||
                            request()->routeIs('mutasi.*') ||
                            request()->routeIs('shift-kerja.*') ||
                            request()->routeIs('hari-libur.*');
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
                                <a href="{{ route('master.office.dashboard') }}"
                                    class="nav-link text-sm pl-4 {{ request()->routeIs('master.office.dashboard') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>Dashboard Office</p>
                                </a>
                            </li>



                            <li class="nav-item">
                                <a href="{{ route('assets.index') }}"
                                    class="nav-link text-sm pl-4 {{ request()->routeIs('assets.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cubes"></i>
                                    <p>Manajemen Aset</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('kantor.index') }}"
                                    class="nav-link text-sm pl-4 {{ request()->routeIs('kantor.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-building"></i>
                                    <p>Master Kantor</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('divisi.index') }}"
                                    class="nav-link text-sm pl-4 {{ request()->routeIs('divisi.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-sitemap"></i>
                                    <p>Master Divisi</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('jabatan.index') }}"
                                    class="nav-link text-sm pl-4 {{ request()->routeIs('jabatan.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-tie"></i>
                                    <p>Master Jabatan</p>
                                </a>
                            </li>



                            <li class="nav-item">
                                <a href="{{ route('status-pegawai.index') }}"
                                    class="nav-link text-sm pl-4 {{ request()->routeIs('status-pegawai.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-id-card"></i>
                                    <p>Master Status Pegawai</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('pegawai.index') }}"
                                    class="nav-link text-sm pl-4 {{ request()->routeIs('pegawai.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-id-card"></i>
                                    <p>Master Pegawai</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('mutasi.index') }}"
                                    class="nav-link text-sm pl-4 {{ request()->routeIs('mutasi.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-exchange-alt"></i>
                                    <p>Mutasi & Promosi</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('shift-kerja.index') }}"
                                    class="nav-link text-sm pl-4 {{ request()->routeIs('shift-kerja.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-clock"></i>
                                    <p>Master Shift Kerja</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('hari-libur.index') }}"
                                    class="nav-link text-sm pl-4 {{ request()->routeIs('hari-libur.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-calendar-alt"></i>
                                    <p>Master Hari Libur</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- TRANSAKSI / ACTIVITY --}}
                <li class="nav-header">AKTIVITAS</li>

                <li class="nav-item">
                    <a href="{{ route('presensi.create') }}"
                        class="nav-link {{ request()->is('presensi/create') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-fingerprint"></i>
                        <p>Absensi Harian</p>
                    </a>
                </li>

                @if (strtolower(Auth::user()->role->role_name) != 'pegawai')
                    <li class="nav-item">
                        <a href="{{ route('presensi.index') }}"
                            class="nav-link {{ request()->is('presensi') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Data Presensi (Log)</p>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('presensi.summary') }}"
                        class="nav-link {{ request()->is('presensi/summary') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Rekap Absensi</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('pengajuan-izin.index') }}"
                        class="nav-link {{ request()->is('pengajuan-izin*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope-open-text"></i>
                        <p>Pengajuan Izin/Sakit</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('lembur.index') }}"
                        class="nav-link {{ request()->is('lembur*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>Data Lembur</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('cuti.index') }}"
                        class="nav-link {{ request()->is('cuti*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-minus"></i>
                        <p>Manajemen Cuti</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('perjalanan-dinas.index') }}"
                        class="nav-link {{ request()->is('perjalanan-dinas*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-plane"></i>
                        <p>Perjalanan Dinas</p>
                    </a>
                </li>

                @if (in_array(strtolower(Auth::user()->role->role_name), ['super admin', 'admin']))
                    <li class="nav-item">
                        <a href="{{ route('payroll.index') }}"
                            class="nav-link {{ request()->is('payroll') || request()->is('payroll/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
                            <p>Payroll / Penggajian</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('recruitment.admin.index') }}"
                            class="nav-link {{ request()->is('recruitment/candidates*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <p>Rekrutmen (Pelamar)</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('lowongan.index') }}"
                            class="nav-link {{ request()->is('lowongan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>Manajemen Lowongan</p>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('payroll.user-index') }}"
                            class="nav-link {{ request()->is('my-payroll*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>Slip Gaji Saya</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
