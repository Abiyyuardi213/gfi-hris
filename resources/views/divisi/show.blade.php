<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Divisi</title>

    <link rel="icon" type="image/png" href="{{ asset('image/dropcore-icon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
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
                        <h1 class="m-0">Detail Divisi</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-eye"></i> Informasi Divisi
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('divisi.edit', $divisi->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('divisi.index') }}" class="btn btn-secondary btn-sm">
                                Kembali
                            </a>
                        </div>
                    </div>

                    <div class="card-body">

                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Kode Divisi</th>
                                <td>{{ $divisi->kode_divisi }}</td>
                            </tr>

                            <tr>
                                <th>Nama Divisi</th>
                                <td>{{ $divisi->nama_divisi }}</td>
                            </tr>

                            <tr>
                                <th>Kantor</th>
                                <td>
                                    {{ $divisi->kantor->nama_kantor ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $divisi->deskripsi ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($divisi->status)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Nonaktif</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Dibuat Pada</th>
                                <td>{{ $divisi->created_at->format('d M Y H:i') }}</td>
                            </tr>

                            <tr>
                                <th>Terakhir Diubah</th>
                                <td>{{ $divisi->updated_at->format('d M Y H:i') }}</td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('include.footerSistem')
</div>

@include('services.LogoutModal')

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>
</html>
