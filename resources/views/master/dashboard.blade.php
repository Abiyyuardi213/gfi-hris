<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Master Data - GFI HRIS</title>
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('include.navbarSistem')
        @include('include.sidebar')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Master Data Overview</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- User Specs -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $stats['users'] }}</h3>
                                    <p>Total Pengguna</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="{{ route('user.index') }}" class="small-box-footer">Kelola Pengguna <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- Roles -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $stats['roles'] }}</h3>
                                    <p>Role & Akses</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <a href="{{ route('role.index') }}" class="small-box-footer">Kelola Role <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- Offices -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $stats['offices'] }}</h3>
                                    <p>Kantor Cabang</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <a href="{{ route('kantor.index') }}" class="small-box-footer">Kelola Kantor <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- Cities -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $stats['cities'] }}</h3>
                                    <p>Kota Operasional</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-map-marked-alt"></i>
                                </div>
                                <a href="{{ route('kota.index') }}" class="small-box-footer">Kelola Kota <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <h5 class="mb-2 mt-4">Struktur Organisasi</h5>
                    <div class="row">
                        <!-- Divisions -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box shadow-sm">
                                <span class="info-box-icon bg-indigo"><i class="fas fa-sitemap"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Divisi</span>
                                    <span class="info-box-number">{{ $stats['divisions'] }} Unit</span>
                                </div>
                                <a href="{{ route('divisi.index') }}" class="stretched-link"></a>
                            </div>
                        </div>

                        <!-- Positions -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box shadow-sm">
                                <span class="info-box-icon bg-maroon"><i class="fas fa-briefcase"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Jabatan</span>
                                    <span class="info-box-number">{{ $stats['positions'] }} Posisi</span>
                                </div>
                                <a href="{{ route('jabatan.index') }}" class="stretched-link"></a>
                            </div>
                        </div>

                        <!-- Employees -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box shadow-sm">
                                <span class="info-box-icon bg-olive"><i class="fas fa-id-badge"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pegawai Aktif</span>
                                    <span class="info-box-number">{{ $stats['employees'] }} Orang</span>
                                </div>
                                <!-- Assuming route exists or fallback -->
                                <a href="{{ route('pegawai.index') }}" class="stretched-link"></a>
                            </div>
                        </div>

                        <!-- Shifts -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box shadow-sm">
                                <span class="info-box-icon bg-navy"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Shift Kerja</span>
                                    <span class="info-box-number">{{ $stats['shifts'] }} Tipe</span>
                                </div>
                                <a href="{{ route('shift-kerja.index') }}" class="stretched-link"></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @include('include.footerSistem')
    </div>

    <script src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png"></script> <!-- Placeholder if needed -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>
