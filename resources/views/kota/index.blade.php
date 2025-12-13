<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dropcore - Kota</title>

    <link rel="icon" type="image/png" href="{{ asset('image/dropcore-icon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

    @include('include.navbarSistem')
    @include('include.sidebar')

    <!-- CONTENT WRAPPER -->
    <div class="content-wrapper">

        <!-- HEADER -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Manajemen Kota</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <section class="content">
            <div class="container-fluid">

                <div class="card">

                    <!-- Card Header -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Daftar Kota</h3>

                        <a href="#" class="btn btn-primary btn-sm ml-auto" data-toggle="modal" data-target="#addKotaModal">
                            <i class="fas fa-plus"></i> Tambah Kota
                        </a>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="kotaTable" class="table table-bordered table-striped">

                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kota</th>
                                    <th>Tipe</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($kotas as $index => $kota)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $kota->kota }}</td>
                                        <td>{{ $kota->tipe ?? '-' }}</td>
                                        <td class="text-center">

                                            <!-- Edit Button -->
                                            <button
                                                class="btn btn-warning btn-sm edit-kota-btn"
                                                data-toggle="modal"
                                                data-target="#editKotaModal"
                                                data-id="{{ $kota->id }}"
                                                data-kota="{{ $kota->kota }}"
                                                data-tipe="{{ $kota->tipe }}"
                                            >
                                                <i class="fas fa-edit"></i> Edit
                                            </button>

                                            <!-- Delete Button -->
                                            <button
                                                class="btn btn-danger btn-sm delete-kota-btn"
                                                data-toggle="modal"
                                                data-target="#deleteKotaModal"
                                                data-id="{{ $kota->id }}"
                                            >
                                                <i class="fas fa-trash"></i> Hapus
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


<!-- MODAL DELETE -->
<div class="modal fade" id="deleteKotaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')

            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>

                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus Kota ini?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>


<!-- MODAL ADD -->
<div class="modal fade" id="addKotaModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('kota.store') }}" method="POST">
            @csrf

            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Kota Baru</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nama Kota</label>
                        <input type="text" name="kota" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Tipe</label>
                        <select name="tipe" class="form-control">
                            <option value="">Pilih Tipe (Opsional)</option>
                            <option value="Kota">Kota</option>
                            <option value="Kabupaten">Kabupaten</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>

            </div>

        </form>
    </div>
</div>


<!-- MODAL EDIT -->
<div class="modal fade" id="editKotaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">

        <form id="editKotaForm" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content">

                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Kota</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nama Kota</label>
                        <input type="text" name="kota" id="editKota" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Tipe</label>
                        <select name="tipe" id="editTipe" class="form-control">
                            <option value="">Tidak Ada</option>
                            <option value="Kota">Kota</option>
                            <option value="Kabupaten">Kabupaten</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-warning"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>

            </div>
        </form>

    </div>
</div>


@include('services.ToastModal')
@include('services.LogoutModal')


<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
    $("#kotaTable").DataTable();

    $(document).on('click', '.delete-kota-btn', function () {
        let id = $(this).data('id');
        $('#deleteForm').attr('action', "{{ url('kota') }}/" + id);
    });

    $(document).ready(function() {
        @if (session('success') || session('error'))
            $('#toastNotification').toast({
                delay: 3000,
                autohide: true
            }).toast('show');
        @endif
    });

    $(document).on('click', '.edit-kota-btn', function () {
        let id = $(this).data('id');
        let kota = $(this).data('kota');
        let tipe = $(this).data('tipe');

        $('#editKota').val(kota);
        $('#editTipe').val(tipe);

        $('#editKotaForm').attr('action', "{{ url('kota') }}/" + id);
    });
</script>

</body>
</html>
