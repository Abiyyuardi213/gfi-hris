<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Kantor</title>

    <link rel="icon" type="image/png" href="{{ asset('image/dropcore-icon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css"
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
                            <h1 class="m-0">Ubah Data Kantor</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit"></i> Edit Kantor
                            </h3>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('kantor.update', $kantor->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <!-- LEFT COLUMN -->
                                    <div class="col-md-6">
                                        <h5 class="text-primary mb-3">Informasi Umum</h5>

                                        <div class="form-group">
                                            <label for="nama_kantor">Nama Kantor <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="nama_kantor"
                                                class="form-control @error('nama_kantor') is-invalid @enderror"
                                                value="{{ old('nama_kantor', $kantor->nama_kantor) }}" required>
                                            @error('nama_kantor')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="tipe_kantor">Tipe Kantor <span
                                                    class="text-danger">*</span></label>
                                            <select name="tipe_kantor" class="form-control" required>
                                                <option value="Cabang"
                                                    {{ old('tipe_kantor', $kantor->tipe_kantor) == 'Cabang' ? 'selected' : '' }}>
                                                    Cabang</option>
                                                <option value="Pusat"
                                                    {{ old('tipe_kantor', $kantor->tipe_kantor) == 'Pusat' ? 'selected' : '' }}>
                                                    Pusat Headquarters</option>
                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="no_telp">No. Telepon</label>
                                                    <input type="text" name="no_telp" class="form-control"
                                                        value="{{ old('no_telp', $kantor->no_telp) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email Kantor</label>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ old('email', $kantor->email) }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="1"
                                                    {{ old('status', $kantor->status) == 1 ? 'selected' : '' }}>Aktif
                                                </option>
                                                <option value="0"
                                                    {{ old('status', $kantor->status) == 0 ? 'selected' : '' }}>Nonaktif
                                                </option>
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
                                                        {{ old('kota_id', $kantor->kota_id) == $kota->id ? 'selected' : '' }}>
                                                        {{ $kota->kota }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="alamat">Alamat Lengkap</label>
                                            <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $kantor->alamat) }}</textarea>
                                        </div>


                                    </div>
                                </div>

                                <hr>
                                <div class="text-right">
                                    <a href="{{ route('kantor.index') }}" class="btn btn-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary ml-2"><i class="fas fa-save"></i>
                                        Simpan Perubahan</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: "-- Pilih Kota --",
                allowClear: true
            });
        });
    </script>
</body>

</html>
