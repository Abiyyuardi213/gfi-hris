<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Presensi {{ $tanggal }}</title>
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
                            <h1>Data Presensi Harian</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <form method="GET" action="{{ route('presensi.index') }}" class="form-inline">
                                <div class="form-group mr-2">
                                    <label for="tanggal" class="mr-2">Tanggal:</label>
                                    <input type="date" name="tanggal" class="form-control"
                                        value="{{ $tanggal }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </form>
                        </div>
                        <div class="card-body">
                            <table id="presensiTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Pegawai</th>
                                        <th>Shift</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Status</th>
                                        <th>Terlambat</th>
                                        <th>Lokasi</th>
                                        <th>Foto</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($presensis as $p)
                                        <tr>
                                            <td>{{ $p->pegawai->nama_lengkap }} <br>
                                                <small>{{ $p->pegawai->nip }}</small>
                                            </td>
                                            <td>{{ $p->shiftKerja->nama_shift ?? ($p->pegawai->shiftKerja->nama_shift ?? '-') }}
                                            </td>
                                            <td>{{ $p->jam_masuk ? $p->jam_masuk->format('H:i') : '-' }}</td>
                                            <td>{{ $p->jam_pulang ? $p->jam_pulang->format('H:i') : '-' }}</td>
                                            <td>
                                                @if ($p->status == 'Hadir')
                                                    <span class="badge badge-success">Hadir</span>
                                                @elseif($p->status == 'Sakit')
                                                    <span class="badge badge-warning">Sakit</span>
                                                @elseif($p->status == 'Izin')
                                                    <span class="badge badge-info">Izin</span>
                                                @else
                                                    <span class="badge badge-danger">{{ $p->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($p->terlambat > 0)
                                                    <span class="badge badge-danger">{{ $p->terlambat }} menit</span>
                                                @else
                                                    <span class="badge badge-success">Tepat Waktu</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($p->lokasi_masuk)
                                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $p->lokasi_masuk }}"
                                                        target="_blank" class="btn btn-xs btn-outline-primary"><i
                                                            class="fas fa-map-marker-alt"></i> Masuk</a>
                                                @endif
                                                @if ($p->lokasi_pulang)
                                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $p->lokasi_pulang }}"
                                                        target="_blank" class="btn btn-xs btn-outline-danger"><i
                                                            class="fas fa-map-marker-alt"></i> Pulang</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($p->foto_masuk)
                                                    <img src="{{ asset('storage/' . $p->foto_masuk) }}" width="40"
                                                        height="40" class="img-circle" style="object-fit:cover"
                                                        data-toggle="modal"
                                                        data-target="#modalFoto{{ $p->id }}">

                                                    <!-- Modal Preview Foto -->
                                                    <div class="modal fade" id="modalFoto{{ $p->id }}"
                                                        tabindex="-1">
                                                        <div class="modal-dialog modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-body text-center">
                                                                    <p><strong>Masuk</strong></p>
                                                                    <img src="{{ asset('storage/' . $p->foto_masuk) }}"
                                                                        class="img-fluid mb-2">
                                                                    @if ($p->foto_pulang)
                                                                        <hr>
                                                                        <p><strong>Pulang</strong></p>
                                                                        <img src="{{ asset('storage/' . $p->foto_pulang) }}"
                                                                            class="img-fluid">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" data-toggle="modal"
                                                    data-target="#modalValidasi{{ $p->id }}">
                                                    <i class="fas fa-edit"></i> Validasi
                                                </button>

                                                <!-- Modal Validasi -->
                                                <div class="modal fade" id="modalValidasi{{ $p->id }}"
                                                    tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-warning">
                                                                <h5 class="modal-title">Validasi Absensi:
                                                                    {{ $p->pegawai->nama_lengkap }}</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <form action="{{ route('presensi.update', $p->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label>Status</label>
                                                                        <select name="status" class="form-control">
                                                                            <option value="Hadir"
                                                                                {{ $p->status == 'Hadir' ? 'selected' : '' }}>
                                                                                Hadir</option>
                                                                            <option value="Sakit"
                                                                                {{ $p->status == 'Sakit' ? 'selected' : '' }}>
                                                                                Sakit</option>
                                                                            <option value="Izin"
                                                                                {{ $p->status == 'Izin' ? 'selected' : '' }}>
                                                                                Izin</option>
                                                                            <option value="Alpa"
                                                                                {{ $p->status == 'Alpa' ? 'selected' : '' }}>
                                                                                Alpa</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Jam Masuk</label>
                                                                        <input type="time" name="jam_masuk"
                                                                            class="form-control"
                                                                            value="{{ $p->jam_masuk ? $p->jam_masuk->format('H:i') : '' }}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Jam Pulang</label>
                                                                        <input type="time" name="jam_pulang"
                                                                            class="form-control"
                                                                            value="{{ $p->jam_pulang ? $p->jam_pulang->format('H:i') : '' }}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Catatan / Keterangan</label>
                                                                        <textarea name="keterangan" class="form-control" rows="2">{{ $p->keterangan }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Batal</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Simpan
                                                                        Perubahan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
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
            $('#presensiTable').DataTable();

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
