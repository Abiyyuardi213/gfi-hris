<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Kantor</title>

    <link rel="icon" type="image/png" href="{{ asset('image/dropcore-icon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    @include('include.navbarSistem')
    @include('include.sidebar')

    <div class="content-wrapper">
        <!-- Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Ubah Kantor</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit"></i> Form Ubah Kantor
                        </h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('kantor.update', $kantor->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Nama Kantor -->
                            <div class="form-group">
                                <label for="nama_kantor">Nama Kantor</label>
                                <input type="text"
                                       name="nama_kantor"
                                       class="form-control @error('nama_kantor') is-invalid @enderror"
                                       value="{{ old('nama_kantor', $kantor->nama_kantor) }}"
                                       placeholder="Masukkan nama kantor"
                                       required>
                                @error('nama_kantor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Alamat -->
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat"
                                          class="form-control @error('alamat') is-invalid @enderror"
                                          rows="3"
                                          placeholder="Masukkan alamat kantor">{{ old('alamat', $kantor->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status"
                                        class="form-control @error('status') is-invalid @enderror"
                                        required>
                                    <option value="1" {{ old('status', $kantor->status) == 1 ? 'selected' : '' }}>
                                        Aktif
                                    </option>
                                    <option value="0" {{ old('status', $kantor->status) == 0 ? 'selected' : '' }}>
                                        Nonaktif
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Action -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('kantor.index') }}" class="btn btn-secondary">
                                    Batal
                                </a>
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

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
