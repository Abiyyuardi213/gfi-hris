<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Data Lembur</title>
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
                            <h1>Data Lembur Pegawai</h1>
                        </div>
                        <div class="col-sm-6 text-right">
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List Pengajuan Lembur</h3>
                            <div class="card-tools">
                                @if (Auth::user()->role->role_name == 'Pegawai')
                                    <a href="{{ route('lembur.create') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus"></i> Ajukan Lembur
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="lemburTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Pegawai</th>
                                        <th>Tanggal</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Durasi</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lemburs as $lembur)
                                        <tr>
                                            <td>{{ $lembur->pegawai->nama_lengkap }}</td>
                                            <td>{{ $lembur->tanggal->format('d M Y') }}</td>
                                            <td>{{ $lembur->jam_mulai ? $lembur->jam_mulai->format('H:i') : '-' }}</td>
                                            <td>{{ $lembur->jam_selesai ? $lembur->jam_selesai->format('H:i') : '-' }}
                                            </td>
                                            <td>
                                                @if ($lembur->jam_mulai && $lembur->jam_selesai)
                                                    {{ $lembur->jam_selesai->diffInHours($lembur->jam_mulai) }} Jam
                                                    {{ $lembur->jam_selesai->diffInMinutes($lembur->jam_mulai) % 60 }}
                                                    Menit
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $lembur->keterangan }}</td>
                                            <td>
                                                @if ($lembur->status == 'Menunggu')
                                                    <span class="badge badge-warning">Menunggu</span>
                                                @elseif($lembur->status == 'Disetujui')
                                                    <span class="badge badge-success">Disetujui</span>
                                                @elseif($lembur->status == 'Ditolak')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (in_array(strtolower(Auth::user()->role->role_name), ['super admin', 'admin']))
                                                    @if ($lembur->status == 'Menunggu')
                                                        <form action="{{ route('lembur.approve', $lembur->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success"
                                                                title="Setujui"><i class="fas fa-check"></i></button>
                                                        </form>
                                                        <form action="{{ route('lembur.reject', $lembur->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                title="Tolak"><i class="fas fa-times"></i></button>
                                                        </form>
                                                    @endif
                                                @endif

                                                @if (
                                                    $lembur->status == 'Menunggu' &&
                                                        (strtolower(Auth::user()->role->role_name) == 'pegawai' ||
                                                            in_array(strtolower(Auth::user()->role->role_name), ['super admin', 'admin'])))
                                                    <form action="{{ route('lembur.destroy', $lembur->id) }}"
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
            $('#lemburTable').DataTable({
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
