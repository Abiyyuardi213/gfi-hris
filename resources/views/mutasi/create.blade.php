<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Form Mutasi</title>
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
                            <h1>Form Mutasi / Promosi Pegawai</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Isi Data Perubahan</h3>
                        </div>
                        <form action="{{ route('mutasi.store') }}" method="POST">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label>Pilih Pegawai</label>
                                    <select class="form-control select2" name="pegawai_id" id="pegawaiSelect"
                                        style="width: 100%;" required>
                                        <option value="">-- Cari Pegawai --</option>
                                        @foreach ($pegawais as $p)
                                            <option value="{{ $p->id }}" data-jabatan="{{ $p->jabatan_id }}"
                                                data-divisi="{{ $p->divisi_id }}" data-kantor="{{ $p->kantor_id }}">
                                                {{ $p->nama_lengkap }} ({{ $p->nip }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Jenis Perubahan</label>
                                            <select name="jenis_perubahan" class="form-control" required>
                                                <option value="Promosi">Promosi (Kenaikan Jabatan)</option>
                                                <option value="Mutasi">Mutasi (Pindah Lokasi/Divisi)</option>
                                                <option value="Rotasi">Rotasi (Pindah Tugas Setara)</option>
                                                <option value="Demosi">Demosi (Penurunan Jabatan)</option>
                                                <option value="Penyesuaian">Penyesuaian Data</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Efektif (TMT)</label>
                                            <input type="date" name="tanggal_efektif" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5 class="text-primary"><i class="fas fa-arrow-right"></i> Data Baru (Tujuan)
                                        </h5>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Jabatan Baru</label>
                                            <select name="jabatan_tujuan_id" id="jabatanTujuan"
                                                class="form-control select2" required>
                                                @foreach ($jabatans as $j)
                                                    <option value="{{ $j->id }}">{{ $j->nama_jabatan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Divisi Baru</label>
                                            <select name="divisi_tujuan_id" id="divisiTujuan"
                                                class="form-control select2" required>
                                                @foreach ($divisis as $d)
                                                    <option value="{{ $d->id }}">{{ $d->nama_divisi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Kantor Baru</label>
                                            <select name="kantor_tujuan_id" id="kantorTujuan"
                                                class="form-control select2" required>
                                                @foreach ($kantors as $k)
                                                    <option value="{{ $k->id }}">{{ $k->nama_kantor }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label>Nomor SK (Surat Keputusan)</label>
                                    <input type="text" name="no_sk" class="form-control"
                                        placeholder="Contoh: SK/001/HRD/2025">
                                </div>

                                <div class="form-group">
                                    <label>Keterangan / Alasan</label>
                                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                                </div>

                            </div>
                            <div class="card-footer">
                                <a href="{{ route('mutasi.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary"
                                    onclick="return confirm('Apakah Anda yakin? Data pegawai akan langsung diperbarui sesuai tanggal efektif.')">Simpan
                                    Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>

        @include('include.footerSistem')
        @include('services.ToastModal')
        @include('services.LogoutModal')
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

            // Auto-fill current data when employee selected (Optional, but good UX to show "Current")
            $('#pegawaiSelect').on('change', function() {
                var selected = $(this).find('option:selected');
                var jabId = selected.data('jabatan');
                var divId = selected.data('divisi');
                var kanId = selected.data('kantor');

                // We could set the defaults, but usually user wants to change them.
                // Maybe just logging or showing "Current: X" in a span would be better.
                // For now, let's just pre-select them so user only changes what's needed.
                if (jabId) $('#jabatanTujuan').val(jabId).trigger('change');
                if (divId) $('#divisiTujuan').val(divId).trigger('change');
                if (kanId) $('#kantorTujuan').val(kanId).trigger('change');
            });
        });
    </script>
</body>

</html>
