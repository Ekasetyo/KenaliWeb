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
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/admin/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Data Master -->
    <li
        class="nav-item {{ request()->is('admin/data-artikel') || request()->is('admin/data-saran') || request()->is('admin/data-user') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDataMaster"
            aria-expanded="true" aria-controls="collapseDataMaster">
            <i class="fas fa-fw fa-database"></i>
            <span>Data Master</span>
        </a>
        <div id="collapseDataMaster"
            class="collapse {{ request()->is('admin/data-artikel') || request()->is('admin/data-saran') || request()->is('admin/data-user') ? 'show' : '' }}"
            aria-labelledby="headingDataMaster" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Submenu Data Master:</h6>
                <a class="collapse-item {{ request()->is('admin/data-artikel') ? 'active' : '' }}"
                    href="{{ route('admin.data-artikel') }}"
                    style="{{ request()->is('admin/data-artikel') ? 'color: #22937c;' : '' }}">Data Artikel</a>
                <a class="collapse-item {{ request()->is('admin/data-saran') ? 'active' : '' }}"
                    href="{{ route('admin.data-saran') }}"
                    style="{{ request()->is('admin/data-saran') ? 'color: #22937c;' : '' }}">Data Saran</a>
                <a class="collapse-item {{ request()->is('admin/data-user') ? 'active' : '' }}"
                    href="{{ route('admin.data-user') }}"
                    style="{{ request()->is('admin/user') ? 'color: #22937c;' : '' }}">Data User</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/hasil-prediksi') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Hasil Prediksi</span>
        </a>
    </li>

    <!-- Nav Item - Riwayat -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/laporan') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Laporan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/visualisasi') }}">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Visualisasi</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/dashboard/riwayat') }}">
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
