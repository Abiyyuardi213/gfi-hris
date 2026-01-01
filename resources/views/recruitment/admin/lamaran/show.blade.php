<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRIS-GFI - Proses Lamaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('include.navbarSistem')
        @include('include.sidebar')

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Proses Lamaran</h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('lowongan.show', $lamaran->lowongan_id) }}"
                                class="btn btn-default">Kembali</a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Info Kandidat & Posisi -->
                        <div class="col-md-5">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <h3 class="profile-username text-center">{{ $lamaran->kandidat->user->name }}
                                    </h3>
                                    <p class="text-muted text-center">Melamar sebagai:
                                        <strong>{{ $lamaran->lowongan->judul }}</strong>
                                    </p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Status Saat Ini</b> <a class="float-right">
                                                <span class="badge badge-lg badge-info">{{ $lamaran->status }}</span>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Tanggal Melamar</b> <a
                                                class="float-right">{{ $lamaran->created_at->format('d M Y') }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>NIK</b> <a class="float-right">{{ $lamaran->kandidat->nik }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>No HP</b> <a class="float-right">{{ $lamaran->kandidat->no_hp }}</a>
                                        </li>
                                    </ul>

                                    <a href="{{ route('recruitment.admin.show', $lamaran->kandidat->id) }}"
                                        target="_blank" class="btn btn-secondary btn-block"><b>Lihat Profil
                                            Lengkap</b></a>
                                </div>
                            </div>

                            <!-- Riwayat Status / Timeline (Simple) -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Catatan Admin</h3>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">{{ $lamaran->catatan_admin ?? 'Belum ada catatan.' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Panel -->
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#status"
                                                data-toggle="tab">Ubah Status</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#interview"
                                                data-toggle="tab">Jadwalkan Interview</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">

                                        <!-- Tab Ubah Status -->
                                        <div class="active tab-pane" id="status">
                                            <form
                                                action="{{ route('recruitment.application.updateStatus', $lamaran->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Update Status Lamaran</label>
                                                    <select name="status" class="form-control">
                                                        <option value="Pending"
                                                            {{ $lamaran->status == 'Pending' ? 'selected' : '' }}>
                                                            Pending</option>
                                                        <option value="Review"
                                                            {{ $lamaran->status == 'Review' ? 'selected' : '' }}>
                                                            Review (Sedang Diperiksa)</option>
                                                        <option value="Diterima"
                                                            {{ $lamaran->status == 'Diterima' ? 'selected' : '' }}>
                                                            Diterima (Lolos)</option>
                                                        <option value="Ditolak"
                                                            {{ $lamaran->status == 'Ditolak' ? 'selected' : '' }}>
                                                            Ditolak</option>
                                                        <!-- Interview is set automatically via schedule tab mainly, but allowed here too -->
                                                        <option value="Interview"
                                                            {{ $lamaran->status == 'Interview' ? 'selected' : '' }}>
                                                            Interview</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Catatan (Internal)</label>
                                                    <textarea name="catatan_admin" class="form-control" rows="3" placeholder="Tambahkan catatan untuk admin lain...">{{ $lamaran->catatan_admin }}</textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </form>
                                        </div>

                                        <!-- Tab Schedule Interview -->
                                        <div class="tab-pane" id="interview">
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle"></i> Menjadwalkan interview akan otomatis
                                                mengubah status lamaran menjadi <strong>Interview</strong>.
                                            </div>

                                            <form
                                                action="{{ route('recruitment.application.schedule', $lamaran->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Tanggal & Waktu</label>
                                                    <input type="datetime-local" name="tanggal_waktu"
                                                        class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label>Tipe Interview</label>
                                                            <select name="tipe" class="form-control" required>
                                                                <option value="Online">Online (Zoom/Meet)</option>
                                                                <option value="Offline">Offline (Di Kantor)</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <label>Lokasi / Link Meeting</label>
                                                            <input type="text" name="lokasi_link"
                                                                class="form-control"
                                                                placeholder="URL Zoom atau Ruang Rapat" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Catatan untuk Kandidat (Opsional)</label>
                                                    <textarea name="catatan" class="form-control" rows="2" placeholder="Misal: Harap membawa CV cetak..."></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-success"><i
                                                        class="fas fa-calendar-plus mr-1"></i> Jadwalkan
                                                    Interview</button>
                                            </form>

                                            <hr>
                                            <h5>Riwayat Jadwal Interview</h5>
                                            <table class="table table-sm table-bordered mt-2">
                                                <thead>
                                                    <tr>
                                                        <th>Tgl</th>
                                                        <th>Tipe</th>
                                                        <th>Lokasi/Link</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($lamaran->wawancaras as $w)
                                                        <tr>
                                                            <td>{{ $w->tanggal_waktu->format('d M Y H:i') }}</td>
                                                            <td>{{ $w->tipe }}</td>
                                                            <td>{{ $w->lokasi_link }}</td>
                                                            <td>
                                                                @if ($w->status == 'Terjadwal')
                                                                    <span
                                                                        class="badge badge-warning">{{ $w->status }}</span>
                                                                @elseif($w->status == 'Selesai')
                                                                    <span
                                                                        class="badge badge-success">{{ $w->status }}</span>
                                                                @else
                                                                    <span
                                                                        class="badge badge-danger">{{ $w->status }}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center text-muted">Belum
                                                                ada
                                                                jadwal.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
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
