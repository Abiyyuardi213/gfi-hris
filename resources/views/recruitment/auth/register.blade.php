<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Karir | GFI HRIS</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">

    <style>
        body {
            background-image: url('{{ asset('image/login.jpg') }}');
            /* Ensure this image exists, or use a placeholder */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
        }

        .register-box {
            width: 720px;
            /* Wider container for 2-column layout */
            margin-top: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            /* Slight transparency */
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .register-logo a {
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
            font-weight: bold;
        }

        .form-section-title {
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            margin-bottom: 15px;
            color: #007bff;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .custom-file-label::after {
            content: "Browse";
        }
    </style>
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="{{ url('/') }}"><b>GFI</b> Career & Recruitment</a>
        </div>

        <div class="card card-outline card-primary">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Isi formulir di bawah ini untuk melamar.</p>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-times-circle mr-2"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Terdapat kesalahan pengisian data:
                        <ul class="mb-0 mt-1 pl-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('recruitment.register.post') }}" method="post">
                    @csrf

                    <!-- AKUN -->
                    <div class="form-section-title"><i class="fas fa-lock mr-2"></i> Buat Akun</div>
                    <p class="text-muted"><small>Silakan buat akun terlebih dahulu. Data diri dan berkas lamaran dapat
                            dilengkapi setelah akun disetujui oleh Admin dan Anda berhasil Login.</small></p>

                    <div class="input-group mb-3">
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap"
                            value="{{ old('nama_lengkap') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email Aktif"
                            value="{{ old('email') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control"
                            placeholder="Password (Min. 8 Karakter)" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Konfirmasi Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-check-circle"></span></div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
                                <label for="agreeTerms">
                                    Saya menyetujui <a href="#">ketentuan privasi</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block"><i
                                    class="fas fa-user-plus mr-1"></i> Daftar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center">
                    <hr>
                    <a href="{{ route('login') }}" class="text-center">Saya sudah memiliki akun (Login)</a>
                </div>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
</body>

</html>
