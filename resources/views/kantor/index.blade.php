<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Kantor</title>

    <link rel="icon" type="image/png" href="{{ asset('image/dropcore-icon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap"
        rel="stylesheet">

    <style>
        .toggle-status {
            width: 50px;
            height: 24px;
            appearance: none;
            background: #ddd;
            border-radius: 12px;
            position: relative;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .toggle-status:checked {
            background: linear-gradient(90deg, #28a745, #2ecc71);
        }

        .toggle-status::before {
            content: "❌";
            position: absolute;
            top: 3px;
            left: 4px;
            width: 18px;
            height: 18px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s ease;
            text-align: center;
            font-size: 12px;
            line-height: 18px;
        }

        .toggle-status:checked::before {
            content: "✔️";
            transform: translateX(26px);
            color: #28a745;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('include.navbarSistem')
        @include('include.sidebar')

        <div class="content-wrapper">
            <!-- Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Manajemen Kantor</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Daftar Kantor</h3>
                            <a href="{{ route('kantor.create') }}" class="btn btn-primary btn-sm ml-auto">
                                <i class="fas fa-plus"></i> Tambah Kantor
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="kantorTable" class="table table-bordered table-striped text-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Nama Kantor</th>
                                            <th>Tipe</th>
                                            <th>Kota</th>
                                            <th>Telp / Email</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kantors as $index => $kantor)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <span class="badge badge-secondary">
                                                        {{ $kantor->kode_kantor }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <strong>{{ $kantor->nama_kantor }}</strong><br>
                                                    <small
                                                        class="text-muted">{{ Str::limit($kantor->alamat, 30) }}</small>
                                                </td>
                                                <td>
                                                    @if ($kantor->tipe_kantor == 'Pusat')
                                                        <span class="badge badge-primary">Pusat</span>
                                                    @else
                                                        <span class="badge badge-info">Cabang</span>
                                                    @endif
                                                </td>
                                                <td>{{ $kantor->kota->kota ?? '-' }}</td>
                                                <td>
                                                    <div><i class="fas fa-phone mr-1 text-muted"></i>
                                                        {{ $kantor->no_telp ?? '-' }}</div>
                                                    <div><i class="fas fa-envelope mr-1 text-muted"></i>
                                                        {{ $kantor->email ?? '-' }}</div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="toggle-status"
                                                        data-kantor-id="{{ $kantor->id }}"
                                                        {{ $kantor->status ? 'checked' : '' }}>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('kantor.show', $kantor->id) }}"
                                                        class="btn btn-default btn-xs" title="Lihat">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('kantor.edit', $kantor->id) }}"
                                                        class="btn btn-info btn-xs" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger btn-xs delete-kantor-btn"
                                                        data-toggle="modal" data-target="#deleteKantorModal"
                                                        data-kantor-id="{{ $kantor->id }}" title="Hapus">
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

    <!-- Modal Hapus Kantor -->
    <div class="modal fade" id="deleteKantorModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus kantor ini?
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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(function() {
            $('#kantorTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true,
                autoWidth: false
            });

            $('.delete-kantor-btn').click(function() {
                let id = $(this).data('kantor-id');
                $('#deleteForm').attr('action', "{{ url('kantor') }}/" + id);
            });

            $('.toggle-status').change(function() {
                let id = $(this).data('kantor-id');

                $.post("{{ url('kantor') }}/" + id + "/toggle-status", {
                    _token: '{{ csrf_token() }}'
                }, function(res) {
                    if (res.success) {
                        $(".toast-body").text(res.message);
                        $("#toastNotification").toast({
                            delay: 3000
                        }).toast("show");
                    }
                });
            });

            @if (session('success') || session('error'))
                $('#toastNotification').toast({
                    delay: 3000
                }).toast('show');
            @endif
        });
    </script>
</body>

</html>
