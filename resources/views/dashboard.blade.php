<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRIS-GFI - Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('image/dropcore-icon.png') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .small-box {
            transition: transform 0.3s;
        }

        .small-box:hover {
            transform: translateY(-5px);
        }
    </style>

    <!-- Preload Sidebar Images to reduce flickering -->
    <link rel="preload" as="image" href="{{ asset('image/hris-logo.png') }}">
    <link rel="preload" as="image" href="{{ asset('image/default-user.png') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        @include('include.navbarSistem')

        <!-- Sidebar -->
        @include('include.sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Dashboard Overview</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Stat Boxes -->
                    <div class="row">
                        <!-- Card Total Pegawai -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $totalPegawai ?? 0 }}</h3>
                                    <p>Total Pegawai</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="{{ route('pegawai.index') }}" class="small-box-footer">
                                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Card Hadir Hari Ini -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalHadirToday ?? 0 }}</h3>
                                    <p>Hadir Hari Ini</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <a href="{{ route('presensi.index') }}" class="small-box-footer">
                                    Lihat Absensi <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Card Cuti Pending -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $totalCutiPending ?? 0 }}</h3>
                                    <p>Permohonan Cuti</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <a href="{{ route('cuti.index') }}" class="small-box-footer">
                                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Card Lembur Pending -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $totalLemburPending ?? 0 }}</h3>
                                    <p>Pengajuan Lembur</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <a href="{{ route('lembur.index') }}" class="small-box-footer">
                                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- New Employee Table -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header border-transparent">
                                    <h3 class="card-title">Pegawai Terbaru Ditambahkan</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table m-0">
                                            <thead>
                                                <tr>
                                                    <th>NIP</th>
                                                    <th>Nama Lengkap</th>
                                                    <th>Jabatan</th>
                                                    <th>Bergabung</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($latestPegawais as $pegawai)
                                                    <tr>
                                                        <td><a
                                                                href="{{ route('pegawai.show', $pegawai->id) }}">{{ $pegawai->nip }}</a>
                                                        </td>
                                                        <td>{{ $pegawai->nama_lengkap }}</td>
                                                        <td>{{ $pegawai->jabatan->nama_jabatan ?? '-' }}</td>
                                                        <td>
                                                            <span
                                                                class="sparkbar text-muted">{{ $pegawai->tanggal_masuk->format('d M Y') }}</span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">Belum ada data pegawai.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer clearfix">
                                    <a href="{{ route('pegawai.create') }}"
                                        class="btn btn-sm btn-info float-left">Tambah Pegawai Baru</a>
                                    <a href="{{ route('pegawai.index') }}"
                                        class="btn btn-sm btn-secondary float-right">Lihat Semua Pegawai</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @include('include.footerSistem')
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    @include('services.ToastModal')
    @include('services.LogoutModal')

    <script>
        $(document).ready(function() {
            // Toast handled by ToastModal (SweetAlert)
        });
    </script>
</body>

</html>
