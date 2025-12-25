<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>

        <!-- Dropdown user dipindah ke kiri -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-expanded="false">
                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                <small>({{ Auth::user()->role->role_name ?? '-' }})</small>
            </a>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                <li>
                    <a class="dropdown-item" href="{{ url('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('profile.index') }}">
                        <i class="fas fa-user"></i> Profile
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </li>
    </ul>

    <!-- Right navbar links (Notifications) -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" id="notifDropdownToggle">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge" id="notif-count" style="display:none;">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notif-list-container">
                <span class="dropdown-item dropdown-header">Memuat notifikasi...</span>
            </div>
        </li>
    </ul>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Simple polling for unread count every 30 seconds
            function updateNotifCount() {
                fetch('{{ route('notifications.count') }}')
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.getElementById('notif-count');
                        if (data.count > 0) {
                            badge.innerText = data.count;
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none';
                        }
                    })
                    .catch(err => console.error('Notif error:', err));
            }

            // Initial call
            updateNotifCount();
            setInterval(updateNotifCount, 30000); // 30 seconds polling

            // Lazy load list on click
            document.getElementById('notifDropdownToggle').addEventListener('click', function() {
                fetch('{{ route('notifications.list') }}')
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('notif-list-container').innerHTML = html;
                    });
            });
        });
    </script>
</nav>
