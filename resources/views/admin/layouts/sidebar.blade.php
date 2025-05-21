<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #22937c;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('dashboard-assets/img/logo_putih.png') }}" alt="Logo" style="height: 30px;">
        </div>
        <div class="sidebar-brand-text mx-3">Kenali</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Nav Item - Data Master -->
    <li class="nav-item {{ request()->routeIs('admin.artikel.index') || request()->routeIs('admin.user.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDataMaster"
            aria-expanded="{{ request()->routeIs('admin.artikel.index') || request()->routeIs('admin.user.index') ? 'true' : 'false' }}"
            aria-controls="collapseDataMaster">
            <i class="fas fa-fw fa-database"></i>
            <span>Data Master</span>
        </a>
        <div id="collapseDataMaster"
            class="collapse {{ request()->routeIs('admin.artikel.index') || request()->routeIs('admin.user.index') ? 'show' : '' }}"
            aria-labelledby="headingDataMaster" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Submenu Data Master:</h6>
                <a class="collapse-item {{ request()->routeIs('admin.artikel.index') ? 'active' : '' }}"
                   href="{{ route('admin.artikel.index') }}">Data Artikel</a>
                <a class="collapse-item {{ request()->routeIs('admin.user.index') ? 'active' : '' }}"
                   href="{{ route('admin.user.index') }}">Data User</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Hasil Prediksi -->
    <li class="nav-item {{ request()->routeIs('admin.hasil-prediksi') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.hasil-prediksi') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Hasil Prediksi</span>
        </a>
    </li>

    <!-- Nav Item - Konsultasi -->
    <li class="nav-item {{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.laporan') }}">
            <i class="fas fa-fw fa-comments"></i>
            <span>Konsultasi</span>
        </a>
    </li>

    <!-- Nav Item - Visualisasi -->
    <li class="nav-item {{ request()->routeIs('admin.visualisasi') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.visualisasi') }}">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Visualisasi</span>
        </a>
    </li>

    <!-- Nav Item - Logout -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
