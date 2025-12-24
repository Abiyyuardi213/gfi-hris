<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai - GFI HRIS</title>
    <link rel="icon" type="image/png" href="{{ asset('image/dropcore-icon.png') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .small-box .icon {
            color: rgba(0, 0, 0, 0.15);
            z-index: 0;
        }

        .bg-gradient-primary {
            background: linear-gradient(45deg, #007bff, #3395ff);
        }

        .bg-gradient-success {
            background: linear-gradient(45deg, #28a745, #5dd879);
        }

        .bg-gradient-info {
            background: linear-gradient(45deg, #17a2b8, #5bc0de);
        }
    </style>
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
                            <h1 class="m-0">Selamat Datang, {{ explode(' ', $pegawai->nama_lengkap)[0] }}!</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">

                    <!-- Info Shift Hari Ini -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-calendar-day mr-2"></i> Shift Hari Ini:
                                        <strong>{{ \Carbon\Carbon::now()->format('d M Y') }}</strong>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <h5>Jam Masuk</h5>
                                            <h3 class="text-primary font-weight-bold">
                                                {{ $pegawai->shiftKerja ? \Carbon\Carbon::parse($pegawai->shiftKerja->jam_masuk)->format('H:i') : '-' }}
                                            </h3>
                                        </div>
                                        <div class="col-md-4 text-center border-left border-right">
                                            <h5>Shift</h5>
                                            <h3 class="text-info font-weight-bold">
                                                {{ $pegawai->shiftKerja->nama_shift ?? 'Jadwal Libur/Umum' }}</h3>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <h5>Jam Pulang</h5>
                                            <h3 class="text-primary font-weight-bold">
                                                {{ $pegawai->shiftKerja ? \Carbon\Carbon::parse($pegawai->shiftKerja->jam_keluar)->format('H:i') : '-' }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Absensi -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3>Status Kehadiran</h3>

                                    @if ($presensi)
                                        @if ($presensi->jam_masuk && !$presensi->jam_pulang)
                                            <div class="alert alert-info">
                                                <i class="fas fa-check-circle"></i> Anda sudah <strong>Absen
                                                    Masuk</strong> pukul
                                                {{ \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') }}
                                            </div>
                                            <a href="{{ route('presensi.create') }}"
                                                class="btn btn-danger btn-lg btn-block">
                                                <i class="fas fa-sign-out-alt"></i> Lakukan Absen Pulang
                                            </a>
                                        @elseif($presensi->jam_masuk && $presensi->jam_pulang)
                                            <div class="alert alert-success">
                                                <i class="fas fa-check-double"></i> Absensi hari ini
                                                <strong>Selesai</strong>.
                                            </div>
                                            <button class="btn btn-secondary btn-lg btn-block" disabled>Sudah
                                                Pulang</button>
                                        @else
                                            <!-- Case: Status not Present (e.g., Izin/Sakit pre-filled) -->
                                            <div class="alert alert-warning">
                                                Status: <strong>{{ $presensi->status }}</strong>
                                            </div>
                                        @endif
                                    @else
                                        <div class="alert alert-secondary">
                                            Anda belum melakukan absen hari ini.
                                        </div>
                                        <a href="{{ route('presensi.create') }}"
                                            class="btn btn-primary btn-lg btn-block">
                                            <i class="fas fa-sign-in-alt"></i> Lakukan Absen Masuk
                                        </a>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h3 class="card-title">Ringkasan Bulan Ini</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 text-center">
                                            <input type="text" class="knob" value="{{ $stats['hadir'] }}"
                                                data-width="90" data-height="90" data-fgColor="#28a745"
                                                data-readonly="true">
                                            <div class="knob-label">Hadir</div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <input type="text" class="knob" value="{{ $stats['terlambat'] }}"
                                                data-width="90" data-height="90" data-fgColor="#dc3545"
                                                data-readonly="true">
                                            <div class="knob-label">Terlambat</div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <input type="text" class="knob" value="{{ $stats['izin'] }}"
                                                data-width="90" data-height="90" data-fgColor="#17a2b8"
                                                data-readonly="true">
                                            <div class="knob-label">Izin/Sakit</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Log Aktivitas Terakhir -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Log Aktivitas Terakhir</h3>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Masuk</th>
                                                <th>Pulang</th>
                                                <th>Status</th>
                                                <th>Validasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($logs as $log)
                                                <tr>
                                                    <td>{{ $log->tanggal->format('d M Y') }}</td>
                                                    <td>{{ $log->jam_masuk ? $log->jam_masuk->format('H:i') : '-' }}
                                                    </td>
                                                    <td>{{ $log->jam_pulang ? $log->jam_pulang->format('H:i') : '-' }}
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge badge-{{ $log->status == 'Hadir' ? 'success' : ($log->status == 'Alpa' ? 'danger' : 'warning') }}">
                                                            {{ $log->status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if ($log->terlambat > 0)
                                                            <small class="text-danger"><i
                                                                    class="fas fa-exclamation-circle"></i> Terlambat
                                                                {{ $log->terlambat }} m</small>
                                                        @elseif($log->pulang_cepat > 0)
                                                            <small class="text-warning"><i
                                                                    class="fas fa-exclamation-triangle"></i> Pulang
                                                                Cepat</small>
                                                        @elseif($log->status == 'Hadir')
                                                            <small class="text-success"><i class="fas fa-check"></i>
                                                                Valid</small>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>

        @include('include.footerSistem')
    </div>

    @include('services.ToastModal')
    @include('services.LogoutModal')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js"></script>
    <script>
        $(function() {
            $('.knob').knob({
                'format': function(value) {
                    return value;
                }
            });
        });
    </script>
</body>

</html>
