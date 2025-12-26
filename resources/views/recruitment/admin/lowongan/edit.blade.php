<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRIS-GFI - Edit Lowongan</title>
    <!-- AdminLTE & CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('include.navbarSistem')
        @include('include.sidebar')

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <h1>Edit Lowongan</h1>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Edit Data Lowongan</h3>
                        </div>
                        <form action="{{ route('lowongan.update', $lowongan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Judul Posisi</label>
                                    <input type="text" name="judul" class="form-control"
                                        value="{{ old('judul', $lowongan->judul) }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tipe Pekerjaan</label>
                                            <select name="tipe_pekerjaan" class="form-control" required>
                                                <option value="Full Time"
                                                    {{ $lowongan->tipe_pekerjaan == 'Full Time' ? 'selected' : '' }}>
                                                    Full Time</option>
                                                <option value="Part Time"
                                                    {{ $lowongan->tipe_pekerjaan == 'Part Time' ? 'selected' : '' }}>
                                                    Part Time</option>
                                                <option value="Contract"
                                                    {{ $lowongan->tipe_pekerjaan == 'Contract' ? 'selected' : '' }}>
                                                    Contract</option>
                                                <option value="Internship"
                                                    {{ $lowongan->tipe_pekerjaan == 'Internship' ? 'selected' : '' }}>
                                                    Internship</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Lokasi Penempatan</label>
                                            <input type="text" name="lokasi_penempatan" class="form-control"
                                                value="{{ old('lokasi_penempatan', $lowongan->lokasi_penempatan) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Deskripsi Pekerjaan</label>
                                    <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Kualifikasi / Persyaratan</label>
                                    <textarea name="kualifikasi" class="form-control" rows="4">{{ old('kualifikasi', $lowongan->kualifikasi) }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Range Gaji (Min)</label>
                                            <input type="number" name="gaji_min" class="form-control"
                                                value="{{ old('gaji_min', $lowongan->gaji_min) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Range Gaji (Max)</label>
                                            <input type="number" name="gaji_max" class="form-control"
                                                value="{{ old('gaji_max', $lowongan->gaji_max) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Mulai Tayang</label>
                                            <input type="date" name="tanggal_mulai" class="form-control"
                                                value="{{ old('tanggal_mulai', $lowongan->tanggal_mulai ? $lowongan->tanggal_mulai->format('Y-m-d') : '') }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Batas Akhir Pendaftaran</label>
                                            <input type="date" name="tanggal_akhir" class="form-control"
                                                value="{{ old('tanggal_akhir', $lowongan->tanggal_akhir ? $lowongan->tanggal_akhir->format('Y-m-d') : '') }}"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="isActive"
                                            name="is_active" value="1"
                                            {{ $lowongan->is_active ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="isActive">Status Aktif</label>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('lowongan.index') }}" class="btn btn-default">Batal</a>
                            </div>
                        </form>
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
