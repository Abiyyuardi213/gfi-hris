<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email - GFI HRIS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>GFI</b> HRIS</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Verifikasi Email Anda Diperlukan</p>

                @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <p class="mb-3">
                    Sebelum melanjutkan, silakan periksa email Anda untuk tautan verifikasi.
                    Jika Anda tidak menerima email,
                </p>

                <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-block">Klik di sini untuk kirim ulang</button>
                </form>

                <div class="mt-3 text-center">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link text-muted">Logout</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
