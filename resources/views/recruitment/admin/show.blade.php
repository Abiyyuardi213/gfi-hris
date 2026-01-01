<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRIS-GFI - Detail Kandidat</title>

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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Detail Kandidat</h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('recruitment.admin.index') }}" class="btn btn-default">Kembali</a>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        @if ($kandidat->user->foto)
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="{{ asset('storage/' . $kandidat->user->foto) }}"
                                                alt="User profile picture"
                                                style="width: 100px; height: 100px; object-fit: cover;">
                                        @else
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="{{ asset('image/user_default.png') }}" alt="User profile picture"
                                                style="width: 100px; height: 100px; object-fit: cover;">
                                        @endif
                                    </div>

                                    <h3 class="profile-username text-center">{{ $kandidat->user->name }}</h3>
                                    <p class="text-muted text-center">{{ $kandidat->user->email }}</p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Status Akun</b> <a class="float-right">
                                                @if ($kandidat->user->status)
                                                    <span class="badge badge-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-warning">Menunggu</span>
                                                @endif
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Daftar Pada</b> <a
                                                class="float-right">{{ $kandidat->created_at->format('d M Y') }}</a>
                                        </li>
                                    </ul>

                                    @if (!$kandidat->user->status)
                                        <form action="{{ route('recruitment.admin.approve', $kandidat->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button onclick="return confirm('Setujui akun ini?')"
                                                class="btn btn-success btn-block"><b>Setujui Akun</b></button>
                                        </form>
                                        <form action="{{ route('recruitment.admin.reject', $kandidat->id) }}"
                                            method="POST" class="d-inline mt-2">
                                            @csrf
                                            <button onclick="return confirm('Tolak akun ini?')"
                                                class="btn btn-danger btn-block mt-2"><b>Tolak Akun</b></button>
                                        </form>
                                    @endif
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#profile"
                                                data-toggle="tab">Biodata</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#docs"
                                                data-toggle="tab">Dokumen</a></li>
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="profile">
                                            <strong><i class="fas fa-id-card mr-1"></i> NIK</strong>
                                            <p class="text-muted">{{ $kandidat->nik ?? '-' }}</p>
                                            <hr>

                                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Tempat, Tanggal
                                                Lahir</strong>
                                            <p class="text-muted">{{ $kandidat->tempat_lahir }},
                                                {{ $kandidat->tanggal_lahir ? date('d M Y', strtotime($kandidat->tanggal_lahir)) : '-' }}
                                            </p>
                                            <hr>

                                            <strong><i class="fas fa-venus-mars mr-1"></i> Jenis Kelamin</strong>
                                            <p class="text-muted">{{ $kandidat->jenis_kelamin ?? '-' }}</p>
                                            <hr>

                                            <strong><i class="fas fa-phone mr-1"></i> No. HP</strong>
                                            <p class="text-muted">{{ $kandidat->no_hp ?? '-' }}</p>
                                            <hr>

                                            <strong><i class="fas fa-home mr-1"></i> Alamat</strong>
                                            <p class="text-muted">{{ $kandidat->alamat ?? '-' }}</p>
                                            <hr>

                                            <strong><i class="fas fa-graduation-cap mr-1"></i> Pendidikan
                                                Terakhir</strong>
                                            <p class="text-muted">{{ $kandidat->pendidikan_terakhir ?? '-' }}</p>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="docs">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Dokumen</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>CV / Resume</td>
                                                        <td>
                                                            @if ($kandidat->file_cv)
                                                                <a href="{{ asset('storage/' . $kandidat->file_cv) }}"
                                                                    target="_blank" class="btn btn-sm btn-info"><i
                                                                        class="fas fa-eye"></i> Lihat</a>
                                                            @else
                                                                <span class="text-muted">Belum ada</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>KTP</td>
                                                        <td>
                                                            @if ($kandidat->file_ktp)
                                                                <a href="{{ asset('storage/' . $kandidat->file_ktp) }}"
                                                                    target="_blank" class="btn btn-sm btn-info"><i
                                                                        class="fas fa-eye"></i> Lihat</a>
                                                            @else
                                                                <span class="text-muted">Belum ada</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ijazah</td>
                                                        <td>
                                                            @if ($kandidat->file_ijazah)
                                                                <a href="{{ asset('storage/' . $kandidat->file_ijazah) }}"
                                                                    target="_blank" class="btn btn-sm btn-info"><i
                                                                        class="fas fa-eye"></i> Lihat</a>
                                                            @else
                                                                <span class="text-muted">Belum ada</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Transkrip Nilai</td>
                                                        <td>
                                                            @if ($kandidat->file_transkrip)
                                                                <a href="{{ asset('storage/' . $kandidat->file_transkrip) }}"
                                                                    target="_blank" class="btn btn-sm btn-info"><i
                                                                        class="fas fa-eye"></i> Lihat</a>
                                                            @else
                                                                <span class="text-muted">Belum ada</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>

        @include('include.footerSistem')
    </div>
    <!-- ./wrapper -->
    @include('services.LogoutModal')

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>
