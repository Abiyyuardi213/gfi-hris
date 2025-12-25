<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Mutasi & Promosi</title>
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
                            <h1>Mutasi & Promosi Pegawai</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Riwayat Karir Pegawai</h3>
                            <div class="card-tools">
                                <a href="{{ route('mutasi.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-exchange-alt"></i> Buat Mutasi Baru
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="mutasiTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal Efektif</th>
                                        <th>Nama Pegawai</th>
                                        <th>Jenis Perubahan</th>
                                        <th>Jabatan (Lama -> Baru)</th>
                                        <th>No SK</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riwayat as $r)
                                        <tr>
                                            <td>{{ $r->tanggal_efektif->format('d M Y') }}</td>
                                            <td>{{ $r->pegawai->nama_lengkap }}</td>
                                            <td>
                                                @if ($r->jenis_perubahan == 'Promosi')
                                                    <span class="badge badge-success">Promosi</span>
                                                @elseif($r->jenis_perubahan == 'Demosi')
                                                    <span class="badge badge-danger">Demosi</span>
                                                @else
                                                    <span class="badge badge-info">{{ $r->jenis_perubahan }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small
                                                    class="text-muted">{{ $r->jabatanAwal->nama_jabatan ?? '-' }}</small>
                                                <i class="fas fa-arrow-right mx-1 text-primary"></i>
                                                <strong>{{ $r->jabatanTujuan->nama_jabatan }}</strong>
                                            </td>
                                            <td>{{ $r->no_sk ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('mutasi.show', $r->id) }}"
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
            $('#mutasiTable').DataTable({
                "order": [
                    [0, "desc"]
                ]
            });
            @if (session('success'))
                $('#toastNotification').toast('show');
            @endif
        });
    </script>
</body>

</html>
