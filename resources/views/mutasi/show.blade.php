<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mutasi - {{ $riwayat->pegawai->nama_lengkap }}</title>
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
                            <h1>Detail Riwayat Karir</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="invoice p-3 mb-3">
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-file-signature"></i> Surat Keputusan (SK)
                                    <small class="float-right">TMT:
                                        {{ $riwayat->tanggal_efektif->format('d/m/Y') }}</small>
                                </h4>
                            </div>
                        </div>

                        <div class="row invoice-info mt-4">
                            <div class="col-sm-4 invoice-col">
                                Data Pegawai
                                <address>
                                    <strong>{{ $riwayat->pegawai->nama_lengkap }}</strong><br>
                                    NIP: {{ $riwayat->pegawai->nip }}<br>
                                    Email: {{ $riwayat->pegawai->email }}
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                Jenis Perubahan
                                <address>
                                    <strong>{{ strtoupper($riwayat->jenis_perubahan) }}</strong><br>
                                    Nomor SK: {{ $riwayat->no_sk ?? '-' }}<br>
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                Dibuat Oleh:
                                <br>
                                <b>{{ $riwayat->creator->nama_lengkap ?? 'Admin' }}</b><br>
                                Tanggal Buat: {{ $riwayat->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Atribut</th>
                                            <th>Lama (Sebelum)</th>
                                            <th>Baru (Sesudah)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Jabatan</td>
                                            <td>{{ $riwayat->jabatanAwal->nama_jabatan ?? '-' }}</td>
                                            <td class="text-primary font-weight-bold">
                                                {{ $riwayat->jabatanTujuan->nama_jabatan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Divisi</td>
                                            <td>{{ $riwayat->divisiAwal->nama_divisi ?? '-' }}</td>
                                            <td class="text-primary font-weight-bold">
                                                {{ $riwayat->divisiTujuan->nama_divisi }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kantor / Lokasi</td>
                                            <td>{{ $riwayat->kantorAwal->nama_kantor ?? '-' }}</td>
                                            <td class="text-primary font-weight-bold">
                                                {{ $riwayat->kantorTujuan->nama_kantor }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <p class="lead">Keterangan:</p>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    {{ $riwayat->keterangan ?? 'Tidak ada keterangan tambahan.' }}
                                </p>
                            </div>
                        </div>

                        <div class="row no-print mt-4">
                            <div class="col-12">
                                <a href="{{ route('mutasi.index') }}" class="btn btn-default">Kembali</a>
                                <button onclick="window.print()" class="btn btn-primary float-right"
                                    style="margin-right: 5px;">
                                    <i class="fas fa-print"></i> Cetak SK
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @include('include.footerSistem')
        @include('services.ToastModal')
        @include('services.LogoutModal')
    </div>
</body>

</html>
