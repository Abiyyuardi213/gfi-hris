<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $payroll->pegawai->nama_lengkap }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
        }

        .invoice {
            border: 1px solid #ddd;
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .amount {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
            font-size: 1.1em;
            background-color: #f9f9f9;
        }

        @media print {
            .no-print {
                display: none;
            }

            .invoice {
                border: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="invoice">
            <div class="header">
                <h2>PT. GFI HRIS SYSTEM</h2>
                <h4>SLIP GAJI PEGAWAI</h4>
                <p>Periode: {{ $payroll->payrollPeriod->bulan }} / {{ $payroll->payrollPeriod->tahun }}</p>
                <p class="small">Rentang: {{ $payroll->payrollPeriod->start_date->format('d M Y') }} -
                    {{ $payroll->payrollPeriod->end_date->format('d M Y') }}</p>
            </div>

            <div class="row info-pegawai mb-4">
                <div class="col-6">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="120">NIP</td>
                            <td>: <strong>{{ $payroll->pegawai->nip ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>: <strong>{{ $payroll->pegawai->nama_lengkap }}</strong></td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>: {{ $payroll->pegawai->jabatan->nama_jabatan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-6 text-right">
                    <p>Tanggal Cetak: {{ date('d M Y') }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="section-title text-success">PENDAPATAN (EARNINGS)</div>
                    <table class="table table-sm table-striped">
                        @foreach ($payroll->details->where('tipe', 'pendapatan') as $d)
                            <tr>
                                <td>{{ $d->nama_komponen }}</td>
                                <td class="amount">Rp {{ number_format($d->jumlah, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="col-6">
                    <div class="section-title text-danger">POTONGAN (DEDUCTIONS)</div>
                    <table class="table table-sm table-striped">
                        @foreach ($payroll->details->where('tipe', 'potongan') as $d)
                            <tr>
                                <td>{{ $d->nama_komponen }}</td>
                                <td class="amount">Rp {{ number_format($d->jumlah, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <table class="table table-bordered">
                        <tr class="total-row">
                            <td width="70%">Total Penerimaan Bersih (Take Home Pay)</td>
                            <td class="amount text-primary">Rp {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr class="small text-muted">
                            <td colspan="2">
                                <em>Terbilang: #
                                    {{ ucwords(\NumberFormatter::create('id', \NumberFormatter::SPELLOUT)->format($payroll->gaji_bersih)) }}
                                    Rupiah #</em>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-6 text-center">
                    <p>Penerima,</p>
                    <br><br><br>
                    <p><strong>{{ $payroll->pegawai->nama_lengkap }}</strong></p>
                </div>
                <div class="col-6 text-center">
                    <p>Dibuat Oleh,</p>
                    <br><br><br>
                    <p><strong>HRD / Finance</strong></p>
                </div>
            </div>

            <div class="text-center mt-5 no-print">
                <button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print"></i> Cetak PDF</button>
                <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
            </div>
        </div>
    </div>
</body>

</html>
