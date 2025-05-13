<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Tanggal dan Jam Live -->
    <div class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100">
        <div class="text-gray-600 font-weight-bold">
            <span id="live-date"></span> | 
            <span id="live-clock"></span>
        </div>
    </div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ session('user.name') }}</span>
                <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?name={{ urlencode(session('user.name')) }}&background=random" width="40" height="40">
            </a>
        </li>
    </ul>
</nav>
<!-- End of Topbar -->