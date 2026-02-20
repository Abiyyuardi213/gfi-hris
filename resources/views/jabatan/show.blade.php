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

            <!-- Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Detail Jabatan</h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('jabatan.index') }}" class="btn btn-default">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Left Column: Profile-style Card -->
                        <div class="col-md-3">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <div class="profile-user-img img-fluid img-circle d-flex align-items-center justify-content-center bg-primary mb-3"
                                            style="width: 100px; height: 100px; margin: 0 auto; font-size: 40px; color: white;">
                                            <i class="fas fa-briefcase"></i>
                                        </div>
                                    </div>

                                    <h3 class="profile-username text-center">{{ $jabatan->nama_jabatan }}</h3>
                                    <p class="text-muted text-center">{{ $jabatan->kode_jabatan }}</p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Status</b>
                                            <a class="float-right">
                                                @if ($jabatan->status)
                                                    <span class="badge badge-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-danger">Nonaktif</span>
                                                @endif
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Dibuat</b> <a
                                                class="float-right">{{ $jabatan->created_at->format('d M Y') }}</a>
                                        </li>
                                    </ul>

                                    <a href="{{ route('jabatan.edit', $jabatan->id) }}"
                                        class="btn btn-primary btn-block">
                                        <b>Edit Jabatan</b>
                                    </a>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <!-- Info Box -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Metadata</h3>
                                </div>
                                <div class="card-body">
                                    <strong><i class="fas fa-calendar-alt mr-1"></i> Tgl Dibuat</strong>
                                    <p class="text-muted">{{ $jabatan->created_at->format('d M Y H:i') }}</p>
                                    <hr>
                                    <strong><i class="fas fa-edit mr-1"></i> Terakhir Diubah</strong>
                                    <p class="text-muted">{{ $jabatan->updated_at->format('d M Y H:i') }}</p>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->

                        <!-- Right Column: Details Tabs -->
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#details"
                                                data-toggle="tab">Detail Informasi</a></li>
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="details">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="text-primary"><i class="fas fa-info-circle"></i>
                                                        Informasi
                                                        Utama</h5>
                                                    <hr>
                                                </div>
                                                <div class="col-md-6">
                                                    <dl class="row">
                                                        <dt class="col-sm-4">Kode Jabatan</dt>
                                                        <dd class="col-sm-8">{{ $jabatan->kode_jabatan }}</dd>

                                                        <dt class="col-sm-4">Nama Jabatan</dt>
                                                        <dd class="col-sm-8">{{ $jabatan->nama_jabatan }}</dd>

                                                        <dt class="col-sm-4">Gaji Per Hari</dt>
                                                        <dd class="col-sm-8 text-success">
                                                            <strong>Rp
                                                                {{ number_format($jabatan->gaji_per_hari, 0, ',', '.') }}</strong>
                                                        </dd>
                                                    </dl>
                                                </div>
                                                <div class="col-md-6">
                                                    <dl class="row">
                                                        <dt class="col-sm-4">Divisi</dt>
                                                        <dd class="col-sm-8">
                                                            {{ $jabatan->divisi->nama_divisi ?? '-' }}
                                                            <br>
                                                            <small class="text-muted">Kode:
                                                                {{ $jabatan->divisi->kode_divisi ?? '-' }}</small>
                                                        </dd>

                                                        <dt class="col-sm-4">Status</dt>
                                                        <dd class="col-sm-8">
                                                            @if ($jabatan->status)
                                                                <span class="badge badge-success">Aktif</span>
                                                            @else
                                                                <span class="badge badge-danger">Nonaktif</span>
                                                            @endif
                                                        </dd>
                                                    </dl>
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="col-12">
                                                    <h5 class="text-primary"><i class="fas fa-align-left"></i> Deskripsi
                                                    </h5>
                                                    <hr>
                                                    <p class="text-muted">
                                                        {{ $jabatan->deskripsi ?? 'Tidak ada deskripsi.' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.nav-tabs-custom -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
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
