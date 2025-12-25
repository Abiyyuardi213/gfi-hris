<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Perjalanan Dinas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap"
        rel="stylesheet">
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
                            <h1>Perjalanan Dinas</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Pengajuan</h3>
                            <div class="card-tools">
                                <a href="{{ route('perjalanan-dinas.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Buat Pengajuan Baru
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="dinasTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No Surat</th>
                                        <th>{{ in_array($role, ['super admin', 'admin']) ? 'Dibuat Oleh' : 'Pembuat' }}
                                        </th>
                                        <th>Peserta</th>
                                        <th>Tujuan & Keperluan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perjalananDinas as $d)
                                        <tr>
                                            <td>{{ $d->no_surat_tugas ?? '-' }}</td>
                                            <td>
                                                @if ($d->pegawai)
                                                    {{ $d->pegawai->nama_lengkap }}
                                                @else
                                                    <span class="text-muted">System/Admin</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->peserta->count() > 0)
                                                    <ul class="pl-3 mb-0">
                                                        @foreach ($d->peserta->take(3) as $p)
                                                            <li>{{ $p->nama_lengkap }}</li>
                                                        @endforeach
                                                        @if ($d->peserta->count() > 3)
                                                            <li><small>+{{ $d->peserta->count() - 3 }} lainnya</small>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $d->tujuan }}</strong><br>
                                                <small>{{ Str::limit($d->keperluan, 50) }}</small>
                                            </td>
                                            <td>
                                                {{ $d->tanggal_mulai->format('d M') }} -
                                                {{ $d->tanggal_selesai->format('d M Y') }}
                                                <br>
                                                <small
                                                    class="text-muted">({{ $d->tanggal_mulai->diffInDays($d->tanggal_selesai) + 1 }}
                                                    Hari)</small>
                                            </td>
                                            <td>
                                                @if ($d->status == 'Disetujui')
                                                    <span class="badge badge-success">{{ $d->status }}</span>
                                                @elseif($d->status == 'Ditolak')
                                                    <span class="badge badge-danger">{{ $d->status }}</span>
                                                @elseif($d->status == 'Selesai')
                                                    <span class="badge badge-info">{{ $d->status }}</span>
                                                @else
                                                    <span class="badge badge-warning">{{ $d->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('perjalanan-dinas.show', $d->id) }}"
                                                    class="btn btn-info btn-xs">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @include('include.footerSistem')
        @include('services.ToastModal')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function() {
            $('#dinasTable').DataTable();
            @if (session('success'))
                $('#toastNotification').toast('show');
            @endif
        });
    </script>
</body>

</html>
