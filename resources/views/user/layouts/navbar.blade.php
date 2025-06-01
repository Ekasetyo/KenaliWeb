<!-- Topbar - Enhanced Styling -->
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
                     src="https://ui-avatars.com/api/?name={{ urlencode(session('user')['name'] ?? 'Guest') }}&background=random&size=128"
                     width="40" height="40" alt="Profile">
            </a>
            <!-- Dropdown Menu -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown" style="border: none;">
                @if(session('user') && strtolower(session('user')['status']) === 'user')
                    <a class="dropdown-item d-flex align-items-center" href="#" data-toggle="modal" data-target="#profileSettingsModal">
                        <i class="fas fa-user-cog fa-sm fa-fw mr-2 text-primary"></i> 
                        <span>Profile Settings</span>
                    </a>
                    <div class="dropdown-divider"></div>
                @endif
                <!-- Fixed Logout (POST method) -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <a class="dropdown-item d-flex align-items-center" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i>
                    <span>Logout</span>
                </a>
            </div>
        </li>
    </ul>
</nav>

@if(session('user') && strtolower(session('user')['status']) === 'user')
<!-- Profile Settings Modal - Enhanced Styling -->
<div class="modal fade" id="profileSettingsModal" tabindex="-1" aria-labelledby="profileSettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title font-weight-bold" id="profileSettingsModalLabel">
                    <i class="fas fa-user-cog mr-2"></i>Pengaturan Profil
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-0">
                <ul class="nav nav-tabs nav-fill border-bottom-0" id="profileTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active py-3" id="edit-profile-tab" data-toggle="tab" href="#edit-profile" role="tab">
                            <i class="fas fa-user-edit mr-2"></i>Edit Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-3" id="change-password-tab" data-toggle="tab" href="#change-password" role="tab">
                            <i class="fas fa-key mr-2"></i>Ganti Password
                        </a>
                    </li>
                </ul>

                <div class="tab-content px-4 pt-4 pb-3 border-left border-right border-bottom rounded-bottom">
                    <!-- Edit Profile Tab -->
                    <div class="tab-pane fade show active" id="edit-profile" role="tabpanel">
                        <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
                            @csrf
                            @method('PUT')

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <ul class="mb-0 pl-3">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label font-weight-bold">Nama</label>
                                <div class="col-md-9">
                                    <input type="text" name="name" class="form-control border-primary" required
                                           value="{{ old('name', session('user')['name'] ?? '') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label font-weight-bold">Email</label>
                                <div class="col-md-9">
                                    <input type="email" name="email" class="form-control border-primary" required
                                           value="{{ old('email', session('user')['email'] ?? '') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label font-weight-bold">Jenis Kelamin</label>
                                <div class="col-md-9">
                                    <select class="form-control border-primary" name="jenis_kelamin">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', session('user')['jenis_kelamin'] ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', session('user')['jenis_kelamin'] ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label font-weight-bold">Tanggal Lahir</label>
                                <div class="col-md-9">
                                    <input type="date" name="tanggal_lahir" class="form-control border-primary"
                                           value="{{ old('tanggal_lahir', session('user')['tanggal_lahir'] ?? '') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label font-weight-bold">No Telepon</label>
                                <div class="col-md-9">
                                    <input type="tel" name="no_telepon" class="form-control border-primary"
                                           value="{{ old('no_telepon', session('user')['no_telepon'] ?? '') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label font-weight-bold">Status</label>
                                <div class="col-md-9">
                                    <input type="text" name="status" class="form-control bg-light"
                                           value="{{ old('status', session('user')['status'] ?? '') }}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label font-weight-bold">Alamat</label>
                                <div class="col-md-9">
                                    <textarea name="alamat" class="form-control border-primary" rows="3">{{ old('alamat', session('user')['alamat'] ?? '') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row mb-0 mt-4">
                                <div class="col-md-9 offset-md-3">
                                   <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold" id="btnSaveProfile">
                                       <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                   </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Change Password Tab -->
                    <div class="tab-pane fade" id="change-password" role="tabpanel">
                        <form method="POST" action="{{ route('password.update') }}" id="passwordForm">
                            @csrf
                            @method('PUT')

                            @if(session('success_password'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ session('success_password') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if(session('error_password'))
                                <div class="alert alert-danger alert-dismissible fade show">
                                    {{ session('error_password') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if($errors->has('current_password') || $errors->has('new_password'))
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <ul class="mb-0 pl-3">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label font-weight-bold">Password Lama</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="password" name="current_password" class="form-control border-primary" required autocomplete="off" id="currentPassword">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#currentPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label font-weight-bold">Password Baru</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="password" name="new_password" class="form-control border-primary" required autocomplete="off" id="newPassword">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#newPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <small class="text-muted">Minimal 8 karakter</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label font-weight-bold">Konfirmasi Password</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="password" name="new_password_confirmation" class="form-control border-primary" required autocomplete="off" id="confirmPassword">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#confirmPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0 mt-4">
                                <div class="col-md-9 offset-md-3">
                                    <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold" id="btnUpdatePassword">
                                        <i class="fas fa-key mr-2"></i>Update Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Live Date and Time - Enhanced
function updateDateTime() {
    const now = new Date();
    const options = { 
        weekday: 'long', 
        day: 'numeric', 
        month: 'long', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
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
    // Password toggle
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

    // Form Submission Handling
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Simpan Perubahan Profil?',
                text: 'Anda yakin ingin menyimpan perubahan profil?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fas fa-save mr-2"></i>Ya, Simpan!',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    }

    const passwordForm = document.getElementById('passwordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Ganti Password?',
                text: 'Anda yakin ingin mengubah password Anda?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fas fa-key mr-2"></i>Ya, Ganti!',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    }

    // Show success/error messages
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        timer: 3000,
        showConfirmButton: false
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session("error") }}',
        confirmButtonText: 'OK'
    });
    @endif
});
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
        color: #4e73df;
    }
    
    .nav-tabs .nav-link {
        color: #6c757d;
        font-weight: 500;
        border: none;
        position: relative;
    }
    
    .nav-tabs .nav-link.active {
        color: #4e73df;
        background-color: transparent;
        border: none;
    }
    
    .nav-tabs .nav-link.active:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background-color: #4e73df;
    }
    
    .border-primary {
        border-color: #d1d3e2 !important;
    }
    
    .border-primary:focus {
        border-color: #4e73df !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
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
</style>