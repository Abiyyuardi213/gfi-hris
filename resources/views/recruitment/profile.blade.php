<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Pelamar - GFI HRIS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- bs-custom-file-input -->
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">

</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        @include('include.navbarCareer')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"> Dashboard Pelamar</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-times-circle mr-2"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-warning alert-dismissible fade show">
                            <i class="fas fa-exclamation-triangle mr-2"></i> Periksa kembali isian formulir Anda.
                            <ul class="mb-0 mt-1 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-primary card-outline card-tabs">
                                <div class="card-header p-0 pt-1 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-three-profile-tab"
                                                data-toggle="pill" href="#custom-tabs-three-profile" role="tab"
                                                aria-controls="custom-tabs-three-profile" aria-selected="true">Profil &
                                                Berkas Lamaran</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-three-tabContent">
                                        <div class="tab-pane fade show active" id="custom-tabs-three-profile"
                                            role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">

                                            <p class="text-muted">Silakan lengkapi data diri dan berkas lamaran Anda di
                                                bawah ini agar dapat diproses lebih lanjut.</p>

                                            <form action="{{ route('recruitment.profile.update') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf

                                                <h5 class="text-primary mb-3"><i class="fas fa-id-card mr-2"></i> Data
                                                    Pribadi</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nama Lengkap</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ Auth::user()->name }}" readonly disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="email" class="form-control"
                                                                value="{{ Auth::user()->email }}" readonly disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>NIK (Nomor Induk Kependudukan) <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="number" name="nik" class="form-control"
                                                                placeholder="16 digit NIK"
                                                                value="{{ old('nik', $kandidat->nik ?? '') }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nomor WhatsApp (Aktif) <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" name="no_hp" class="form-control"
                                                                placeholder="08..."
                                                                value="{{ old('no_hp', $kandidat->no_hp ?? '') }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Tempat Lahir</label>
                                                            <input type="text" name="tempat_lahir"
                                                                class="form-control"
                                                                value="{{ old('tempat_lahir', $kandidat->tempat_lahir ?? '') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Tanggal Lahir</label>
                                                            <input type="date" name="tanggal_lahir"
                                                                class="form-control"
                                                                value="{{ old('tanggal_lahir', $kandidat->tanggal_lahir ?? '') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Pendidikan Terakhir <span
                                                                    class="text-danger">*</span></label>
                                                            <select name="pendidikan_terakhir" class="form-control"
                                                                required>
                                                                <option value="">-- Pilih --</option>
                                                                @foreach (['SMA/SMK', 'D3', 'S1', 'S2'] as $edu)
                                                                    <option value="{{ $edu }}"
                                                                        {{ old('pendidikan_terakhir', $kandidat->pendidikan_terakhir ?? '') == $edu ? 'selected' : '' }}>
                                                                        {{ $edu }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Alamat Domisili Lengkap <span
                                                                    class="text-danger">*</span></label>
                                                            <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $kandidat->alamat ?? '') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <h5 class="text-primary mb-3"><i class="fas fa-folder-open mr-2"></i>
                                                    Upload Berkas</h5>
                                                <div class="alert alert-info py-2">
                                                    <small><i class="fas fa-info-circle"></i> Format: PDF/JPG/PNG. Max
                                                        2MB. Jika file sudah ada, biarkan kosong kecuali ingin
                                                        mengganti.</small>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Pas Foto Formal</label>
                                                            @if (isset($kandidat->file_foto))
                                                                <div class="mb-2"><small class="text-success"><i
                                                                            class="fas fa-check"></i> Sudah
                                                                        terupload</small></div>
                                                            @endif
                                                            <div class="custom-file">
                                                                <input type="file" name="foto"
                                                                    class="custom-file-input" id="foto">
                                                                <label class="custom-file-label" for="foto">Pilih
                                                                    Foto...</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Scan KTP</label>
                                                            @if (isset($kandidat->file_ktp))
                                                                <div class="mb-2">
                                                                    <small class="text-success mr-2"><i
                                                                            class="fas fa-check"></i> Sudah
                                                                        terupload</small>
                                                                    <a href="{{ asset('storage/' . $kandidat->file_ktp) }}"
                                                                        target="_blank"
                                                                        class="badge badge-info">Lihat</a>
                                                                </div>
                                                            @endif
                                                            <div class="custom-file">
                                                                <input type="file" name="scan_ktp"
                                                                    class="custom-file-input" id="scan_ktp">
                                                                <label class="custom-file-label" for="scan_ktp">Pilih
                                                                    File KTP...</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Ijazah Terakhir</label>
                                                            @if (isset($kandidat->file_ijazah))
                                                                <div class="mb-2">
                                                                    <small class="text-success mr-2"><i
                                                                            class="fas fa-check"></i> Sudah
                                                                        terupload</small>
                                                                    <a href="{{ asset('storage/' . $kandidat->file_ijazah) }}"
                                                                        target="_blank"
                                                                        class="badge badge-info">Lihat</a>
                                                                </div>
                                                            @endif
                                                            <div class="custom-file">
                                                                <input type="file" name="ijazah"
                                                                    class="custom-file-input" id="ijazah">
                                                                <label class="custom-file-label" for="ijazah">Pilih
                                                                    File Ijazah...</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Transkrip Nilai</label>
                                                            @if (isset($kandidat->file_transkrip))
                                                                <div class="mb-2">
                                                                    <small class="text-success mr-2"><i
                                                                            class="fas fa-check"></i> Sudah
                                                                        terupload</small>
                                                                    <a href="{{ asset('storage/' . $kandidat->file_transkrip) }}"
                                                                        target="_blank"
                                                                        class="badge badge-info">Lihat</a>
                                                                </div>
                                                            @endif
                                                            <div class="custom-file">
                                                                <input type="file" name="transkrip"
                                                                    class="custom-file-input" id="transkrip">
                                                                <label class="custom-file-label" for="transkrip">Pilih
                                                                    File Transkrip...</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>CV / Daftar Riwayat Hidup</label>
                                                    @if (isset($kandidat->file_cv))
                                                        <div class="mb-2">
                                                            <small class="text-success mr-2"><i
                                                                    class="fas fa-check"></i> Sudah terupload</small>
                                                            <a href="{{ asset('storage/' . $kandidat->file_cv) }}"
                                                                target="_blank" class="badge badge-info">Lihat</a>
                                                        </div>
                                                    @endif
                                                    <div class="custom-file">
                                                        <input type="file" name="cv"
                                                            class="custom-file-input" id="cv">
                                                        <label class="custom-file-label" for="cv">Pilih File
                                                            CV...</label>
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary"><i
                                                        class="fas fa-save mr-1"></i> Simpan & Perbarui Data</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                GFI Recruitment System
            </div>
            <strong>Copyright &copy; 2025.</strong> All rights reserved.
        </footer>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" di bawah jika Anda ingin mengakhiri sesi Anda saat ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
</body>

</html>
