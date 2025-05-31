<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Bagian Tanggal dan Waktu -->
    <div class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100">
        <div class="text-gray-600 font-weight-bold">
            <span id="live-date"></span> | <span id="live-clock"></span>
        </div>
    </div>
    
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ session('user')['name'] ?? 'Guest' }}</span>
                <img class="img-profile rounded-circle"
                     src="https://ui-avatars.com/api/?name={{ urlencode(session('user')['name'] ?? 'Guest') }}&background=random"
                     width="40" height="40">
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                {{-- Hanya tampilkan ubah password untuk admin --}}
                @if(session('user') && strtolower(session('user')['status']) === 'admin')
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changePasswordModal">
                        <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i> Ubah Password
                    </a>
                    <div class="dropdown-divider"></div>
                @endif
               <a class="dropdown-item" href="{{ route('logout') }}">
    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
</a>

            </div>
        </li>
    </ul>
</nav>

{{-- Modal Ubah Password untuk Admin --}}
@if(session('user') && strtolower(session('user')['status']) === 'admin')
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Ubah Password</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    @if(session('success_password'))
                        <div class="alert alert-success">{{ session('success_password') }}</div>
                    @endif

                    @if(session('error_password'))
                        <div class="alert alert-danger">{{ session('error_password') }}</div>
                    @endif

                    @if($errors->has('current_password') || $errors->has('new_password'))
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label>Password Lama</label>
                        <input type="password" name="current_password" class="form-control" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="new_password" class="form-control" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                   <button type="submit" class="btn btn-primary" id="btnUpdatePassword">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Script untuk memperbarui tanggal dan waktu -->
<script>
    function updateDateTime() {
        const now = new Date();
        
        // Format tanggal: "Sabtu, 31 Mei 2025"
        const dateOptions = { 
            weekday: 'long',  // Menambahkan nama hari
            day: 'numeric', 
            month: 'long', 
            year: 'numeric' 
        };
        const dateElement = document.getElementById('live-date');
        if (dateElement) {
            dateElement.textContent = now.toLocaleDateString('id-ID', dateOptions);
        }

        // Format waktu: "13:43" (tanpa detik)
        const timeOptions = { 
            hour: '2-digit', 
            minute: '2-digit', 
            hour12: false // Menggunakan format 24 jam
        };
        const clockElement = document.getElementById('live-clock');
        if (clockElement) {
            clockElement.textContent = now.toLocaleTimeString('id-ID', timeOptions);
        }
    }

    // Perbarui setiap detik
    setInterval(updateDateTime, 1000);
    
    // Panggil sekali saat halaman dimuat
    updateDateTime();
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector('#changePasswordModal form');
        const submitBtn = document.getElementById('btnUpdatePassword');

        if (form && submitBtn) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Konfirmasi Ubah Password',
                    text: 'Apakah Anda yakin ingin memperbarui password?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, ubah!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        }

        // Notifikasi sukses
        @if(session('success_password'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session("success_password") }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
        @endif

        // Notifikasi gagal
        @if(session('error_password'))
        Swal.fire({
            title: 'Gagal!',
            text: '{{ session("error_password") }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        @endif
    });
</script>
