<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Tambah Hari Libur</title>
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
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Tambah Hari Libur</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Form Tambah Hari Libur</h3>
                                </div>

                                <form action="{{ route('hari-libur.store') }}" method="POST">
                                    @csrf
                                    <div class="card-body">

                                        {{-- Nama Libur --}}
                                        <div class="form-group">
                                            <label for="nama_libur">Nama Libur</label>
                                            <input type="text" name="nama_libur"
                                                class="form-control @error('nama_libur') is-invalid @enderror"
                                                value="{{ old('nama_libur') }}" placeholder="Contoh: Tahun Baru Imlek"
                                                required>
                                            @error('nama_libur')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Tanggal --}}
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input type="date" name="tanggal"
                                                class="form-control @error('tanggal') is-invalid @enderror"
                                                value="{{ old('tanggal') }}" required>
                                            @error('tanggal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Jenis --}}
                                        <div class="form-group">
                                            <label for="is_cuti_bersama">Jenis</label>
                                            <select name="is_cuti_bersama"
                                                class="form-control @error('is_cuti_bersama') is-invalid @enderror">
                                                <option value="0"
                                                    {{ old('is_cuti_bersama') == '0' ? 'selected' : '' }}>Libur Nasional
                                                    / Biasa</option>
                                                <option value="1"
                                                    {{ old('is_cuti_bersama') == '1' ? 'selected' : '' }}>Cuti Bersama
                                                </option>
                                            </select>
                                            @error('is_cuti_bersama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Kantor (Opsional) --}}
                                        <div class="form-group">
                                            <label for="kantor_id">Berlaku Untuk Kantor (Opsional)</label>
                                            <select name="kantor_id"
                                                class="form-control @error('kantor_id') is-invalid @enderror">
                                                <option value="">-- Semua Kantor --</option>
                                                @foreach ($kantors as $kantor)
                                                    <option value="{{ $kantor->id }}"
                                                        {{ old('kantor_id') == $kantor->id ? 'selected' : '' }}>
                                                        {{ $kantor->nama_kantor }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">Biarkan kosong jika berlaku untuk semua
                                                kantor.</small>
                                            @error('kantor_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Deskripsi --}}
                                        <div class="form-group">
                                            <label for="deskripsi">Deskripsi</label>
                                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3"
                                                placeholder="Keterangan tambahan (opsional)">{{ old('deskripsi') }}</textarea>
                                            @error('deskripsi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="{{ route('hari-libur.index') }}" class="btn btn-secondary">Batal</a>
                                    </div>
                                </form>
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
