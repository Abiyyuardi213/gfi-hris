<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Status Pegawai</title>

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
                        <h1 class="m-0">Edit Status Pegawai</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">

                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit"></i> Form Edit Status Pegawai
                        </h3>
                    </div>

                    <div class="card-body">

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('status-pegawai.update', $status->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Kode Status (Readonly) -->
                            <div class="form-group">
                                <label>Kode Status</label>
                                <input type="text"
                                       class="form-control"
                                       value="{{ $status->kode_status }}"
                                       readonly>
                                <small class="text-muted">
                                    Kode status dibuat otomatis dan tidak dapat diubah
                                </small>
                            </div>

                            <!-- Nama Status -->
                            <div class="form-group">
                                <label>Nama Status</label>
                                <input type="text"
                                       name="nama_status"
                                       class="form-control @error('nama_status') is-invalid @enderror"
                                       value="{{ old('nama_status', $status->nama_status) }}"
                                       required>

                                @error('nama_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Keterangan -->
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="keterangan"
                                          class="form-control @error('keterangan') is-invalid @enderror"
                                          rows="3">{{ old('keterangan', $status->keterangan) }}</textarea>

                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status Aktif -->
                            <div class="form-group">
                                <label>Status</label>
                                <select name="is_aktif"
                                        class="form-control @error('is_aktif') is-invalid @enderror"
                                        required>
                                    <option value="1" {{ old('is_aktif', $status->is_aktif) == 1 ? 'selected' : '' }}>
                                        Aktif
                                    </option>
                                    <option value="0" {{ old('is_aktif', $status->is_aktif) == 0 ? 'selected' : '' }}>
                                        Nonaktif
                                    </option>
                                </select>

                                @error('is_aktif')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Action -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Update
                                </button>
                                <a href="{{ route('status-pegawai.index') }}"
                                   class="btn btn-secondary">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>
</html>
