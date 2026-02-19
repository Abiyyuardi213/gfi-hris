<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Aset - {{ $asset->nama_aset }}</title>
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
                            <h1>Detail Aset</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <!-- Foto Aset -->
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        @if ($asset->foto)
                                            <img class="img-fluid" src="{{ asset('storage/' . $asset->foto) }}"
                                                alt="Foto Aset" style="max-height: 300px;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center"
                                                style="height: 200px;">
                                                <i class="fas fa-box fa-4x text-muted"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <h3 class="profile-username text-center mt-3">{{ $asset->nama_aset }}</h3>
                                    <p class="text-muted text-center">{{ $asset->kode_aset }}</p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Kategori</b> <a class="float-right">{{ $asset->kategori }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Kondisi</b>
                                            <a class="float-right">
                                                @if ($asset->kondisi == 'Baik')
                                                    <span class="badge badge-success">Baik</span>
                                                @elseif($asset->kondisi == 'Rusak Ringan')
                                                    <span class="badge badge-warning">Rusak Ringan</span>
                                                @else
                                                    <span class="badge badge-danger">{{ $asset->kondisi }}</span>
                                                @endif
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Status</b> <a class="float-right">{{ $asset->status }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header p-2">
                                    <h3 class="card-title">Informasi Detail</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong><i class="fas fa-tag mr-1"></i> Merk & Model</strong>
                                            <p class="text-muted">{{ $asset->merk_model ?? '-' }}</p>
                                            <hr>

                                            <strong><i class="fas fa-barcode mr-1"></i> Nomor Seri</strong>
                                            <p class="text-muted">{{ $asset->nomor_seri ?? '-' }}</p>
                                            <hr>

                                            <strong><i class="fas fa-user mr-1"></i> Pemegang Saat Ini</strong>
                                            <p class="text-muted">
                                                @if ($asset->pegawai)
                                                    {{ $asset->pegawai->nama_lengkap }} <br>
                                                    <small>NIP: {{ $asset->pegawai->nip }}</small>
                                                @else
                                                    - (Di Gudang)
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong><i class="fas fa-calendar mr-1"></i> Tanggal Pembelian</strong>
                                            <p class="text-muted">
                                                {{ $asset->tanggal_pembelian ? $asset->tanggal_pembelian->format('d M Y') : '-' }}
                                            </p>
                                            <hr>

                                            <strong><i class="fas fa-money-bill mr-1"></i> Harga Perolehan</strong>
                                            <p class="text-muted">Rp
                                                {{ number_format($asset->harga_perolehan, 0, ',', '.') }}</p>
                                            <hr>

                                            <strong><i class="fas fa-file-alt mr-1"></i> Keterangan</strong>
                                            <p class="text-muted">{{ $asset->keterangan ?? '-' }}</p>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <a href="{{ route('assets.index') }}" class="btn btn-secondary">Kembali</a>
                                            <a href="{{ route('assets.edit', $asset->id) }}"
                                                class="btn btn-warning float-right">Edit Data</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @include('include.footerSistem')
    </div>
</body>

</html>
