<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRIS-GFI - Tambah Lowongan</title>
    <!-- AdminLTE & CSS -->
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
                    <h1>Tambah Lowongan Baru</h1>
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

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Formulir Lowongan</h3>
                        </div>
                        <form action="{{ route('lowongan.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Judul Posisi</label>
                                    <input type="text" name="judul" class="form-control"
                                        placeholder="Contoh: Staff IT, HR Admin" value="{{ old('judul') }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tipe Pekerjaan</label>
                                            <select name="tipe_pekerjaan" class="form-control" required>
                                                <option value="Full Time">Full Time</option>
                                                <option value="Part Time">Part Time</option>
                                                <option value="Contract">Contract</option>
                                                <option value="Internship">Internship</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Lokasi Penempatan</label>
                                            <input type="text" name="lokasi_penempatan" class="form-control"
                                                placeholder="Contoh: Jakarta, Surabaya"
                                                value="{{ old('lokasi_penempatan') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Deskripsi Pekerjaan</label>
                                    <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Kualifikasi / Persyaratan</label>
                                    <textarea name="kualifikasi" class="form-control" rows="4"
                                        placeholder="- Pendidikan Min S1&#10;- Pengalaman 1 Tahun">{{ old('kualifikasi') }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Range Gaji (Min)</label>
                                            <input type="number" name="gaji_min" class="form-control"
                                                value="{{ old('gaji_min') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Range Gaji (Max)</label>
                                            <input type="number" name="gaji_max" class="form-control"
                                                value="{{ old('gaji_max') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Mulai Tayang</label>
                                            <input type="date" name="tanggal_mulai" class="form-control"
                                                value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Batas Akhir Pendaftaran</label>
                                            <input type="date" name="tanggal_akhir" class="form-control"
                                                value="{{ old('tanggal_akhir') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="isActive"
                                            name="is_active" value="1" checked>
                                        <label class="custom-control-label" for="isActive">Status Aktif (Langsung
                                            Tayang)</label>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
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
