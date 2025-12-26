<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Pelamar - GFI Career</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        @include('include.navbarCareer')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"> Selamat Datang, {{ Auth::user()->name }}!</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $lamarans->count() }}</h3>
                                    <p>Lamaran Saya</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Riwayat Lamaran</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Posisi</th>
                                        <th>Tanggal Melamar</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($lamarans as $index => $lamaran)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $lamaran->lowongan->judul }}</td>
                                            <td>{{ $lamaran->created_at->format('d M Y') }}</td>
                                            <td>
                                                @if ($lamaran->status == 'Pending')
                                                    <span class="badge badge-warning">Menunggu Review</span>
                                                @elseif($lamaran->status == 'Interview')
                                                    <span class="badge badge-info">Interview</span>
                                                @elseif($lamaran->status == 'Diterima')
                                                    <span class="badge badge-success">Diterima</span>
                                                @elseif($lamaran->status == 'Ditolak')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('recruitment.vacancy.show', $lamaran->lowongan_id) }}"
                                                    class="btn btn-sm btn-primary">Lihat Lowongan</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada lamaran. <a
                                                    href="{{ route('recruitment.vacancy.list') }}">Cari Lowongan</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                GFI Recruitment System
            </div>
            <strong>Copyright &copy; 2025.</strong> All rights reserved.
        </footer>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" di bawah jika Anda ingin mengakhiri sesi Anda saat ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>
