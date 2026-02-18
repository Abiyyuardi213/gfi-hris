<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kantor</title>

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

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Tambah Kantor Baru</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-building"></i> Form Kantor
                            </h3>
                        </div>

                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('kantor.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <!-- LEFT COLUMN -->
                                    <div class="col-md-6">
                                        <h5 class="text-primary mb-3">Informasi Umum</h5>

                                        <div class="form-group">
                                            <label for="nama_kantor">Nama Kantor <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="nama_kantor"
                                                class="form-control @error('nama_kantor') is-invalid @enderror"
                                                value="{{ old('nama_kantor') }}" required>
                                            @error('nama_kantor')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="tipe_kantor">Tipe Kantor <span
                                                    class="text-danger">*</span></label>
                                            <select name="tipe_kantor" class="form-control" required>
                                                <option value="Cabang"
                                                    {{ old('tipe_kantor') == 'Cabang' ? 'selected' : '' }}>Cabang
                                                </option>
                                                <option value="Pusat"
                                                    {{ old('tipe_kantor') == 'Pusat' ? 'selected' : '' }}>Pusat
                                                    Headquarters</option>
                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="no_telp">No. Telepon</label>
                                                    <input type="text" name="no_telp" class="form-control"
                                                        value="{{ old('no_telp') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email Kantor</label>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ old('email') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>
                                                    Aktif</option>
                                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                                                    Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- RIGHT COLUMN -->
                                    <div class="col-md-6">
                                        <h5 class="text-primary mb-3">Lokasi & Absensi</h5>

                                        <div class="form-group">
                                            <label for="kota_id">Kota/Area</label>
                                            <select name="kota_id" class="form-control select2">
                                                <option value="">-- Pilih Kota --</option>
                                                @foreach ($kotas as $kota)
                                                    <option value="{{ $kota->id }}"
                                                        {{ old('kota_id') == $kota->id ? 'selected' : '' }}>
                                                        {{ $kota->kota }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="alamat">Alamat Lengkap</label>
                                            <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="latitude">Latitude</label>
                                                    <input type="number" step="any" name="latitude"
                                                        class="form-control" placeholder="-6.200000"
                                                        value="{{ old('latitude') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="longitude">Longitude</label>
                                                    <input type="number" step="any" name="longitude"
                                                        class="form-control" placeholder="106.816666"
                                                        value="{{ old('longitude') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="radius">Radius (Meter)</label>
                                                    <input type="number" name="radius" class="form-control"
                                                        value="{{ old('radius', 100) }}">
                                                    <small class="text-muted">Untuk batas absensi.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="text-right">
                                    <a href="{{ route('kantor.index') }}" class="btn btn-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary ml-2"><i class="fas fa-save"></i>
                                        Simpan Kantor</button>
                                </div>
                            </form>
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
