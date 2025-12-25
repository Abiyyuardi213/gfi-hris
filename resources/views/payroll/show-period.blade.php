<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Detail Periode Gaji</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
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
                            <h1>Detail Periode: {{ $period->nama_periode }}</h1>
                        </div>
                        <div class="col-sm-6 text-right">
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Periode: {{ $period->start_date->format('d M Y') }} s/d
                        {{ $period->end_date->format('d M Y') }}
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Gaji Pegawai</h3>
                            <div class="card-tools">
                                @if (!$period->is_closed)
                                    <form action="{{ route('payroll.generate', $period->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Proses ini akan menghitung ulang gaji semua pegawai di periode ini. Lanjutkan?');">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="fas fa-sync"></i> Generate / Hitung Ulang Gaji
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="payrollDetailTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Pegawai</th>
                                        <th>Jabatan</th>
                                        <th>Gaji Pokok</th>
                                        <th>Total Tunjangan</th>
                                        <th>Total Potongan</th>
                                        <th>Gaji Bersih (Take Home Pay)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($period->payrolls as $p)
                                        <tr>
                                            <td>{{ $p->pegawai->nama_lengkap }}</td>
                                            <td>{{ $p->pegawai->jabatan ? $p->pegawai->jabatan->nama_jabatan : '-' }}
                                            </td>
                                            <td>Rp {{ number_format($p->gaji_pokok, 0, ',', '.') }}</td>
                                            <td class="text-success">+ Rp
                                                {{ number_format($p->total_tunjangan, 0, ',', '.') }}</td>
                                            <td class="text-danger">- Rp
                                                {{ number_format($p->total_potongan, 0, ',', '.') }}</td>
                                            <td><strong>Rp {{ number_format($p->gaji_bersih, 0, ',', '.') }}</strong>
                                            </td>
                                            <td>
                                                <a href="{{ route('payroll.show', $p->id) }}"
                                                    class="btn btn-info btn-sm" target="_blank">
                                                    <i class="fas fa-file-invoice-dollar"></i> Slip
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function() {
            $('#payrollDetailTable').DataTable({
                "responsive": true
            });
            @if (session('success'))
                $('#toastNotification').toast('show');
            @endif
            @if (session('error'))
                $('#toastNotification').removeClass('bg-success').addClass('bg-danger');
                $('.toast-header').removeClass('bg-success').addClass('bg-danger');
                $('#toastNotification').toast('show');
            @endif
        });
    </script>
</body>

</html>
