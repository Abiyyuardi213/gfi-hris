<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Divisi Jabatan</title>

    <link rel="icon" type="image/png" href="{{ asset('image/dropcore-icon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">

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
                        <h1 class="m-0">Manajemen Divisi Jabatan</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">

                    <div class="card-header d-flex align-items-center">
                        <h3 class="card-title">Daftar Divisi Jabatan</h3>
                        <a href="{{ route('divisi-jabatan.create') }}"
                           class="btn btn-primary btn-sm ml-auto">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="divisiJabatanTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kantor</th>
                                        <th>Divisi</th>
                                        <th>Jabatan</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($divisiJabatans as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->divisi->kantor->nama_kantor ?? '-' }}</td>
                                            <td>{{ $item->divisi->nama_divisi }}</td>
                                            <td>{{ $item->jabatan->nama_jabatan }}</td>
                                            <td class="text-center">
                                                <input type="checkbox"
                                                       class="toggle-status"
                                                       data-id="{{ $item->id }}"
                                                       {{ $item->status ? 'checked' : '' }}>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('divisi-jabatan.show', $item->id) }}"
                                                   class="btn btn-success btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('divisi-jabatan.edit', $item->id) }}"
                                                   class="btn btn-info btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-danger btn-sm delete-btn"
                                                        data-id="{{ $item->id }}"
                                                        data-toggle="modal"
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

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1">
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
                Data Divisi Jabatan akan dihapus permanen.
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
    $(function () {
        $('#divisiJabatanTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true
        });

        $('.delete-btn').click(function () {
            let id = $(this).data('id');
            $('#deleteForm').attr('action', "{{ url('divisi-jabatan') }}/" + id);
        });

        $('.toggle-status').change(function () {
            let id = $(this).data('id');

            $.post("{{ url('divisi-jabatan') }}/" + id + "/toggle-status", {
                _token: '{{ csrf_token() }}'
            }, function (res) {
                if (res.success) {
                    $(".toast-body").text(res.message);
                    $("#toastNotification").toast({ delay: 3000 }).toast("show");
                } else {
                    alert('Gagal mengubah status');
                }
            }).fail(function () {
                alert('Terjadi kesalahan server');
            });
        });

        @if (session('success') || session('error'))
            $('#toastNotification').toast({
                delay: 3000,
                autohide: true
            }).toast('show');
        @endif
    });
</script>

</body>
</html>
