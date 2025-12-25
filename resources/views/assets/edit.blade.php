<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Edit Aset</title>
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
                            <h1>Edit Aset: {{ $asset->nama_aset }}</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Edit Data Aset</h3>
                        </div>
                        <form action="{{ route('assets.update', $asset->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kode Aset</label>
                                            <input type="text" name="kode_aset" class="form-control"
                                                value="{{ $asset->kode_aset }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Aset</label>
                                            <input type="text" name="nama_aset" class="form-control"
                                                value="{{ $asset->nama_aset }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <select name="kategori" class="form-control" required>
                                                <option value="Elektronik"
                                                    {{ $asset->kategori == 'Elektronik' ? 'selected' : '' }}>Elektronik
                                                </option>
                                                <option value="Kendaraan"
                                                    {{ $asset->kategori == 'Kendaraan' ? 'selected' : '' }}>Kendaraan
                                                </option>
                                                <option value="Furniture"
                                                    {{ $asset->kategori == 'Furniture' ? 'selected' : '' }}>Furniture
                                                </option>
                                                <option value="Alat Tulis"
                                                    {{ $asset->kategori == 'Alat Tulis' ? 'selected' : '' }}>Alat Tulis
                                                </option>
                                                <option value="Lainnya"
                                                    {{ $asset->kategori == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Merk & Model</label>
                                            <input type="text" name="merk_model" class="form-control"
                                                value="{{ $asset->merk_model }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nomor Seri</label>
                                            <input type="text" name="nomor_seri" class="form-control"
                                                value="{{ $asset->nomor_seri }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Pembelian</label>
                                            <input type="date" name="tanggal_pembelian" class="form-control"
                                                value="{{ $asset->tanggal_pembelian ? $asset->tanggal_pembelian->format('Y-m-d') : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Harga Perolehan (Rp)</label>
                                            <input type="number" name="harga_perolehan" class="form-control"
                                                value="{{ $asset->harga_perolehan }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kondisi</label>
                                            <select name="kondisi" class="form-control">
                                                <option value="Baik"
                                                    {{ $asset->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                <option value="Rusak Ringan"
                                                    {{ $asset->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak
                                                    Ringan</option>
                                                <option value="Rusak Berat"
                                                    {{ $asset->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak
                                                    Berat</option>
                                                <option value="Dalam Perbaikan"
                                                    {{ $asset->kondisi == 'Dalam Perbaikan' ? 'selected' : '' }}>Dalam
                                                    Perbaikan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="Tersedia"
                                                    {{ $asset->status == 'Tersedia' ? 'selected' : '' }}>Tersedia
                                                </option>
                                                <option value="Digunakan"
                                                    {{ $asset->status == 'Digunakan' ? 'selected' : '' }}>Digunakan
                                                </option>
                                                <option value="Dipinjamkan"
                                                    {{ $asset->status == 'Dipinjamkan' ? 'selected' : '' }}>Dipinjamkan
                                                </option>
                                                <option value="Hilang"
                                                    {{ $asset->status == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                                                <option value="Dijual/Musnah"
                                                    {{ $asset->status == 'Dijual/Musnah' ? 'selected' : '' }}>
                                                    Dijual/Musnah</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Dipegang Oleh (Pegawai)</label>
                                    <select class="form-control select2" name="pegawai_id" style="width: 100%;">
                                        <option value="">-- Tidak Ada / Di Gudang --</option>
                                        @foreach ($pegawais as $p)
                                            <option value="{{ $p->id }}"
                                                {{ $asset->pegawai_id == $p->id ? 'selected' : '' }}>
                                                {{ $p->nama_lengkap }} ({{ $p->nip }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Foto Aset</label>
                                    @if ($asset->foto)
                                        <br><img src="{{ asset('storage/' . $asset->foto) }}" width="100"
                                            class="mb-2 rounded">
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" name="foto" class="custom-file-input"
                                            id="customFile">
                                        <label class="custom-file-label" for="customFile">Ganti foto...</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Keterangan Tambahan</label>
                                    <textarea name="keterangan" class="form-control" rows="3">{{ $asset->keterangan }}</textarea>
                                </div>

                            </div>
                            <div class="card-footer">
                                <a href="{{ route('assets.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-warning">Update Aset</button>
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
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        });
    </script>
</body>

</html>
