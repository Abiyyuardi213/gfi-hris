<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $lowongan->judul }} - GFI Career</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <!-- Navbar -->
        @include('include.navbarCareer')
        <!-- /.navbar -->

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"> Detail Lowongan</h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('recruitment.vacancy.list') }}" class="btn btn-default">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container">
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $lowongan->judul }}</h3>
                            <div class="card-tools">
                                <span class="badge badge-info">{{ $lowongan->tipe_pekerjaan }}</span>
                                <span class="badge badge-secondary">{{ $lowongan->lokasi_penempatan }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5>Deskripsi Pekerjaan</h5>
                            <p>{!! nl2br(e($lowongan->deskripsi)) !!}</p>

                            <h5 class="mt-4">Kualifikasi</h5>
                            <p>{!! nl2br(e($lowongan->kualifikasi)) !!}</p>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <strong>Range Gaji:</strong>
                                    @if ($lowongan->gaji_min && $lowongan->gaji_max)
                                        Rp {{ number_format($lowongan->gaji_min) }} - Rp
                                        {{ number_format($lowongan->gaji_max) }}
                                    @else
                                        <em>Dirahasiakan / Kompetitif</em>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <strong>Batas Lamaran:</strong>
                                    {{ $lowongan->tanggal_akhir ? $lowongan->tanggal_akhir->format('d M Y') : '-' }}
                                </div>
                            </div>

                            <hr>

                            @if ($hasApplied)
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i> Anda sudah melamar posisi ini.
                                </div>
                            @else
                                <form id="applyForm" action="{{ route('recruitment.vacancy.apply', $lowongan->id) }}"
                                    method="POST">
                                    @csrf
                                    <button type="button" class="btn btn-primary btn-lg btn-block shadow-sm"
                                        onclick="confirmApply()">
                                        <i class="fas fa-paper-plane mr-2"></i> Lamar Sekarang
                                    </button>
                                </form>
                                <p class="text-muted text-center mt-2"><small>Pastikan data profil dan CV Anda sudah
                                        lengkap sebelum melamar.</small></p>
                            @endif

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmApply() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pastikan profil dan CV Anda sudah uptodate sebelum melamar posisis ini.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Lamar Sekarang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Optional: Show loading state
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                    document.getElementById('applyForm').submit();
                }
            })
        }
    </script>
</body>

</html>
