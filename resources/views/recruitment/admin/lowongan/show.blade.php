<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRIS-GFI - Detail Lowongan & Pelamar</title>
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
                            <h1>Detail Lowongan</h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('lowongan.index') }}" class="btn btn-default">Kembali</a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">

                    <!-- Info Lowongan -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">{{ $lowongan->judul }}</h3>
                            <div class="card-tools">
                                <span class="badge badge-info">{{ $lowongan->tipe_pekerjaan }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Lokasi</strong>
                                    <p class="text-muted">{{ $lowongan->lokasi_penempatan }}</p>

                                    <strong><i class="fas fa-money-bill mr-1"></i> Range Gaji</strong>
                                    <p class="text-muted">
                                        Rp {{ number_format($lowongan->gaji_min) }} - Rp
                                        {{ number_format($lowongan->gaji_max) }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <strong><i class="fas fa-calendar mr-1"></i> Periode Tayang</strong>
                                    <p class="text-muted">
                                        {{ $lowongan->tanggal_mulai->format('d M Y') }} -
                                        {{ $lowongan->tanggal_akhir->format('d M Y') }}
                                    </p>

                                    <strong><i class="fas fa-users mr-1"></i> Total Pelamar</strong>
                                    <p class="text-muted">{{ $lowongan->lamarans->count() }} Orang</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Pelamar -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Pelamar untuk Posisi Ini</h3>
                        </div>
                        <div class="card-body">
                            <table id="tablePelamar" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Melamar</th>
                                        <th>Nama Pelamar</th>
                                        <th>Pendidikan</th>
                                        <th>Status Lamaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lowongan->lamarans as $index => $lamaran)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $lamaran->created_at->format('d M Y H:i') }}</td>
                                            <td>{{ $lamaran->kandidat->user->name ?? 'User Deleted' }}</td>
                                            <td>{{ $lamaran->kandidat->pendidikan_terakhir }}</td>
                                            <td>
                                                <span class="badge badge-primary">{{ $lamaran->status }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('recruitment.admin.show', $lamaran->kandidat->id) }}"
                                                    class="btn btn-info btn-sm" target="_blank" title="Lihat Profil">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('recruitment.application.show', $lamaran->id) }}"
                                                    class="btn btn-warning btn-sm" title="Proses Lamaran">
                                                    <i class="fas fa-cog"></i> Proses
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
    </div>
    @include('services.LogoutModal')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function() {
            $("#tablePelamar").DataTable({
                "responsive": true,
                "autoWidth": false
            });
        });
    </script>
</body>

</html>
