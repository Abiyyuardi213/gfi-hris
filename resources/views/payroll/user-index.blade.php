<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Slip Gaji Saya</title>
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
                            <h1>Slip Gaji Saya</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Riwayat Gaji</h3>
                        </div>
                        <div class="card-body">
                            <table id="myPayrollTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Periode</th>
                                        <th>Bulan/Tahun</th>
                                        <th>Gaji Bersih</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payrolls as $p)
                                        <tr>
                                            <td>{{ $p->payrollPeriod->nama_periode }}</td>
                                            <td>{{ $p->payrollPeriod->bulan }} / {{ $p->payrollPeriod->tahun }}</td>
                                            <td>Rp {{ number_format($p->gaji_bersih, 0, ',', '.') }}</td>
                                            <td>
                                                <a href="{{ route('payroll.show', $p->id) }}"
                                                    class="btn btn-info btn-sm" target="_blank">
                                                    <i class="fas fa-file-invoice-dollar"></i> Lihat Slip
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
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function() {
            $('#myPayrollTable').DataTable();
        });
    </script>
</body>

</html>
