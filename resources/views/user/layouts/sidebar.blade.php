<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #22937c;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('dashboard-assets/img/logo_putih.png') }}" alt="Logo" style="height: 30px;">
        </div>
        <div class="sidebar-brand-text mx-3">Kenali</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('user/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/user/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

   

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ request()->is('user/konsultasi') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/user/konsultasi') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Konsultasi</span>
        </a>
    </li>

    <!-- Nav Item - Laporan -->
    <li class="nav-item {{ request()->is('user/riwayat-deteksi') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/user/riwayat-deteksi') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Riwayat Deteksi</span>
        </a>
    </li>

    <!-- Nav Item - Logout -->
    <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}">
        <button type="submit" class="nav-link btn btn-link logout-button focus:outline-none focus:ring-0" style="color: white; text-align: left;">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </button>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>