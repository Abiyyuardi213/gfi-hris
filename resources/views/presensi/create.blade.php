<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Form Absensi</title>
    <link rel="icon" type="image/png" href="{{ asset('image/dropcore-icon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap"
        rel="stylesheet">
    <style>
        #my_camera {
            width: 100%;
            height: 300px;
            border: 1px solid black;
        }

        @media(max-width: 600px) {
            #my_camera {
                height: 250px;
            }
        }
    </style>
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
                            <h1>Absensi</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card card-outline card-primary">
                                <div class="card-header text-center">
                                    <h3>{{ \Carbon\Carbon::now()->format('l, d F Y') }}</h3>
                                    <h1 id="clock" class="font-weight-bold"></h1>
                                </div>
                                <div class="card-body">

                                    @if ($hariLibur)
                                        <div class="alert alert-warning text-center">
                                            Hari ini adalah hari libur: <strong>{{ $hariLibur->nama_libur }}</strong>
                                        </div>
                                    @endif

                                    <div class="row justify-content-center mb-3">
                                        <div class="col-12 text-center">
                                            <div id="my_camera"></div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="lokasi">
                                    <input type="hidden" id="foto">

                                    <div class="row">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-primary btn-block btn-lg"
                                                onclick="take_snapshot('in')"
                                                {{ $presensi && $presensi->jam_masuk ? 'disabled' : '' }}>
                                                <i class="fas fa-sign-in-alt"></i> Absen Masuk
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button type="button" class="btn btn-danger btn-block btn-lg"
                                                onclick="take_snapshot('out')"
                                                {{ !$presensi || ($presensi && $presensi->jam_pulang) ? 'disabled' : '' }}>
                                                <i class="fas fa-sign-out-alt"></i> Absen Pulang
                                            </button>
                                        </div>
                                    </div>

                                    <div class="table-responsive mt-4">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Jam Masuk</th>
                                                <td colspan="2" class="text-center">
                                                    {{ $presensi && $presensi->jam_masuk ? \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') : '--:--' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Jam Pulang</th>
                                                <td colspan="2" class="text-center">
                                                    {{ $presensi && $presensi->jam_pulang ? \Carbon\Carbon::parse($presensi->jam_pulang)->format('H:i') : '--:--' }}
                                                </td>
                                            </tr>
                                        </table>
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

    <!-- Webcam.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script language="JavaScript">
        // Clock
        setInterval(() => {
            let now = new Date();
            let timeString = now.toLocaleTimeString('en-GB', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById("clock").innerText = timeString;
        }, 1000);

        // Webcam
        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach('#my_camera');

        // Geolocation
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('lokasi').value = position.coords.latitude + "," + position.coords
                    .longitude;
            }, function(error) {
                Swal.fire('Error', 'Gagal mendapatkan lokasi. Pastikan GPS aktif.', 'error');
            });
        } else {
            alert("Geolocation tidak didukung oleh browser ini.");
        }

        function take_snapshot(type) {
            // Validate Location
            let lokasi = document.getElementById('lokasi').value;
            if (!lokasi) {
                Swal.fire('Error', 'Lokasi belum terdeteksi. Tunggu sebentar atau refresh halaman.', 'error');
                return;
            }

            Webcam.snap(function(data_uri) {
                let url = (type === 'in') ? "{{ route('presensi.store') }}" : "{{ route('presensi.checkOut') }}";

                // Submit via Ajax
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        foto: data_uri,
                        lokasi: lokasi
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
                    }
                });
            });
        }
    </script>
</body>

</html>
