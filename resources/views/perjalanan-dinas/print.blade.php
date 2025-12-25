<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Tugas - {{ $perjalanan->no_surat_tugas }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .invoice-title {
            margin-top: 0;
        }

        @media print {

            .no-print,
            .main-footer,
            .navbar,
            .main-sidebar {
                display: none !important;
            }

            .content-wrapper {
                margin-left: 0 !important;
            }

            .card {
                box-shadow: none !important;
                border: none !important;
            }

            body {
                background-color: white;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="no-print">
            @include('include.navbarSistem')
            @include('include.sidebar')
        </div>

        <div class="content-wrapper">
            <section class="content-header no-print">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Detail Perjalanan Dinas</h1>
                        </div>
                        <div class="col-sm-6 text-right">

                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Main content -->
                            <div class="invoice p-3 mb-3">
                                <!-- title row -->
                                <div class="row">
                                    <div class="col-12">
                                        <h4>
                                            <i class="fas fa-globe"></i> PT. GARUDA FIBER
                                            <small class="float-right">Tanggal: {{ date('d/m/Y') }}</small>
                                        </h4>
                                    </div>
                                </div>

                                <br>
                                <div class="row invoice-info text-center mb-4">
                                    <div class="col-12">
                                        <h3>SURAT PERINTAH PERJALANAN DINAS (SPPD)</h3>
                                        <h5>Nomor: {{ $perjalanan->no_surat_tugas }}</h5>
                                    </div>
                                </div>

                                <div class="row invoice-info">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th style="width:20%">DASAR</th>
                                                <td>: Persetujuan Manajemen terkait Operasional Perusahaan.</td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">DIPERINTAHKAN KEPADA:</th>
                                            </tr>
                                            <tr>
                                                <th style="padding-left: 20px; vertical-align: top;">Nama / NIP /
                                                    Jabatan</th>
                                                <td>
                                                    <ol style="padding-left: 15px; margin: 0;">
                                                        @foreach ($perjalanan->peserta as $peserta)
                                                            <li class="mb-2">
                                                                <strong>{{ $peserta->nama_lengkap }}</strong><br>
                                                                NIP: {{ $peserta->nip }} |
                                                                {{ $peserta->jabatan->nama_jabatan ?? 'Staff' }}
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">UNTUK:</th>
                                            </tr>
                                            <tr>
                                                <th style="padding-left: 20px">Tujuan</th>
                                                <td>: {{ $perjalanan->tujuan }}</td>
                                            </tr>
                                            <tr>
                                                <th style="padding-left: 20px">Keperluan</th>
                                                <td>: {{ $perjalanan->keperluan }}</td>
                                            </tr>
                                            <tr>
                                                <th style="padding-left: 20px">Tanggal</th>
                                                <td>: {{ $perjalanan->tanggal_mulai->format('d F Y') }} s/d
                                                    {{ $perjalanan->tanggal_selesai->format('d F Y') }}
                                                    ({{ $perjalanan->tanggal_mulai->diffInDays($perjalanan->tanggal_selesai) + 1 }}
                                                    Hari)</td>
                                            </tr>
                                            <tr>
                                                <th style="padding-left: 20px">Transportasi</th>
                                                <td>: {{ $perjalanan->jenis_transportasi }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                            Catatan: Harap simpan bukti pengeluaran untuk keperluan reimbursement (klaim
                                            biaya).
                                        </p>
                                    </div>
                                    <div class="col-6 mt-4">
                                        <div class="float-right text-center">
                                            <p>Jakarta, {{ date('d F Y') }}</p>
                                            <p>Disetujui Oleh,</p>

                                            <!-- Digital Signature / Barcode -->
                                            @if ($perjalanan->status == 'Disetujui')
                                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode('Approved by ' . ($perjalanan->approver->nama_lengkap ?? 'Admin') . ' on ' . $perjalanan->updated_at) }}"
                                                    alt="QR Code" style="margin: 10px 0;">
                                                <p class="font-weight-bold">
                                                    <u>{{ $perjalanan->approver->nama_lengkap ?? 'ADMINISTRATOR' }}</u><br>
                                                    <small>Digital Signature Verified</small>
                                                </p>
                                            @else
                                                <div style="height: 100px; padding-top: 40px;">( Belum Disetujui )</div>
                                                <p class="font-weight-bold mt-2">_______________________</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Approval Actions (No Print) -->
                    <div class="row no-print mt-3">
                        <div class="col-md-6">
                            @if (in_array(strtolower(Auth::user()->role->role_name), ['super admin', 'admin']) && $perjalanan->status == 'Pengajuan')
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Persetujuan</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('perjalanan-dinas.approve', $perjalanan->id) }}"
                                            method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>Catatan Admin</label>
                                                <textarea name="catatan" class="form-control" rows="2" required></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <button type="submit" name="action" value="approve"
                                                        class="btn btn-success btn-block">Setujui</button>
                                                </div>
                                                <div class="col-6">
                                                    <button type="submit" name="action" value="reject"
                                                        class="btn btn-danger btn-block">Tolak</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <section class="content no-print pb-3">
                <div class="container-fluid">
                    <button onclick="window.print()" class="btn btn-default btn-lg"><i class="fas fa-print"></i> Cetak
                        Surat Tugas</button>
                    <a href="{{ route('perjalanan-dinas.index') }}"
                        class="btn btn-secondary btn-lg float-right">Kembali</a>
                </div>
            </section>
        </div>

        <div class="no-print">
            @include('include.footerSistem')
            @include('services.ToastModal')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script>
        $(function() {
            @if (session('success'))
                $('#toastNotification').toast('show');
            @endif
        });
    </script>
</body>

</html>
