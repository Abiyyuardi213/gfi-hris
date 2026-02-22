<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Status Pegawai</title>

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
                            <h1 class="m-0">Manajemen Status Pegawai</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Daftar Status Pegawai</h3>
                            <a href="{{ route('status-pegawai.create') }}" class="btn btn-primary btn-sm ml-auto">
                                <i class="fas fa-plus"></i> Tambah Status
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="statusTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Status</th>
                                            <th>Nama Status</th>
                                            <th>Keterangan</th>
                                            <th>Status Aktif</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($statuses as $index => $status)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><strong>{{ $status->kode_status }}</strong></td>
                                                <td>{{ $status->nama_status }}</td>
                                                <td>{{ $status->keterangan ?? '-' }}</td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="toggle-status"
                                                        data-id="{{ $status->id }}"
                                                        {{ $status->is_aktif ? 'checked' : '' }}>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('status-pegawai.edit', $status->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="confirmDelete('{{ $status->id }}')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $status->id }}"
                                                        action="{{ route('status-pegawai.destroy', $status->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>

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





    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    @include('services.ToastModal')
    @include('services.LogoutModal')

    <script>
        $(function() {
            $('#statusTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true
            });

            $('.toggle-status').change(function() {
                let id = $(this).data('id');
                let isChecked = $(this).is(':checked');
                let checkbox = $(this);
                let url = "{{ route('status-pegawai.toggle-status', ':id') }}";
                url = url.replace(':id', id);

                $.post(url, {
                    _token: '{{ csrf_token() }}'
                }, function(res) {
                    if (res.success) {
                        Toast.fire({
                            icon: 'success',
                            title: res.message
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: res.message
                        });
                        checkbox.prop('checked', !isChecked);
                    }
                }).fail(function() {
                    Toast.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan sistem.'
                    });
                    checkbox.prop('checked', !isChecked);
                });
            });
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus status pegawai ini? Tindakan ini tidak dapat dibatalkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>

</body>

</html>
