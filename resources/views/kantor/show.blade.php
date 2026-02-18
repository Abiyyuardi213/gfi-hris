<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kantor</title>

    <link rel="icon" type="image/png" href="{{ asset('image/dropcore-icon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap"
        rel="stylesheet">
    <!-- Leaflet CSS for Maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('include.navbarSistem')
        @include('include.sidebar')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Detail Kantor</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Left Column: Info -->
                        <div class="col-md-5">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <h3 class="profile-username text-center">{{ $kantor->nama_kantor }}</h3>
                                    <p class="text-muted text-center">{{ $kantor->tipe_kantor }}</p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Status</b>
                                            <a class="float-right">
                                                @if ($kantor->status)
                                                    <span class="badge badge-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-danger">Nonaktif</span>
                                                @endif
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Kota/Area</b> <a class="float-right">{{ $kantor->kota->kota ?? '-' }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Telepon</b> <a class="float-right">{{ $kantor->no_telp ?? '-' }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Email</b> <a class="float-right">{{ $kantor->email ?? '-' }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Kode Kantor</b> <a class="float-right">{{ $kantor->kode_kantor }}</a>
                                        </li>
                                    </ul>

                                    <a href="{{ route('kantor.edit', $kantor->id) }}"
                                        class="btn btn-primary btn-block"><b>Edit Kantor</b></a>
                                    <a href="{{ route('kantor.index') }}"
                                        class="btn btn-default btn-block"><b>Kembali</b></a>
                                </div>
                            </div>

                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Alamat</h3>
                                </div>
                                <div class="card-body">
                                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Lokasi</strong>
                                    <p class="text-muted">{{ $kantor->alamat }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Map -->
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Lokasi Peta (Titik Absensi)</h3>
                                </div>
                                <div class="card-body p-0">
                                    @if ($kantor->latitude && $kantor->longitude)
                                        <div id="map" style="height: 400px; width: 100%;"></div>
                                    @else
                                        <div class="p-5 text-center text-muted">
                                            <i class="fas fa-map-marked-alt fa-3x mb-3"></i>
                                            <p>Koordinat belum diatur.</p>
                                        </div>
                                    @endif
                                </div>
                                @if ($kantor->latitude && $kantor->longitude)
                                    <div class="card-footer">
                                        <small class="text-muted">Radius Absensi: <strong>{{ $kantor->radius }}
                                                Meter</strong></small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @include('include.footerSistem')
    </div>

    @include('services.LogoutModal')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        @if ($kantor->latitude && $kantor->longitude)
            var map = L.map('map').setView([{{ $kantor->latitude }}, {{ $kantor->longitude }}], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var marker = L.marker([{{ $kantor->latitude }}, {{ $kantor->longitude }}]).addTo(map)
                .bindPopup('<b>{{ $kantor->nama_kantor }}</b><br>Lokasi Absensi')
                .openPopup();

            var circle = L.circle([{{ $kantor->latitude }}, {{ $kantor->longitude }}], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.2,
                radius: {{ $kantor->radius }}
            }).addTo(map);
        @endif
    </script>
</body>

</html>
