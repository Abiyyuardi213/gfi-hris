<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Master Shift Kerja</title>

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

        .highlight-row {
            background-color: rgba(40, 167, 69, 0.2) !important;
            transition: background-color 2s ease;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('include.navbarSistem')
        @include('include.sidebar')

        <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <h1 class="m-0">Master Shift Kerja</h1>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Daftar Shift Kerja</h3>
                            <a href="{{ route('shift-kerja.create') }}" class="btn btn-primary btn-sm ml-auto">
                                <i class="fas fa-plus"></i> Tambah Shift
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="shiftTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Shift</th>
                                            <th>Nama Shift</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Keluar</th>
                                            <th>Status</th>
                                            <th width="150">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shifts as $index => $shift)
                                            <tr id="row-{{ $shift->id }}">

                                                <td>{{ $index + 1 }}</td>
                                                <td><strong>{{ $shift->kode_shift }}</strong></td>
                                                <td>{{ $shift->nama_shift }}</td>
                                                <td>{{ $shift->jam_masuk }}</td>
                                                <td>{{ $shift->jam_keluar }}</td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="toggle-status"
                                                        data-id="{{ $shift->id }}"
                                                        {{ $shift->status ? 'checked' : '' }}>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('shift-kerja.edit', $shift->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="confirmDelete('{{ $shift->id }}')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $shift->id }}"
                                                        action="{{ route('shift-kerja.destroy', $shift->id) }}"
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



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    @include('services.ToastModal')
    @include('services.LogoutModal')
    <script>
        $(function() {
            var table = $('#shiftTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true,
                stateSave: true
            });

            // Logika untuk highlight dan focus ke data baru/update
            @if (session('target_id'))
                var targetId = "{{ session('target_id') }}";
                var row = table.row('#row-' + targetId);

                if (row.length) {
                    var rowIdx = row.index();
                    var pageLen = table.page.len();
                    var pageIdx = Math.floor(rowIdx / pageLen);

                    table.page(pageIdx).draw(false);

                    var $rowElement = $('#row-' + targetId);
                    $rowElement.addClass('highlight-row');

                    $('html, body').animate({
                        scrollTop: $rowElement.offset().top - 100
                    }, 500);

                    setTimeout(function() {
                        $rowElement.removeClass('highlight-row');
                    }, 3000);
                }
            @endif




            $('.toggle-status').change(function() {
                let id = $(this).data('id');
                let isChecked = $(this).is(':checked');
                let checkbox = $(this);
                let url = "{{ route('shift-kerja.toggleStatus', ':id') }}";
                url = url.replace(':id', id);

                $.post(url, {
                    _token: "{{ csrf_token() }}"
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
                text: "Apakah Anda yakin ingin menghapus data shift ini? Tindakan ini tidak dapat dibatalkan.",
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
