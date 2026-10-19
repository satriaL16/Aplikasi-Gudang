<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle user-profile-toggle" data-toggle="dropdown"
                aria-label="Menu akun {{ auth()->user()->nama }}">
                <img src="{{ asset('adminlte3/dist/img/user2-160x160.jpg') }}" class="user-image img-circle"
                    alt="Foto profil {{ auth()->user()->nama }}">
                <span class="d-none d-md-inline user-profile-toggle-name">{{ auth()->user()->nama }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right user-profile-dropdown">
                <li class="user-header user-profile-header">
                    <img src="{{ asset('adminlte3/dist/img/user2-160x160.jpg') }}"
                        class="img-circle user-profile-avatar" alt="Foto profil {{ auth()->user()->nama }}">
                    <div class="user-profile-info">
                        <strong class="user-profile-name">
                            {{ auth()->user()->nama }}
                        </strong>
                        <span class="user-profile-email">{{ auth()->user()->email }}</span>
                        <span class="user-profile-role">
                            <i class="fas fa-shield-alt"></i>
                            {{ auth()->user()->role }}
                        </span>
                    </div>
                </li>
                <li class="user-footer">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn user-profile-logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Keluar dari akun</span>
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
