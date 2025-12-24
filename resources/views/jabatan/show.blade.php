<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jabatan</title>

    <link rel="icon" type="image/png" href="{{ asset('image/dropcore-icon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                    <h1 class="m-0">Detail Jabatan</h1>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-briefcase"></i> Informasi Jabatan
                            </h3>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th width="25%">Kode Jabatan</th>
                                    <td>{{ $jabatan->kode_jabatan }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Jabatan</th>
                                    <td>{{ $jabatan->nama_jabatan }}</td>
                                </tr>
                                <tr>
                                    <th>Gaji Per Hari</th>
                                    <td>Rp {{ number_format($jabatan->gaji_per_hari, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Divisi</th>
                                    <td>{{ $jabatan->divisi->nama_divisi }}</td>
                                </tr>
                                <tr>
                                    <th>Kantor</th>
                                    <td>{{ $jabatan->divisi->kantor->nama_kantor }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $jabatan->deskripsi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($jabatan->status)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>{{ $jabatan->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Terakhir Diubah</th>
                                    <td>{{ $jabatan->updated_at->format('d M Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('jabatan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <a href="{{ route('jabatan.edit', $jabatan->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Ubah
                            </a>
                        </div>
                    </div>

                </div>
            </section>
        </div>

        @include('include.footerSistem')
    </div>

    @include('services.LogoutModal')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>
