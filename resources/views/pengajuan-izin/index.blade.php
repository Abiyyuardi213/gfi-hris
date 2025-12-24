<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Data Pengajuan Izin/Sakit</title>
    <link rel="icon" type="image/png" href="{{ asset('image/dropcore-icon.png') }}">
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
                            <h1>Pengajuan Izin / Sakit</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">Pengajuan Izin</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Pengajuan</h3>
                            <a href="{{ route('pengajuan-izin.create') }}" class="btn btn-primary btn-sm float-right">
                                <i class="fas fa-plus"></i> Buat Pengajuan
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="izinTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pegawai</th>
                                            <th>Jenis</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Bukti</th>
                                            <th>Status</th>
                                            <th>Approver</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($izins as $index => $izin)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $izin->pegawai->nama_lengkap }}</td>
                                                <td>{{ $izin->jenis_izin }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d M Y') }}
                                                    s/d
                                                    {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d M Y') }}
                                                </td>
                                                <td>{{ $izin->keterangan }}</td>
                                                <td class="text-center">
                                                    @if ($izin->bukti_foto)
                                                        <a href="{{ asset('storage/' . $izin->bukti_foto) }}"
                                                            target="_blank" class="btn btn-xs btn-outline-info">
                                                            <i class="fas fa-image"></i> Lihat
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($izin->status_approval == 'Pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @elseif($izin->status_approval == 'Disetujui')
                                                        <span class="badge badge-success">Disetujui</span>
                                                    @elseif($izin->status_approval == 'Ditolak')
                                                        <span class="badge badge-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                                <td>{{ $izin->approver ? $izin->approver->name : '-' }}</td>
                                                <td>
                                                    @if (Auth::user()->role->role_name == 'Super Admin' || Auth::user()->role->role_name == 'Admin')
                                                        @if ($izin->status_approval == 'Pending')
                                                            <form
                                                                action="{{ route('pengajuan-izin.approve', $izin->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-success btn-xs"
                                                                    onclick="return confirm('Setujui pengajuan ini?')">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </form>

                                                            <button class="btn btn-danger btn-xs" data-toggle="modal"
                                                                data-target="#rejectModal{{ $izin->id }}">
                                                                <i class="fas fa-times"></i>
                                                            </button>

                                                            <!-- Modal Reject -->
                                                            <div class="modal fade"
                                                                id="rejectModal{{ $izin->id }}">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form
                                                                            action="{{ route('pengajuan-izin.reject', $izin->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <div class="modal-header bg-danger">
                                                                                <h5 class="modal-title text-white">Tolak
                                                                                    Pengajuan</h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="form-group">
                                                                                    <label>Alasan Penolakan</label>
                                                                                    <textarea name="catatan" class="form-control" required></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Batal</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-danger">Tolak</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
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
            </section>
        </div>

        @include('include.footerSistem')
    </div>

    @include('services.ToastModal')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function() {
            @if (session('success'))
                $('#toastNotification').toast('show');
                $('.toast-body').text("{{ session('success') }}");
            @endif

            $('#izinTable').DataTable();
        });
    </script>
</body>

</html>
