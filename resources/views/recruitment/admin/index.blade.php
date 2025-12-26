<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRIS-GFI - Kandidat / Pelamar</title>

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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Manajemen Kandidat / Pelamar</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Pendaftar Baru & Kandidat</h3>
                        </div>
                        <div class="card-body">
                            <table id="tableKandidat" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal Daftar</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Pendidikan</th>
                                        <th>Berkas</th>
                                        <th>Status Akun</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kandidats as $k)
                                        <tr>
                                            <td>{{ $k->created_at->format('d M Y H:i') }}</td>
                                            <td>{{ $k->user->name ?? '-' }}</td>
                                            <td>{{ $k->user->email ?? '-' }}</td>
                                            <td>{{ $k->pendidikan_terakhir }}</td>
                                            <td>
                                                @if ($k->file_cv)
                                                    <a href="{{ asset('storage/' . $k->file_cv) }}" target="_blank"
                                                        class="btn btn-xs btn-info"><i class="fas fa-file-pdf"></i>
                                                        CV</a>
                                                @endif
                                                @if ($k->file_ktp)
                                                    <a href="{{ asset('storage/' . $k->file_ktp) }}" target="_blank"
                                                        class="btn btn-xs btn-info"><i class="fas fa-id-card"></i>
                                                        KTP</a>
                                                @endif
                                                @if ($k->file_ijazah)
                                                    <a href="{{ asset('storage/' . $k->file_ijazah) }}" target="_blank"
                                                        class="btn btn-xs btn-secondary"><i
                                                            class="fas fa-graduation-cap"></i> Ijazah</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($k->user && $k->user->status)
                                                    <span class="badge badge-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-warning">Menunggu Validasi</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($k->user && !$k->user->status)
                                                    <form action="{{ route('recruitment.admin.approve', $k->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        <button onclick="return confirm('Setujui akun ini?')"
                                                            class="btn btn-sm btn-success"
                                                            title="Approve / Aktifkan Akun"><i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('recruitment.admin.reject', $k->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        <button onclick="return confirm('Tolak akun ini?')"
                                                            class="btn btn-sm btn-danger" title="Tolak / Hapus"><i
                                                                class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-sm btn-secondary" disabled>Sudah
                                                        Disetujui</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <!-- DataTables will handle empty state, but good for custom view if not using JS -->
                                    @endforelse
                                </tbody>
                            </table>
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
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(function() {
            $("#tableKandidat").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            });
        });
    </script>
</body>

</html>
