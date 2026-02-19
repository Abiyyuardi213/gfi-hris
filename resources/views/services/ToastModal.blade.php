<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: "{!! session('success') !!}"
            });
        @endif

        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: "{!! session('error') !!}"
            });
        @endif

        @if (session('warning'))
            Toast.fire({
                icon: 'warning',
                title: "{!! session('warning') !!}"
            });
        @endif
    });
</script>

<!-- Dummy element untuk mencegah error JS pada file yang masih memanggil $('#toastNotification').toast('show') -->
<div id="toastNotification" class="toast" style="display:none;"></div>
<div id="toast-body" style="display:none;"></div>
