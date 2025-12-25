<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Detail Perjalanan Dinas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('include.navbarSistem')
        @include('include.sidebar')

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Detail Perjalanan Dinas</h1>
                        </div>
                        <div class="col-sm-6 text-right">
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <h3 class="profile-username text-center">{{ $perjalanan->no_surat_tugas ?? '-' }}
                                    </h3>
                                    <p class="text-muted text-center">{{ $perjalanan->status }}</p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Pembuat / PIC</b> <a
                                                class="float-right">{{ $perjalanan->pegawai->nama_lengkap ?? 'Admin' }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Tujuan</b> <a class="float-right">{{ $perjalanan->tujuan }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Keperluan</b>
                                            <p class="text-muted mt-2">{{ $perjalanan->keperluan }}</p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Tanggal</b> <a
                                                class="float-right">{{ $perjalanan->tanggal_mulai->format('d M Y') }} -
                                                {{ $perjalanan->tanggal_selesai->format('d M Y') }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Durasi</b> <a
                                                class="float-right">{{ $perjalanan->tanggal_mulai->diffInDays($perjalanan->tanggal_selesai) + 1 }}
                                                Hari</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Transportasi</b> <a
                                                class="float-right">{{ $perjalanan->jenis_transportasi }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Estimasi Biaya</b> <a class="float-right">Rp
                                                {{ number_format($perjalanan->estimasi_biaya, 0, ',', '.') }}</a>
                                        </li>
                                        @if ($perjalanan->realisasi_biaya)
                                            <li class="list-group-item">
                                                <b>Realisasi Biaya</b> <a class="float-right text-success">Rp
                                                    {{ number_format($perjalanan->realisasi_biaya, 0, ',', '.') }}</a>
                                            </li>
                                        @endif
                                    </ul>

                                    <h5 class="mt-4">Peserta Perjalanan Dinas</h5>
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($perjalanan->peserta as $index => $peserta)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $peserta->nama_lengkap }} ({{ $peserta->nip }})</td>
                                                    <td>{{ $peserta->jabatan->nama_jabatan ?? '-' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted">Tidak ada peserta
                                                        lain.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Approval Box (Admin Only) -->
                            @if (in_array(strtolower(Auth::user()->role->role_name), ['super admin', 'admin']) && $perjalanan->status == 'Pengajuan')
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Persetujuan</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('perjalanan-dinas.approve', $perjalanan->id) }}"
                                            method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>Catatan Admin</label>
                                                <textarea name="catatan" class="form-control" rows="2" required></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <button type="submit" name="action" value="approve"
                                                        class="btn btn-success btn-block">Setujui</button>
                                                </div>
                                                <div class="col-6">
                                                    <button type="submit" name="action" value="reject"
                                                        class="btn btn-danger btn-block">Tolak</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif

                            @if ($perjalanan->status == 'Ditolak' || $perjalanan->status == 'Disetujui')
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Status Persetujuan</h3>
                                    </div>
                                    <div class="card-body">
                                        <strong>Oleh:</strong> {{ $perjalanan->approver->nama_lengkap ?? '-' }}<br>
                                        <strong>Catatan:</strong> {{ $perjalanan->catatan_persetujuan ?? '-' }}<br>
                                        <span
                                            class="badge {{ $perjalanan->status == 'Disetujui' ? 'badge-success' : 'badge-danger' }}">{{ $perjalanan->status }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <section class="content pb-3">
                <div class="container-fluid">
                    <a href="{{ route('perjalanan-dinas.print', $perjalanan->id) }}" target="_blank"
                        class="btn btn-default btn-lg"><i class="fas fa-print"></i> Lihat Surat Tugas</a>
                </div>
            </section>
        </div>

        @include('include.footerSistem')
        @include('services.ToastModal')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script>
        $(function() {
            @if (session('success'))
                $('#toastNotification').toast('show');
            @endif
        });
    </script>
</body>

</html>
