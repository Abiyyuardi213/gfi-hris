<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Master Hari Libur</title>

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

            <div class="content-header">
                <div class="container-fluid">
                    <h1 class="m-0">Master Hari Libur</h1>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Daftar Hari Libur</h3>
                            <a href="{{ route('hari-libur.create') }}" class="btn btn-primary btn-sm ml-auto">
                                <i class="fas fa-plus"></i> Tambah Hari Libur
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="liburTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Libur</th>
                                            <th>Tanggal</th>
                                            <th>Jenis</th>
                                            <th>Berlaku Untuk</th>
                                            <th>Deskripsi</th>
                                            <th width="150">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hariLiburs as $index => $libur)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><strong>{{ $libur->nama_libur }}</strong></td>
                                                <td>{{ $libur->tanggal->format('d M Y') }}</td>
                                                <td>
                                                    @if ($libur->is_cuti_bersama)
                                                        <span class="badge badge-warning">Cuti Bersama</span>
                                                    @else
                                                        <span class="badge badge-success">Libur Nasional/Biasa</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($libur->kantor)
                                                        {{ $libur->kantor->nama_kantor }}
                                                    @else
                                                        <span class="font-italic text-muted">Semua Kantor</span>
                                                    @endif
                                                </td>
                                                <td>{{ $libur->deskripsi }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('hari-libur.edit', $libur->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger btn-sm delete-btn"
                                                        data-id="{{ $libur->id }}" data-toggle="modal"
                                                        data-target="#deleteModal">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
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

    <!-- Modal Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?
                </div>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('services.ToastModal')
    @include('services.LogoutModal')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(function() {
            // Show toast if success message exists (server-side session)
            @if (session('success'))
                $('.toast-body').text("{{ session('success') }}");
                $('#toastNotification').toast('show');
            @endif

            $('#liburTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true
            });

            $('.delete-btn').click(function() {
                let id = $(this).data('id');
                $('#deleteForm').attr('action', "{{ url('hari-libur') }}/" + id);
            });
        });
    </script>

</body>

</html>
