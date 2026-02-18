<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Master Office - GFI HRIS</title>
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
                            <h1 class="m-0">Office Management Overview</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">

                    <!-- Top Stats Row -->
                    <div class="row">
                        <!-- Employees -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $stats['employees'] }}</h3>
                                    <p>Total Pegawai</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="{{ route('pegawai.index') }}" class="small-box-footer">Kelola Pegawai <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- Offices -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
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

                        <!-- Assets -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $stats['assets_count'] }}</h3>
                                    <p>Total Aset</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-boxes"></i>
                                </div>
                                <a href="{{ route('assets.index') }}" class="small-box-footer">Kelola Aset <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- Asset Value -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3 style="font-size: 1.5rem">Rp
                                        {{ number_format($stats['assets_value'] / 1000000, 1) }} Jt</h3>
                                    <p>Nilai Aset (Est)</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                                <a href="{{ route('assets.index') }}" class="small-box-footer">Lihat Detail <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Secondary Stats Row -->
                    <h5 class="mb-2 mt-4">Organisasi & Shift</h5>
                    <div class="row">
                        <!-- Divisions -->
                        <div class="col-md-4 col-sm-6 col-12">
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
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="info-box shadow-sm">
                                <span class="info-box-icon bg-maroon"><i class="fas fa-briefcase"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Jabatan</span>
                                    <span class="info-box-number">{{ $stats['positions'] }} Posisi</span>
                                </div>
                                <a href="{{ route('jabatan.index') }}" class="stretched-link"></a>
                            </div>
                        </div>

                        <!-- Shifts -->
                        <div class="col-md-4 col-sm-6 col-12">
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

                    <!-- Latest Data Row -->
                    <div class="row mt-4">
                        <!-- New Employees -->
                        <div class="col-md-6">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Pegawai Terbaru</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Divisi</th>
                                                <th>Tgl Masuk</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($stats['new_employees'] as $emp)
                                                <tr>
                                                    <td>{{ $emp->nama_lengkap }}</td>
                                                    <td>{{ $emp->divisi->nama_divisi ?? '-' }}</td>
                                                    <td>{{ $emp->tanggal_masuk->format('d/m/Y') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted">Belum ada data
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer text-center">
                                    <a href="{{ route('pegawai.index') }}" class="uppercase">Lihat Semua Pegawai</a>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Assets -->
                        <div class="col-md-6">
                            <div class="card card-outline card-warning">
                                <div class="card-header">
                                    <h3 class="card-title">Aset Terbaru</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Nama Aset</th>
                                                <th>Kategori</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($stats['recent_assets'] as $asset)
                                                <tr>
                                                    <td>{{ $asset->nama_barang }}</td>
                                                    <td>{{ $asset->kategori_aset ?? '-' }}</td>
                                                    <td>Rp {{ number_format($asset->harga_perolehan, 0) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted">Belum ada data
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer text-center">
                                    <a href="{{ route('assets.index') }}" class="uppercase">Lihat Semua Aset</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @include('include.footerSistem')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>
