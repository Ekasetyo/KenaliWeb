<!-- Top Navigation Bar - Admin -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow" style="position: sticky; top: 0; z-index: 1020;">
    <!-- Sidebar Toggle Button -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars text-gray-600"></i>
    </button>
    
    <!-- Date and Time Display -->
    <div class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100">
        <div class="text-gray-600 font-weight-bold" style="font-size: 0.9rem;">
            <i class="far fa-calendar-alt mr-1"></i><span id="live-date"></span> 
            <i class="far fa-clock ml-2 mr-1"></i><span id="live-clock"></span>
        </div>
    </div>

    <!-- User Dropdown -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small" style="font-weight: 500;">{{ session('user')['name'] ?? 'Guest' }}</span>
                <img class="img-profile rounded-circle shadow-sm"
                     src="https://ui-avatars.com/api/?name={{ urlencode(session('user')['name'] ?? 'Guest') }}&background=4e73df&color=fff&size=128"
                     width="40" height="40" alt="Profile">
            </a>
            <!-- Dropdown Menu -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown" style="border: none;">
                <div class="dropdown-header bg-gradient-primary text-white py-3">
                    <h6 class="m-0 font-weight-bold">{{ session('user')['name'] ?? 'Guest' }}</h6>
                    <small class="text-white-50">{{ ucfirst(session('user')['status'] ?? 'User') }}</small>
                </div>
                <div class="dropdown-divider"></div>
                
                @if(session('user') && strtolower(session('user')['status']) === 'admin')
                    <a class="dropdown-item d-flex align-items-center" href="#" data-toggle="modal" data-target="#changePasswordModal">
                        <i class="fas fa-key fa-sm fa-fw mr-2 text-primary"></i> 
                        <span>Ubah Password</span>
                    </a>
                    <div class="dropdown-divider"></div>
                @endif
                
                <a class="dropdown-item d-flex align-items-center" href="#" onclick="event.preventDefault(); confirmLogout()">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i>
                    <span>Logout</span>
                </a>
                
                <!-- Hidden logout form -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>

<!-- Change Password Modal (Admin Only) -->
@if(session('user') && strtolower(session('user')['status']) === 'admin')
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-key mr-2"></i>Ubah Password
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('password.update') }}" id="passwordForm">
                @csrf
                @method('PUT')

                <div class="modal-body py-4">
                    @if(session('success_password'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success_password') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error_password'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error_password') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="font-weight-bold">Password Lama</label>
                        <div class="input-group">
                            <input type="password" name="current_password" class="form-control border-primary" required 
                                   placeholder="Masukkan password saat ini" id="currentPassword">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#currentPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="font-weight-bold">Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="new_password" class="form-control border-primary" required 
                                   placeholder="Masukkan password baru" id="newPassword">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#newPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted">Minimal 8 karakter</small>
                    </div>
                    
                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" name="new_password_confirmation" class="form-control border-primary" required 
                                   placeholder="Konfirmasi password baru" id="confirmPassword">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#confirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold" id="btnUpdatePassword">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Live Date and Time
function updateDateTime() {
    const now = new Date();
    const options = { 
        weekday: 'long', 
        day: 'numeric', 
        month: 'long', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
    };
    
    const dateTimeStr = now.toLocaleDateString('id-ID', options).replace(' pukul', ' |');
    document.getElementById('live-date').textContent = dateTimeStr.split(' |')[0];
    document.getElementById('live-clock').textContent = dateTimeStr.split(' |')[1];
}

setInterval(updateDateTime, 1000);
updateDateTime();

// Toggle Password Visibility
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const target = this.getAttribute('data-target');
            const input = document.querySelector(target);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
});

// Logout confirmation
function confirmLogout() {
    Swal.fire({
        title: 'Konfirmasi Logout',
        text: 'Anda yakin ingin keluar dari sistem?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#4e73df',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    });
}

// Password form submission
const passwordForm = document.getElementById('passwordForm');
if (passwordForm) {
    passwordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Perubahan Password',
            text: 'Anda yakin ingin mengubah password?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4e73df',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Ubah Password',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
                document.getElementById('btnUpdatePassword').disabled = true;
                document.getElementById('btnUpdatePassword').innerHTML = 
                    '<span class="spinner-border spinner-border-sm mr-2" role="status"></span> Memproses...';
            }
        });
    });
}

// Show success/error messages
@if(session('success_password'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session("success_password") }}',
    timer: 3000,
    showConfirmButton: false
});
@endif

@if(session('error_password'))
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '{{ session("error_password") }}',
    confirmButtonText: 'OK'
});
@endif
</script>

<style>
    /* Custom Styles */
    .topbar {
        min-height: 4.375rem;
    }
    
    .img-profile {
        border: 2px solid #e3e6f0;
        transition: all 0.3s ease;
    }
    
    .img-profile:hover {
        border-color: #4e73df;
    }
    
    .dropdown-item {
        padding: 0.5rem 1.5rem;
        transition: all 0.2s;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fc;
        color: #4e73df !important;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    
    .toggle-password {
        border-color: #d1d3e2;
    }
    
    .toggle-password:hover {
        background-color: #f8f9fc;
    }
    
    .modal-content {
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .border-primary {
        border-color: #d1d3e2 !important;
    }
    
    .border-primary:focus {
        border-color: #4e73df !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
</style>