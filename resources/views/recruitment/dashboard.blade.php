<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Pelamar - GFI Career</title>
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background-color: #f4f6f9;
        }

        .content-wrapper {
            background-color: transparent;
        }

        .welcome-card {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
            position: relative;
            overflow: hidden;
        }

        .welcome-card::after {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .info-box-modern {
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
            background: white;
            border: none;
        }

        .info-box-modern:hover {
            transform: translateY(-5px);
        }

        .info-box-icon-modern {
            border-radius: 12px;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .application-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .application-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            padding: 8px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .job-title {
            font-weight: 700;
            font-size: 1.25rem;
            color: #333;
        }

        .meta-info {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .meta-info i {
            width: 20px;
            text-align: center;
            margin-right: 5px;
        }

        .action-area {
            background-color: #f8f9fa;
            padding: 15px;
            border-top: 1px solid #eee;
        }
    </style>
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        @include('include.navbarCareer')

        <div class="content-wrapper">
            <div class="content py-4">
                <div class="container">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-lg shadow-sm">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <!-- Welcome Section -->
                    <div class="welcome-card elevation-2">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1 class="font-weight-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h1>
                                <p class="mb-0" style="opacity: 0.9;">Selamat datang kembali di portal karir. Pantau
                                    status lamaranmu dan jangan lewatkan kesempatan jadwal interview.</p>
                            </div>
                            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                <a href="{{ route('recruitment.vacancy.list') }}"
                                    class="btn btn-light text-primary font-weight-bold shadow-sm px-4 py-2 rounded-pill">
                                    <i class="fas fa-search mr-2"></i> Cari Lowongan Baru
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Row -->
                    <div class="row mb-4">
                        <div class="col-md-4 col-sm-6">
                            <div class="info-box info-box-modern p-3">
                                <span class="info-box-icon-modern bg-gradient-primary text-white elevation-1">
                                    <i class="fas fa-file-alt"></i>
                                </span>
                                <div class="info-box-content ml-3">
                                    <span class="text-muted text-uppercase font-weight-bold"
                                        style="font-size: 0.8rem;">Total Lamaran</span>
                                    <span class="info-box-number text-dark"
                                        style="font-size: 1.8rem;">{{ $lamarans->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="info-box info-box-modern p-3">
                                <span class="info-box-icon-modern bg-gradient-info text-white elevation-1">
                                    <i class="fas fa-calendar-check"></i>
                                </span>
                                <div class="info-box-content ml-3">
                                    <span class="text-muted text-uppercase font-weight-bold"
                                        style="font-size: 0.8rem;">Jadwal Interview</span>
                                    <span class="info-box-number text-dark" style="font-size: 1.8rem;">
                                        {{ $lamarans->where('status', 'Interview')->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="info-box info-box-modern p-3">
                                <span class="info-box-icon-modern bg-gradient-warning text-white elevation-1">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <div class="info-box-content ml-3">
                                    <span class="text-muted text-uppercase font-weight-bold"
                                        style="font-size: 0.8rem;">Menunggu Review</span>
                                    <span class="info-box-number text-dark" style="font-size: 1.8rem;">
                                        {{ $lamarans->whereIn('status', ['Pending', 'Review'])->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Applications List -->
                    <h5 class="mb-3 font-weight-bold text-dark"><i class="fas fa-history mr-2 text-primary"></i> Riwayat
                        Lamaran Terbaru</h5>

                    <div class="row">
                        @forelse($lamarans as $lamaran)
                            <div class="col-md-6 col-lg-4">
                                <div class="card application-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <span class="text-muted small">ID:
                                                    #{{ substr($lamaran->id, 0, 8) }}</span>
                                            </div>
                                            <div class="text-right">
                                                @if ($lamaran->status == 'Pending')
                                                    <span class="status-badge bg-warning text-dark"><i
                                                            class="fas fa-hourglass-half"></i> Menunggu Review</span>
                                                @elseif($lamaran->status == 'Review')
                                                    <span class="status-badge bg-info"><i class="fas fa-search"></i>
                                                        Sedang Direview</span>
                                                @elseif($lamaran->status == 'Interview')
                                                    <span class="status-badge bg-primary"><i
                                                            class="fas fa-comments"></i> Interview</span>
                                                @elseif($lamaran->status == 'Diterima')
                                                    <span class="status-badge bg-success"><i
                                                            class="fas fa-check-circle"></i> Diterima</span>
                                                @elseif($lamaran->status == 'Ditolak')
                                                    <span class="status-badge bg-danger"><i
                                                            class="fas fa-times-circle"></i> Ditolak</span>
                                                @else
                                                    <span
                                                        class="status-badge bg-secondary">{{ $lamaran->status }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <h5 class="job-title mb-2">{{ $lamaran->lowongan->judul }}</h5>

                                        <div class="meta-info">
                                            <div class="mb-1"><i class="fas fa-briefcase text-muted"></i>
                                                {{ $lamaran->lowongan->tipe_pekerjaan }}</div>
                                            <div class="mb-1"><i class="fas fa-map-marker-alt text-muted"></i>
                                                {{ $lamaran->lowongan->lokasi_penempatan ?? 'Lokasi tidak tersedia' }}
                                            </div>
                                            <div><i class="fas fa-calendar-day text-muted"></i> Dilamar pada:
                                                {{ $lamaran->created_at->format('d M Y') }}</div>
                                        </div>

                                        @if ($lamaran->status == 'Interview' && $lamaran->wawancaras->count() > 0)
                                            <div
                                                class="alert alert-light border border-primary text-primary text-sm mt-3 p-2 rounded">
                                                <i class="fas fa-info-circle mr-1"></i> Cek jadwal interview Anda!
                                            </div>
                                        @endif
                                    </div>
                                    <div class="action-area d-flex justify-content-between align-items-center">
                                        <a href="{{ route('recruitment.application.detail', $lamaran->id) }}"
                                            class="btn btn-info btn-sm rounded-pill px-3">
                                            <i class="fas fa-eye mr-1"></i> Detail & Tracking
                                        </a>
                                        <a href="{{ route('recruitment.vacancy.show', $lamaran->lowongan_id) }}"
                                            class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                            Lihat Lowongan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5 bg-white rounded shadow-sm">
                                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png"
                                        alt="Empty" style="max-height: 200px; opacity: 0.7;">
                                    <h4 class="mt-3 text-muted">Belum ada lamaran aktif</h4>
                                    <p class="text-muted">Ayo mulai karirmu dengan melamar pekerjaan yang tersedia.</p>
                                    <a href="{{ route('recruitment.vacancy.list') }}"
                                        class="btn btn-primary btn-lg mt-2 rounded-pill px-4">
                                        Cari Pekerjaan Sekarang
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>

        <footer class="main-footer bg-white text-center border-top-0 pt-4 pb-4">
            <div class="container">
                <strong>Copyright &copy; 2025 <a href="#">GFI Recruitment System</a>.</strong> All rights
                reserved.
                <div class="text-muted small mt-2">
                    Dibuat dengan <i class="fas fa-heart text-danger"></i> untuk Karir Anda
                </div>
            </div>
        </footer>
    </div>

    <!-- Login/Logout Modal if needed is handled by navbar usually or include -->
    @include('services.LogoutModal')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>
