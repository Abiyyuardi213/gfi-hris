<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Tambah Aset</title>
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
                            <h1>Tambah Aset / Inventaris</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Form Data Aset</h3>
                        </div>
                        <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kode Aset (Auto)</label>
                                            <input type="text" name="kode_aset" class="form-control"
                                                value="{{ $kode_aset }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Aset</label>
                                            <input type="text" name="nama_aset" class="form-control"
                                                placeholder="Contoh: Laptop Dell Latitude" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <select name="kategori" class="form-control" required>
                                                <option value="Elektronik">Elektronik (Laptop/PC/HP)</option>
                                                <option value="Kendaraan">Kendaraan</option>
                                                <option value="Furniture">Furniture (Meja/Kursi)</option>
                                                <option value="Alat Tulis">Alat Tulis / Kantor</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Merk & Model</label>
                                            <input type="text" name="merk_model" class="form-control"
                                                placeholder="Contoh: Dell Latitude 7420">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nomor Seri (Serial Number)</label>
                                            <input type="text" name="nomor_seri" class="form-control"
                                                placeholder="SN...">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Pembelian</label>
                                            <input type="date" name="tanggal_pembelian" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Harga Perolehan (Rp)</label>
                                            <input type="number" name="harga_perolehan" class="form-control"
                                                placeholder="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kondisi</label>
                                            <select name="kondisi" class="form-control">
                                                <option value="Baik">Baik</option>
                                                <option value="Rusak Ringan">Rusak Ringan</option>
                                                <option value="Rusak Berat">Rusak Berat</option>
                                                <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="Tersedia">Tersedia (Di Gudang)</option>
                                                <option value="Digunakan">Digunakan (Oleh Pegawai)</option>
                                                <option value="Dipinjamkan">Dipinjamkan</option>
                                                <option value="Hilang">Hilang</option>
                                                <option value="Dijual/Musnah">Dijual/Musnah</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Dipegang Oleh (Pegawai)</label>
                                    <select class="form-control select2" name="pegawai_id" style="width: 100%;">
                                        <option value="">-- Tidak Ada / Di Gudang --</option>
                                        @foreach ($pegawais as $p)
                                            <option value="{{ $p->id }}">{{ $p->nama_lengkap }}
                                                ({{ $p->nip }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Kosongkan jika aset disimpan di gudang.</small>
                                </div>

                                <div class="form-group">
                                    <label>Foto Aset</label>
                                    <div class="custom-file">
                                        <input type="file" name="foto" class="custom-file-input"
                                            id="customFile">
                                        <label class="custom-file-label" for="customFile">Pilih file</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Keterangan Tambahan</label>
                                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                                </div>

                            </div>
                            <div class="card-footer">
                                <a href="{{ route('assets.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Aset</button>
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
            // Custom file input label
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        });
    </script>

    @include('services.ToastModal')
</body>

</html>
