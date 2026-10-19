<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('adminlte3/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle">
        <span class="brand-text font-weight-light">Souko-APP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ auth()->user()->role === 'Admin' ? route('admin.dashboard') : route('dashboard') }}"
                        wire:navigate
                        class="nav-link {{ request()->routeIs('dashboard', 'admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @if (auth()->user()->role === 'Super Admin')
                    <li class="nav-header">Super Admin</li>
                    <li class="nav-item">
                        <a href="{{ route('superadmin.user.index') }}" wire:navigate
                            class="nav-link {{ request()->routeIs('superadmin.user.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>User</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('superadmin.kategori.index') }}" wire:navigate
                            class="nav-link {{ request()->routeIs('superadmin.kategori.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Kategori</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('superadmin.barang.index') }}" wire:navigate
                            class="nav-link {{ request()->routeIs('superadmin.barang.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Barang</p>
                        </a>
                    </li>
                @else
                    <li class="nav-header">Admin</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.barang.index') }}" wire:navigate
                            class="nav-link {{ request()->routeIs('admin.barang.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Barang</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
