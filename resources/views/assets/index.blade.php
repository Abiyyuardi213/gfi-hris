<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Manajemen Aset</title>
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
                            <h1>Manajemen Aset & Inventaris</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Aset Kantor</h3>
                            <div class="card-tools">
                                <a href="{{ route('assets.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Tambah Aset Baru
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="assetsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode Aset</th>
                                        <th>Nama Aset</th>
                                        <th>Kategori</th>
                                        <th>Kondisi</th>
                                        <th>Status</th>
                                        <th>Pemegang (User)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assets as $asset)
                                        <tr>
                                            <td>{{ $asset->kode_aset }}</td>
                                            <td>
                                                <strong>{{ $asset->nama_aset }}</strong><br>
                                                <small class="text-muted">{{ $asset->merk_model }}</small>
                                            </td>
                                            <td>{{ $asset->kategori }}</td>
                                            <td>
                                                @if ($asset->kondisi == 'Baik')
                                                    <span class="badge badge-success">Baik</span>
                                                @elseif($asset->kondisi == 'Rusak Ringan')
                                                    <span class="badge badge-warning">Rusak Ringan</span>
                                                @else
                                                    <span class="badge badge-danger">{{ $asset->kondisi }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $asset->status }}</td>
                                            <td>{{ $asset->pegawai->nama_lengkap ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('assets.show', $asset->id) }}"
                                                    class="btn btn-info btn-xs">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('assets.edit', $asset->id) }}"
                                                    class="btn btn-warning btn-xs">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-xs"
                                                    onclick="confirmDelete('{{ $asset->id }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <form id="delete-form-{{ $asset->id }}"
                                                    action="{{ route('assets.destroy', $asset->id) }}" method="POST"
                                                    style="display: none;">
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
            </section>
        </div>

        @include('include.footerSistem')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

        @include('services.ToastModal')

        <script>
            $(function() {
                $('#assetsTable').DataTable();
            });

            function confirmDelete(id) {
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: "Apakah Anda yakin ingin menghapus aset ini? Tindakan ini tidak dapat dibatalkan.",
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
