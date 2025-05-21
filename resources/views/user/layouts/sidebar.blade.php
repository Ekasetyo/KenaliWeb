<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #22937c;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
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
    <li class="nav-item {{ request()->is('user/riwayat-prediksi') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/user/riwayat-prediksi') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Konsultasi</span>
        </a>
    </li>

    <!-- Nav Item - Laporan -->
    <li class="nav-item {{ request()->is('user/laporan-visualisasi') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/user/laporan-visualisasi') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Prediksi & Visualisasi</span>
        </a>
    </li>

    <!-- Nav Item - Logout -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/login') }}">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>