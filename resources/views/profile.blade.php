<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Profil Pengguna</title>
    <link rel="icon" type="image/png" href="{{ asset('image/dropcore-icon.png') }}">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap"
        rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('include.navbarSistem')
        @include('include.sidebar')

        <div class="content-wrapper">
            <!-- Content Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Profil Pengguna</h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        @if ($user->foto)
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="{{ asset('storage/' . $user->foto) }}?t={{ time() }}"
                                                alt="User profile picture"
                                                style="width: 100px; height: 100px; object-fit: cover;">
                                        @else
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="{{ asset('image/default-user.png') }}" alt="User profile picture">
                                        @endif
                                    </div>

                                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                                    <p class="text-muted text-center">{{ $user->role->role_name ?? 'User' }}</p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Status Akun</b>
                                            <a class="float-right">
                                                @if ($user->status)
                                                    <span class="badge badge-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-danger">Tidak Aktif</span>
                                                @endif
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Bergabung Sejak</b> <a
                                                class="float-right">{{ $user->created_at->format('d M Y') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#settings"
                                                data-toggle="tab">Pengaturan Akun</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="settings">
                                            <form class="form-horizontal" action="{{ route('profile.update') }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="form-group row">
                                                    <label for="inputName" class="col-sm-2 col-form-label">Nama</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="name"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            id="inputName" value="{{ old('name', $user->name) }}">
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="inputEmail"
                                                        class="col-sm-2 col-form-label">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" name="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            id="inputEmail" value="{{ old('email', $user->email) }}">
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="inputPassword" class="col-sm-2 col-form-label">Password
                                                        Baru</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" name="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            id="inputPassword"
                                                            placeholder="Biarkan kosong jika tidak ingin mengganti password">
                                                        @error('password')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="inputPasswordConf"
                                                        class="col-sm-2 col-form-label">Konfirmasi Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" name="password_confirmation"
                                                            class="form-control" id="inputPasswordConf"
                                                            placeholder="Ulangi password baru">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="inputRole"
                                                        class="col-sm-2 col-form-label">Role</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="inputRole"
                                                            value="{{ $user->role->role_name ?? '-' }}" readonly>
                                                        <small class="text-muted">Role tidak dapat diubah oleh Anda
                                                            sendiri.</small>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="inputFoto" class="col-sm-2 col-form-label">Foto
                                                        Profil</label>
                                                    <div class="col-sm-10">
                                                        <input type="file" name="foto"
                                                            class="form-control-file crop-image-input">
                                                        <small class="text-muted">Format: JPG, JPEG, PNG. Max:
                                                            2MB</small>
                                                        @error('foto')
                                                            <div class="invalid-feedback d-block">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" class="btn btn-danger">Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </div>
                                            </form>
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

    @include('services.ToastModal')
    @include('services.LogoutModal')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    @include('include.cropperModal')
</body>

</html>
