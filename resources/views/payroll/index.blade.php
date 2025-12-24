<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Payroll</title>
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
                            <h1>Payroll / Penggajian</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Periode Gaji</h3>
                            <div class="card-tools">
                                <a href="{{ route('payroll.create-period') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Buat Periode Baru
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="payrollTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Periode</th>
                                        <th>Bulan</th>
                                        <th>Rentang Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($periods as $p)
                                        <tr>
                                            <td>{{ $p->nama_periode }}</td>
                                            <td>{{ $p->bulan }} / {{ $p->tahun }}</td>
                                            <td>{{ $p->start_date->format('d M Y') }} -
                                                {{ $p->end_date->format('d M Y') }}</td>
                                            <td>
                                                @if ($p->is_closed)
                                                    <span class="badge badge-success">Closed (Terkunci)</span>
                                                @else
                                                    <span class="badge badge-warning">Draft</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('payroll.show-period', $p->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Detail
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
            $('#payrollTable').DataTable({
                "ordering": false
            });
            @if (session('success'))
                $('#toastNotification').toast('show');
            @endif
        });
    </script>
</body>

</html>
