<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Edit Shift Kerja</title>
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
                            <h1>Edit Shift Kerja</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title">Form Edit Shift</h3>
                                </div>

                                <form action="{{ route('shift-kerja.update', $shift->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body">

                                        {{-- Kode Shift --}}
                                        <div class="form-group">
                                            <label for="kode_shift">Kode Shift</label>
                                            <input type="text" name="kode_shift"
                                                class="form-control @error('kode_shift') is-invalid @enderror"
                                                value="{{ old('kode_shift', $shift->kode_shift) }}" required>
                                            @error('kode_shift')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Nama Shift --}}
                                        <div class="form-group">
                                            <label for="nama_shift">Nama Shift</label>
                                            <input type="text" name="nama_shift"
                                                class="form-control @error('nama_shift') is-invalid @enderror"
                                                value="{{ old('nama_shift', $shift->nama_shift) }}" required>
                                            @error('nama_shift')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Jam Masuk & Keluar --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="jam_masuk">Jam Masuk</label>
                                                    <input type="time" name="jam_masuk"
                                                        class="form-control @error('jam_masuk') is-invalid @enderror" //
                                                        Format time to H:i
                                                        value="{{ old('jam_masuk', \Carbon\Carbon::parse($shift->jam_masuk)->format('H:i')) }}"
                                                        required>
                                                    @error('jam_masuk')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="jam_keluar">Jam Keluar</label>
                                                    <input type="time" name="jam_keluar"
                                                        class="form-control @error('jam_keluar') is-invalid @enderror"
                                                        value="{{ old('jam_keluar', \Carbon\Carbon::parse($shift->jam_keluar)->format('H:i')) }}"
                                                        required>
                                                    @error('jam_keluar')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Status --}}
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status"
                                                class="form-control @error('status') is-invalid @enderror">
                                                <option value="1"
                                                    {{ old('status', $shift->status) == '1' ? 'selected' : '' }}>Aktif
                                                </option>
                                                <option value="0"
                                                    {{ old('status', $shift->status) == '0' ? 'selected' : '' }}>
                                                    Nonaktif</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-warning">Update</button>
                                        <a href="{{ route('shift-kerja.index') }}" class="btn btn-secondary">Batal</a>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
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
