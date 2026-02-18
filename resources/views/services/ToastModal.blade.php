<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{!! session('success') !!}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{!! session('error') !!}",
                showConfirmButton: true
            });
        @endif

        @if (session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: "{!! session('warning') !!}",
                showConfirmButton: true
            });
        @endif
    });
</script>

<!-- Dummy element untuk mencegah error JS pada file yang masih memanggil $('#toastNotification').toast('show') -->
<div id="toastNotification" class="toast" style="display:none;"></div>
<div id="toast-body" style="display:none;"></div>
