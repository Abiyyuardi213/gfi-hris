<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Form Perjalanan Dinas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
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
                            <h1>Form Pengajuan Perjalanan Dinas</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Isi Data Pengajuan</h3>
                        </div>
                        <form action="{{ route('perjalanan-dinas.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                @if (in_array($role, ['super admin', 'admin']))
                                    <div class="form-group">
                                        <label>Pilih Pegawai (Peserta)</label>
                                        <select class="form-control select2" name="peserta_ids[]" multiple="multiple"
                                            data-placeholder="Pilih Pegawai" style="width: 100%;" required>
                                            @foreach ($pegawais as $p)
                                                <option value="{{ $p->id }}">{{ $p->nama_lengkap }}
                                                    ({{ $p->nip }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Anda bisa memilih lebih dari satu pegawai.</small>
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> Pengajuan ini akan dibuat atas nama Anda
                                        sendiri.
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>Tujuan (Kota / Perusahaan / Lokasi)</label>
                                    <input type="text" name="tujuan" class="form-control"
                                        placeholder="Contoh: Jakarta, PT ABC" required>
                                </div>
                                <div class="form-group">
                                    <label>Keperluan Dinas</label>
                                    <textarea name="keperluan" class="form-control" rows="3" placeholder="Jelskans keperluan perjalanan dinas..."
                                        required></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Mulai</label>
                                            <input type="date" name="tanggal_mulai" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Selesai</label>
                                            <input type="date" name="tanggal_selesai" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Jenis Transportasi</label>
                                            <select name="jenis_transportasi" class="form-control" required>
                                                <option value="Pesawat">Pesawat</option>
                                                <option value="Kereta Api">Kereta Api</option>
                                                <option value="Mobil Dinas">Mobil Dinas</option>
                                                <option value="Mobil Pribadi">Mobil Pribadi</option>
                                                <option value="Travel / Bus">Travel / Bus</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Estimasi Biaya (Rp)</label>
                                            <input type="number" name="estimasi_biaya" class="form-control"
                                                placeholder="0" required>
                                            <small class="text-muted">Perkiraan total biaya yang dibutuhkan.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('perjalanan-dinas.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Ajukan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>

        @include('include.footerSistem')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
</body>

</html>
