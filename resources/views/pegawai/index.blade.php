<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Data Pegawai</title>

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
            <!-- Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Master Data Pegawai</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Daftar Pegawai</h3>
                            <a href="{{ route('pegawai.create') }}" class="btn btn-primary btn-sm ml-auto">
                                <i class="fas fa-plus"></i> Tambah Pegawai
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="pegawaiTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIP</th>
                                            <th>Nama Lengkap</th>
                                            <th>Jabatan</th>
                                            <th>Divisi</th>
                                            <th>Status</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pegawais as $index => $pegawai)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><span class="badge badge-info">{{ $pegawai->nip }}</span></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($pegawai->foto)
                                                            <img src="{{ Storage::url($pegawai->foto) }}" alt="Foto"
                                                                class="img-circle mr-2"
                                                                style="width: 30px; height: 30px; object-fit: cover">
                                                        @else
                                                            <img src="{{ asset('image/default-user.png') }}"
                                                                alt="Foto" class="img-circle mr-2"
                                                                style="width: 30px; height: 30px; object-fit: cover">
                                                        @endif
                                                        {{ $pegawai->nama_lengkap }}
                                                    </div>
                                                </td>
                                                <td>{{ $pegawai->jabatan->nama_jabatan ?? '-' }}</td>
                                                <td>{{ $pegawai->divisi->nama_divisi ?? '-' }}</td>
                                                <td>
                                                    @if ($pegawai->statusPegawai)
                                                        <span
                                                            class="badge badge-success">{{ $pegawai->statusPegawai->nama_status }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $pegawai->tanggal_masuk->format('d M Y') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('pegawai.show', $pegawai->id) }}"
                                                        class="btn btn-secondary btn-sm" title="Lihat">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('pegawai.edit', $pegawai->id) }}"
                                                        class="btn btn-info btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger btn-sm delete-btn" data-toggle="modal"
                                                        data-target="#deleteModal" data-id="{{ $pegawai->id }}">
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

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data pegawai ini?
                </div>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
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
            $('#pegawaiTable').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
                }
            });

            $('.delete-btn').click(function() {
                let id = $(this).data('id');
                let url = "{{ route('pegawai.destroy', ':id') }}";
                url = url.replace(':id', id);
                $('#deleteForm').attr('action', url);
            });
        });
    </script>
</body>

</html>
