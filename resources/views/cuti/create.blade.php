<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Ajukan Cuti</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
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
                            <h1>Form Pengajuan Cuti</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Isi Data Cuti</h3>
                        </div>
                        <form action="{{ route('cuti.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Sisa Cuti Tahunan Anda:
                                    <strong>{{ $pegawai->sisa_cuti }} Hari</strong>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Cuti</label>
                                    <select name="jenis_cuti_id" class="form-control" required>
                                        <option value="">-- Pilih Jenis Cuti --</option>
                                        @foreach ($jenisCutis as $jc)
                                            <option value="{{ $jc->id }}">{{ $jc->nama_jenis }} (Kuota Default:
                                                {{ $jc->kuota }})</option>
                                        @endforeach
                                    </select>
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
                                <div class="form-group">
                                    <label>Keterangan / Alasan Cuti</label>
                                    <textarea name="keterangan" class="form-control" rows="3"
                                        placeholder="Contoh: Cuti Tahunan untuk liburan keluarga..." required></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('cuti.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>

        @include('include.footerSistem')
        @include('services.ToastModal')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script>
        @if (session('error'))
            $('#toastNotification').removeClass('bg-success').addClass('bg-danger');
            $('.toast-header').removeClass('bg-success').addClass('bg-danger');
            $('#toastNotification').toast('show');
        @endif
    </script>
</body>

</html>
