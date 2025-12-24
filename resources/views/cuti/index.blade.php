<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Data Cuti</title>
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
                            <h1>Data Cuti Pegawai</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List Pengajuan Cuti</h3>
                            <div class="card-tools">
                                @if (strtolower(Auth::user()->role->role_name) == 'pegawai')
                                    <a href="{{ route('cuti.create') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus"></i> Ajukan Cuti
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="cutiTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Pegawai</th>
                                        <th>Jenis Cuti</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Lama</th>
                                        <th>Sisa Cuti</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cutis as $cuti)
                                        <tr>
                                            <td>{{ $cuti->pegawai->nama_lengkap }}</td>
                                            <td>{{ $cuti->jenisCuti->nama_jenis }}</td>
                                            <td>{{ $cuti->tanggal_mulai->format('d M Y') }}</td>
                                            <td>{{ $cuti->tanggal_selesai->format('d M Y') }}</td>
                                            <td>{{ $cuti->lama_hari }} Hari</td>
                                            <td>{{ $cuti->pegawai->sisa_cuti }} Hari</td>
                                            <td>{{ $cuti->keterangan }}</td>
                                            <td>
                                                @if ($cuti->status == 'Menunggu')
                                                    <span class="badge badge-warning">Menunggu</span>
                                                @elseif($cuti->status == 'Disetujui')
                                                    <span class="badge badge-success">Disetujui</span>
                                                @elseif($cuti->status == 'Ditolak')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (in_array(strtolower(Auth::user()->role->role_name), ['super admin', 'admin']))
                                                    @if ($cuti->status == 'Menunggu')
                                                        <form action="{{ route('cuti.approve', $cuti->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success"
                                                                title="Setujui"><i class="fas fa-check"></i></button>
                                                        </form>
                                                        <form action="{{ route('cuti.reject', $cuti->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                title="Tolak"><i class="fas fa-times"></i></button>
                                                        </form>
                                                    @endif
                                                @endif

                                                @if (
                                                    $cuti->status == 'Menunggu' &&
                                                        (strtolower(Auth::user()->role->role_name) == 'pegawai' ||
                                                            in_array(strtolower(Auth::user()->role->role_name), ['super admin', 'admin'])))
                                                    <form action="{{ route('cuti.destroy', $cuti->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Yakin hapus pengajuan ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-trash btn-outline-danger"><i
                                                                class="fas fa-trash"></i></button>
                                                    </form>
                                                @endif
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
            $('#cutiTable').DataTable({
                "responsive": true,
                "autoWidth": false,
            });

            @if (session('success'))
                $('#toastNotification').toast('show');
            @endif
            @if (session('error'))
                $('#toastNotification').removeClass('bg-success').addClass('bg-danger');
                $('.toast-header').removeClass('bg-success').addClass('bg-danger');
                $('#toastNotification').toast('show');
            @endif
        });
    </script>
</body>

</html>
