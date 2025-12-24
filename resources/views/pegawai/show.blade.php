<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Detail Pegawai</title>
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
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Detail Pegawai</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        @if ($pegawai->foto)
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="{{ Storage::url($pegawai->foto) }}" alt="User profile picture"
                                                style="width: 100px; height: 100px; object-fit: cover;">
                                        @else
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="{{ asset('image/default-user.png') }}" alt="User profile picture">
                                        @endif
                                    </div>

                                    <h3 class="profile-username text-center">{{ $pegawai->nama_lengkap }}</h3>
                                    <p class="text-muted text-center">{{ $pegawai->jabatan->nama_jabatan ?? '-' }}</p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>NIP</b> <a class="float-right">{{ $pegawai->nip }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Divisi</b> <a
                                                class="float-right">{{ $pegawai->divisi->nama_divisi ?? '-' }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Status</b> <a
                                                class="float-right badge badge-primary">{{ $pegawai->statusPegawai->nama_status ?? '-' }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Tanggal Masuk</b> <a
                                                class="float-right">{{ $pegawai->tanggal_masuk->format('d M Y') }}</a>
                                        </li>
                                    </ul>

                                    <a href="{{ route('pegawai.edit', $pegawai->id) }}"
                                        class="btn btn-info btn-block"><b>Edit</b></a>
                                    <a href="{{ route('pegawai.index') }}"
                                        class="btn btn-default btn-block"><b>Kembali</b></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#identitas"
                                                data-toggle="tab">Identitas</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#kepegawaian"
                                                data-toggle="tab">Kepegawaian</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#lainnya"
                                                data-toggle="tab">Lainnya</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <!-- Tab Identitas -->
                                        <div class="active tab-pane" id="identitas">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong><i class="fas fa-id-card mr-1"></i> NIK (No. KTP)</strong>
                                                    <p class="text-muted">{{ $pegawai->nik }}</p>
                                                    <hr>

                                                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Tempat, Tanggal
                                                        Lahir</strong>
                                                    <p class="text-muted">{{ $pegawai->tempat_lahir }},
                                                        {{ $pegawai->tanggal_lahir->format('d F Y') }}</p>
                                                    <hr>

                                                    <strong><i class="fas fa-venus-mars mr-1"></i> Jenis
                                                        Kelamin</strong>
                                                    <p class="text-muted">
                                                        {{ $pegawai->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                    </p>
                                                    <hr>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong><i class="fas fa-pray mr-1"></i> Agama</strong>
                                                    <p class="text-muted">{{ $pegawai->agama ?? '-' }}</p>
                                                    <hr>

                                                    <strong><i class="fas fa-heart mr-1"></i> Status Pernikahan</strong>
                                                    <p class="text-muted">{{ $pegawai->status_pernikahan ?? '-' }}</p>
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong><i class="fas fa-home mr-1"></i> Alamat KTP</strong>
                                                    <p class="text-muted">{{ $pegawai->alamat_ktp ?? '-' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong><i class="fas fa-building mr-1"></i> Alamat
                                                        Domisili</strong>
                                                    <p class="text-muted">{{ $pegawai->alamat_domisili ?? '-' }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tab Kepegawaian -->
                                        <div class="tab-pane" id="kepegawaian">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong><i class="fas fa-building mr-1"></i> Kantor</strong>
                                                    <p class="text-muted">{{ $pegawai->kantor->nama_kantor ?? '-' }}
                                                    </p>
                                                    <hr>

                                                    <strong><i class="fas fa-sitemap mr-1"></i> Divisi</strong>
                                                    <p class="text-muted">{{ $pegawai->divisi->nama_divisi ?? '-' }}
                                                    </p>
                                                    <hr>

                                                    <strong><i class="fas fa-briefcase mr-1"></i> Jabatan</strong>
                                                    <p class="text-muted">{{ $pegawai->jabatan->nama_jabatan ?? '-' }}
                                                    </p>
                                                    <hr>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong><i class="fas fa-user-tag mr-1"></i> Status
                                                        Kepegawaian</strong>
                                                    <p class="text-muted">
                                                        {{ $pegawai->statusPegawai->nama_status ?? '-' }}</p>
                                                    <hr>

                                                    <strong><i class="fas fa-calendar-check mr-1"></i> Tanggal
                                                        Masuk</strong>
                                                    <p class="text-muted">
                                                        {{ $pegawai->tanggal_masuk->format('d F Y') }}
                                                        <small
                                                            class="text-muted">({{ $pegawai->tanggal_masuk->diffForHumans() }})</small>
                                                    </p>
                                                    <hr>

                                                    @if ($pegawai->tanggal_keluar)
                                                        <strong><i class="fas fa-calendar-times mr-1"></i> Tanggal
                                                            Keluar</strong>
                                                        <p class="text-muted">
                                                            {{ $pegawai->tanggal_keluar->format('d F Y') }}</p>
                                                        <hr>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tab Lainnya (Kontak dll) -->
                                        <div class="tab-pane" id="lainnya">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong><i class="fas fa-phone mr-1"></i> Nomor HP</strong>
                                                    <p class="text-muted">{{ $pegawai->no_hp ?? '-' }}</p>
                                                    <hr>

                                                    <strong><i class="fas fa-envelope mr-1"></i> Email Pribadi</strong>
                                                    <p class="text-muted">{{ $pegawai->email_pribadi ?? '-' }}</p>
                                                    <hr>
                                                </div>
                                                <div class="col-md-6">
                                                    <!-- Placeholder untuk data lain -->
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
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
