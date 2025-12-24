<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Rekap Absensi</title>
    <link rel="icon" type="image/png" href="{{ asset('image/dropcore-icon.png') }}">
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
                            <h1>Rekap Absensi Bulanan</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <form method="GET" action="{{ route('presensi.summary') }}" class="form-inline">
                                <label class="mr-2">Bulan:</label>
                                <select name="month" class="form-control mr-3">
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ $m == $currentMonth ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                    @endfor
                                </select>
                                <label class="mr-2">Tahun:</label>
                                <select name="year" class="form-control mr-3">
                                    @for ($y = date('Y'); $y >= 2020; $y--)
                                        <option value="{{ $y }}" {{ $y == $currentYear ? 'selected' : '' }}>
                                            {{ $y }}</option>
                                    @endfor
                                </select>
                                <button type="submit" class="btn btn-primary">Tampilkan</button>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="summaryTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pegawai</th>
                                            <th>Hadir</th>
                                            <th>Sakit</th>
                                            <th>Izin</th>
                                            <th>Alpa</th>
                                            <th>Terlambat (x)</th>
                                            <th>Pulang Cepat (x)</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // Need Logic to calculate stats per pegawai for the month
                                            // Ideally done in Controller or Service, but for MVP here:
                                        @endphp
                                        @foreach ($pegawais as $index => $pegawai)
                                            @php
                                                $stats = \App\Models\Presensi::where('pegawai_id', $pegawai->id)
                                                    ->whereMonth('tanggal', $currentMonth)
                                                    ->whereYear('tanggal', $currentYear)
                                                    ->get();

                                                $hadir = $stats->where('status', 'Hadir')->count();
                                                $sakit = $stats->where('status', 'Sakit')->count();
                                                $izin = $stats->where('status', 'Izin')->count();
                                                $alpa = $stats->where('status', 'Alpa')->count();
                                                $terlambat = $stats->where('terlambat', '>', 0)->count();
                                                $pulangCepat = $stats->where('pulang_cepat', '>', 0)->count();

                                                // TODO: Also count PengajuanIzin if approved but not synced to Presensi table yet,
                                                // but assume SYNC happens upon approval as implemented in Controller.

                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $pegawai->nama_lengkap }}</td>
                                                <td class="text-success font-weight-bold">{{ $hadir }}</td>
                                                <td class="text-warning">{{ $sakit }}</td>
                                                <td class="text-info">{{ $izin }}</td>
                                                <td class="text-danger">{{ $alpa }}</td>
                                                <td>{{ $terlambat }}</td>
                                                <td>{{ $pulangCepat }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-info"><i
                                                            class="fas fa-search"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
            $('#summaryTable').DataTable();
        });
    </script>
</body>

</html>
