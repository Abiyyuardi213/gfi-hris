<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail User - {{ $user->name }}</title>

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
                            <h1 class="m-0">Detail User</h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('user.index') }}" class="btn btn-default">
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
                        <!-- Left Column: Profile Card -->
                        <div class="col-md-3">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        @if ($user->foto)
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="{{ asset('storage/' . $user->foto) }}" alt="User profile picture"
                                                style="width: 100px; height: 100px; object-fit: cover;">
                                        @else
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                                                alt="User profile picture">
                                        @endif
                                    </div>

                                    <h3 class="profile-username text-center">{{ $user->name }}</h3>
                                    <p class="text-muted text-center">{{ $user->role->role_name ?? 'No Role' }}</p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Status</b>
                                            <a class="float-right">
                                                @if ($user->status)
                                                    <span class="badge badge-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-danger">Nonaktif</span>
                                                @endif
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Bergabung</b> <a
                                                class="float-right">{{ $user->created_at->format('d M Y') }}</a>
                                        </li>
                                    </ul>

                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-block">
                                        <b>Edit Profil</b>
                                    </a>
                                </div>
                            </div>

                            <!-- About Me Box -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Informasi Akun</h3>
                                </div>
                                <div class="card-body">
                                    <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                                    <p class="text-muted">{{ $user->email }}</p>
                                    <hr>

                                    <strong><i class="fas fa-check-circle mr-1"></i> Verifikasi Email</strong>
                                    <p class="text-muted">
                                        {{ $user->email_verified_at ? $user->email_verified_at->format('d M Y H:i') : 'Belum Diverifikasi' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Details Tabs -->
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#activity"
                                                data-toggle="tab">Detail Data Diri</a></li>
                                        <!-- Add more tabs here later, e.g. Activity Log -->
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">

                                        <div class="active tab-pane" id="activity">
                                            @if ($user->pegawai)
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h5 class="text-primary"><i class="fas fa-id-card"></i> Data
                                                            Pegawai</h5>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <dl class="row">
                                                            <dt class="col-sm-4">NIP</dt>
                                                            <dd class="col-sm-8">{{ $user->pegawai->nip ?? '-' }}</dd>

                                                            <dt class="col-sm-4">NIK</dt>
                                                            <dd class="col-sm-8">{{ $user->pegawai->nik ?? '-' }}</dd>

                                                            <dt class="col-sm-4">Divisi</dt>
                                                            <dd class="col-sm-8">
                                                                {{ $user->pegawai->divisi->nama_divisi ?? '-' }}</dd>

                                                            <dt class="col-sm-4">Jabatan</dt>
                                                            <dd class="col-sm-8">
                                                                {{ $user->pegawai->jabatan->nama_jabatan ?? '-' }}</dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <dl class="row">
                                                            <dt class="col-sm-4">No HP</dt>
                                                            <dd class="col-sm-8">{{ $user->pegawai->no_hp ?? '-' }}
                                                            </dd>

                                                            <dt class="col-sm-4">Alamat</dt>
                                                            <dd class="col-sm-8">
                                                                {{ $user->pegawai->alamat_domisili ?? '-' }}</dd>

                                                            <dt class="col-sm-4">Tgl Masuk</dt>
                                                            <dd class="col-sm-8">
                                                                {{ $user->pegawai->tanggal_masuk ? \Carbon\Carbon::parse($user->pegawai->tanggal_masuk)->format('d M Y') : '-' }}
                                                            </dd>

                                                            <dt class="col-sm-4">Kantor</dt>
                                                            <dd class="col-sm-8">
                                                                {{ $user->pegawai->kantor->nama_kantor ?? '-' }}</dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <a href="{{ route('pegawai.edit', $user->pegawai->id) }}"
                                                        class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-user-edit"></i> Edit Data Pegawai
                                                    </a>
                                                </div>
                                            @elseif($user->kandidat)
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h5 class="text-info"><i class="fas fa-user-graduate"></i>
                                                            Data Kandidat</h5>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <dl class="row">
                                                            <dt class="col-sm-4">NIK</dt>
                                                            <dd class="col-sm-8">{{ $user->kandidat->nik ?? '-' }}
                                                            </dd>

                                                            <dt class="col-sm-4">Tempat, Tgl Lahir</dt>
                                                            <dd class="col-sm-8">
                                                                {{ $user->kandidat->tempat_lahir }},
                                                                {{ $user->kandidat->tanggal_lahir }}
                                                            </dd>

                                                            <dt class="col-sm-4">Pendidikan</dt>
                                                            <dd class="col-sm-8">
                                                                {{ $user->kandidat->pendidikan_terakhir ?? '-' }}</dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <dl class="row">
                                                            <dt class="col-sm-4">No HP</dt>
                                                            <dd class="col-sm-8">{{ $user->kandidat->no_hp ?? '-' }}
                                                            </dd>

                                                            <dt class="col-sm-4">Alamat</dt>
                                                            <dd class="col-sm-8">{{ $user->kandidat->alamat ?? '-' }}
                                                            </dd>

                                                            <dt class="col-sm-4">Status Lamaran</dt>
                                                            <dd class="col-sm-8">
                                                                <span
                                                                    class="badge badge-info">{{ $user->kandidat->status_lamaran ?? '-' }}</span>
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <a href="{{ route('recruitment.admin.show', $user->kandidat->id) }}"
                                                        class="btn btn-outline-info btn-sm">
                                                        <i class="fas fa-search"></i> Lihat Detail Lamaran
                                                    </a>
                                                </div>
                                            @else
                                                <div class="alert alert-light text-center">
                                                    <p class="mb-0 text-muted">User ini tidak terhubung dengan data
                                                        Pegawai atau Kandidat.</p>
                                                </div>
                                            @endif
                                        </div>
                                        <!-- /.tab-pane -->

                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </section>
        </div>

        @include('include.footerSistem')
    </div>

    @include('services.logoutModal')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>
