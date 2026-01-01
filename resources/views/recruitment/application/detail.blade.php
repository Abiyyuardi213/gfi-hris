<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Lamaran - GFI Career</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        @include('include.navbarCareer')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"> Detail Lamaran</h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('recruitment.dashboard') }}" class="btn btn-default">Kembali ke
                                Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container">

                    <!-- Status Banner -->
                    <div class="callout {{ $lamaran->status == 'Interview' ? 'callout-info' : 'callout-warning' }}">
                        <h5>Status Lamaran: <strong>{{ $lamaran->status }}</strong></h5>
                        <p>
                            @if ($lamaran->status == 'Pending')
                                Lamaran Anda telah diterima dan sedang menunggu review oleh tim HRD.
                            @elseif($lamaran->status == 'Review')
                                Lamaran Anda sedang dipelajari lebih lanjut.
                            @elseif($lamaran->status == 'Interview')
                                Selamat! Anda dijadwalkan untuk proses interview. Mohon cek jadwal di bawah ini.
                            @elseif($lamaran->status == 'Diterima')
                                Selamat! Anda diterima. Tim HRD akan menghubungi Anda untuk proses selanjutnya.
                            @elseif($lamaran->status == 'Ditolak')
                                Mohon maaf, Anda belum loloas tahap seleksi kali ini. Tetap semangat!
                            @endif
                        </p>
                    </div>

                    <!-- Interview Schedule -->
                    @if ($lamaran->wawancaras->count() > 0)
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-calendar-alt mr-1"></i> Jadwal Interview</h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tanggal & Waktu</th>
                                            <th>Tipe</th>
                                            <th>Lokasi / Link</th>
                                            <th>Catatan</th>
                                            <th>Status Jadwal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lamaran->wawancaras as $w)
                                            <tr>
                                                <td>{{ $w->tanggal_waktu->format('d M Y, H:i') }} WIB</td>
                                                <td>
                                                    @if ($w->tipe == 'Online')
                                                        <span class="badge badge-primary">Online</span>
                                                    @else
                                                        <span class="badge badge-success">Offline (Tatap Muka)</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($w->tipe == 'Online')
                                                        <a href="{{ $w->lokasi_link }}" target="_blank">Link
                                                            Meeting</a>
                                                    @else
                                                        {{ $w->lokasi_link }}
                                                    @endif
                                                </td>
                                                <td>{{ $w->catatan ?? '-' }}</td>
                                                <td>
                                                    @if ($w->status == 'Terjadwal')
                                                        <small class="badge badge-warning">Terjadwal</small>
                                                    @elseif($w->status == 'Selesai')
                                                        <small class="badge badge-success">Selesai</small>
                                                    @else
                                                        <small class="badge badge-secondary">{{ $w->status }}</small>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Informasi Posisi -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Posisi yang Dilamar</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Judul Posisi</strong>
                                    <p>{{ $lamaran->lowongan->judul }}</p>
                                    <strong>Tipe Pekerjaan</strong>
                                    <p>{{ $lamaran->lowongan->tipe_pekerjaan }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>Lokasi</strong>
                                    <p>{{ $lamaran->lowongan->lokasi_penempatan }}</p>
                                    <strong>Rentang Gaji</strong>
                                    <p>Rp {{ number_format($lamaran->lowongan->gaji_min) }} - Rp
                                        {{ number_format($lamaran->lowongan->gaji_max) }}</p>
                                </div>
                            </div>
                            <hr>
                            <strong>Deskripsi Pekerjaan</strong>
                            <p>{!! nl2br(e($lamaran->lowongan->deskripsi)) !!}</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Dilamar pada:
                                {{ $lamaran->created_at->format('d M Y H:i') }}</small>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                GFI Recruitment System
            </div>
            <strong>Copyright &copy; 2025.</strong> All rights reserved.
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>
