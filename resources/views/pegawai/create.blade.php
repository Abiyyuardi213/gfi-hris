<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Tambah Pegawai</title>
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
                            <h1 class="m-0">Tambah Pegawai Baru</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Identitas & Pribadi -->
                            <div class="col-md-6">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Data Identitas & Pribadi</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" name="nama_lengkap" class="form-control" require
                                                value="{{ old('nama_lengkap') }}">
                                        </div>
                                        <div class="form-group">
                                            <label>NIK (KTP) <span class="text-danger">*</span></label>
                                            <input type="text" name="nik" class="form-control" required
                                                minlength="16" maxlength="16" value="{{ old('nik') }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tempat Lahir <span class="text-danger">*</span></label>
                                                    <input type="text" name="tempat_lahir" class="form-control"
                                                        required value="{{ old('tempat_lahir') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                                    <input type="date" name="tanggal_lahir" class="form-control"
                                                        required value="{{ old('tanggal_lahir') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                            <select name="jenis_kelamin" class="form-control" required>
                                                <option value="">-- Pilih --</option>
                                                <option value="L"
                                                    {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                                </option>
                                                <option value="P"
                                                    {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Agama</label>
                                            <select name="agama" class="form-control">
                                                <option value="">-- Pilih --</option>
                                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>
                                                    Islam</option>
                                                <option value="Kristen"
                                                    {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                                <option value="Katolik"
                                                    {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>
                                                    Hindu</option>
                                                <option value="Buddha"
                                                    {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                                <option value="Konghucu"
                                                    {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Status Pernikahan</label>
                                            <select name="status_pernikahan" class="form-control">
                                                <option value="">-- Pilih --</option>
                                                <option value="Belum Menikah">Belum Menikah</option>
                                                <option value="Menikah">Menikah</option>
                                                <option value="Janda/Duda">Janda/Duda</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kepegawaian & Kontak -->
                            <div class="col-md-6">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Data Kepegawaian & Kontak</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Kantor <span class="text-danger">*</span></label>
                                            <select name="kantor_id" class="form-control" required>
                                                <option value="">-- Pilih Kantor --</option>
                                                @foreach ($kantors as $kantor)
                                                    <option value="{{ $kantor->id }}"
                                                        {{ old('kantor_id') == $kantor->id ? 'selected' : '' }}>
                                                        {{ $kantor->nama_kantor }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Divisi <span class="text-danger">*</span></label>
                                                    <select name="divisi_id" class="form-control" required>
                                                        <option value="">-- Pilih Divisi --</option>
                                                        @foreach ($divisis as $divisi)
                                                            <option value="{{ $divisi->id }}"
                                                                {{ old('divisi_id') == $divisi->id ? 'selected' : '' }}>
                                                                {{ $divisi->nama_divisi }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Jabatan <span class="text-danger">*</span></label>
                                                    <select name="jabatan_id" class="form-control" required>
                                                        <option value="">-- Pilih Jabatan --</option>
                                                        @foreach ($jabatans as $jabatan)
                                                            <option value="{{ $jabatan->id }}"
                                                                {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                                                                {{ $jabatan->nama_jabatan }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Status Pegawai <span class="text-danger">*</span></label>
                                            <select name="status_pegawai_id" class="form-control" required>
                                                <option value="">-- Pilih Status --</option>
                                                @foreach ($statusPegawais as $sp)
                                                    <option value="{{ $sp->id }}"
                                                        {{ old('status_pegawai_id') == $sp->id ? 'selected' : '' }}>
                                                        {{ $sp->nama_status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Shift Kerja <span class="text-danger">*</span></label>
                                            <select name="shift_kerja_id" class="form-control" required>
                                                <option value="">-- Pilih Shift Kerja --</option>
                                                @foreach ($shiftKerjas as $shift)
                                                    <option value="{{ $shift->id }}"
                                                        {{ old('shift_kerja_id') == $shift->id ? 'selected' : '' }}>
                                                        {{ $shift->nama_shift }} ({{ $shift->jam_masuk }} -
                                                        {{ $shift->jam_keluar }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Masuk <span class="text-danger">*</span></label>
                                            <input type="date" name="tanggal_masuk" class="form-control" required
                                                value="{{ old('tanggal_masuk', date('Y-m-d')) }}">
                                            <small class="text-muted">NIP akan digenerate otomatis berdasarkan tanggal
                                                ini.</small>
                                        </div>

                                        <div class="form-group">
                                            <label>No HP</label>
                                            <input type="text" name="no_hp" class="form-control"
                                                value="{{ old('no_hp') }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Email Pribadi</label>
                                            <input type="email" name="email_pribadi" class="form-control"
                                                value="{{ old('email_pribadi') }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Foto Profile</label>
                                            <input type="file" name="foto"
                                                class="form-control-file crop-image-input">
                                            <small class="text-muted">Format: JPG, JPEG, PNG. Max: 2MB</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">Alamat</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Alamat sesuai KTP</label>
                                            <textarea name="alamat_ktp" class="form-control" rows="2">{{ old('alamat_ktp') }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat Domisili</label>
                                            <textarea name="alamat_domisili" class="form-control" rows="2">{{ old('alamat_domisili') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-4">
                                <a href="{{ route('pegawai.index') }}" class="btn btn-secondary mr-2">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Data Pegawai</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        @include('include.footerSistem')
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    @include('include.cropperModal')
</body>

</html>
