<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Divisi Jabatan</title>

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
                        <h1 class="m-0">Ubah Divisi Jabatan</h1>
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
                            <i class="fas fa-edit"></i> Form Ubah Divisi Jabatan
                        </h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('divisi-jabatan.update', $divisiJabatan->id) }}"
                              method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Kantor -->
                            <div class="form-group">
                                <label>Kantor</label>
                                <select name="kantor_id"
                                        class="form-control @error('kantor_id') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Kantor --</option>
                                    @foreach($kantors as $kantor)
                                        <option value="{{ $kantor->id }}"
                                            {{ old('kantor_id', $divisiJabatan->kantor_id) == $kantor->id ? 'selected' : '' }}>
                                            {{ $kantor->nama_kantor }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kantor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Divisi -->
                            <div class="form-group">
                                <label>Divisi</label>
                                <select name="divisi_id"
                                        class="form-control @error('divisi_id') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Divisi --</option>
                                    @foreach($divisis as $divisi)
                                        <option value="{{ $divisi->id }}"
                                            {{ old('divisi_id', $divisiJabatan->divisi_id) == $divisi->id ? 'selected' : '' }}>
                                            {{ $divisi->nama_divisi }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('divisi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jabatan -->
                            <div class="form-group">
                                <label>Jabatan</label>
                                <select name="jabatan_id"
                                        class="form-control @error('jabatan_id') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach($jabatans as $jabatan)
                                        <option value="{{ $jabatan->id }}"
                                            {{ old('jabatan_id', $divisiJabatan->jabatan_id) == $jabatan->id ? 'selected' : '' }}>
                                            {{ $jabatan->nama_jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jabatan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status"
                                        class="form-control @error('status') is-invalid @enderror"
                                        required>
                                    <option value="1"
                                        {{ old('status', $divisiJabatan->status) == 1 ? 'selected' : '' }}>
                                        Aktif
                                    </option>
                                    <option value="0"
                                        {{ old('status', $divisiJabatan->status) == 0 ? 'selected' : '' }}>
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
                                <a href="{{ route('divisi-jabatan.index') }}"
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
