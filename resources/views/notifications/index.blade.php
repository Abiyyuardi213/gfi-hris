<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFI HRIS - Notifikasi Saya</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
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
                            <h1>Inbox Notifikasi</h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <form action="{{ route('notifications.markAllRead') }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-check-double"></i>
                                    Tandai Semua Dibaca</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                        @forelse($notifications as $n)
                                            <tr class="{{ $n->read_at ? '' : 'font-weight-bold bg-light' }}">
                                                <td class="mailbox-star" width="50">
                                                    @if (str_contains($n->type, 'Izin'))
                                                        <i class="fas fa-file-medical text-warning"></i>
                                                    @elseif(str_contains($n->type, 'Lembur'))
                                                        <i class="fas fa-clock text-info"></i>
                                                    @elseif(str_contains($n->type, 'Dinas'))
                                                        <i class="fas fa-plane text-success"></i>
                                                    @elseif(str_contains($n->type, 'Payroll'))
                                                        <i class="fas fa-money-bill text-success"></i>
                                                    @else
                                                        <i class="fas fa-bell text-secondary"></i>
                                                    @endif
                                                </td>
                                                <td class="mailbox-name">
                                                    {{ $n->data['title'] ?? 'Notifikasi System' }}
                                                </td>
                                                <td class="mailbox-subject">
                                                    {{ $n->data['message'] ?? '-' }}
                                                </td>
                                                <td class="mailbox-date text-right">
                                                    {{ $n->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center p-5 text-muted">Tidak ada
                                                    notifikasi.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer p-0">
                            <div class="mailbox-controls">
                                <div class="float-right">
                                    {{ $notifications->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @include('include.footerSistem')
    </div>
</body>

</html>
