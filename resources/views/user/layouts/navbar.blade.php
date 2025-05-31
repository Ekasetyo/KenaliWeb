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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</div>
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
                {{-- Tampilkan link pengaturan profil hanya untuk user dengan status 'user' --}}
                @if(session('user') && strtolower(session('user')['status']) === 'user')
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#profileSettingsModal">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile Settings
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

{{-- Tampilkan modal pengaturan profil hanya untuk user dengan status 'user' --}}
@if(session('user') && strtolower(session('user')['status']) === 'user')
<div class="modal fade" id="profileSettingsModal" tabindex="-1" aria-labelledby="profileSettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileSettingsModalLabel">Pengaturan Profil</h5>
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
            </div>

            <div class="modal-body">
                <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="edit-profile-tab" data-toggle="tab" href="#edit-profile" role="tab">Edit Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="change-password-tab" data-toggle="tab" href="#change-password" role="tab">Ganti Password</a>
                    </li>
                </ul>

                <div class="tab-content p-3 border border-top-0 rounded-bottom" id="profileTabsContent">
                    <div class="tab-pane fade show active" id="edit-profile" role="tabpanel">
                        <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
                            @csrf
                            @method('PUT')

                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Nama</label>
                                <div class="col-md-9">
                                    <input type="text" name="name" class="form-control" required
                                           value="{{ old('name', session('user')['name'] ?? '') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Email</label>
                                <div class="col-md-9">
                                    <input type="email" name="email" class="form-control" required
                                           value="{{ old('email', session('user')['email'] ?? '') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Jenis Kelamin</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="jenis_kelamin">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', session('user')['jenis_kelamin'] ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', session('user')['jenis_kelamin'] ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Tanggal Lahir</label>
                                <div class="col-md-9">
                                    <input type="date" name="tanggal_lahir" class="form-control"
                                           value="{{ old('tanggal_lahir', session('user')['tanggal_lahir'] ?? '') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">No Telepon</label>
                                <div class="col-md-9">
                                    <input type="tel" name="no_telepon" class="form-control"
                                           value="{{ old('no_telepon', session('user')['no_telepon'] ?? '') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Status</label>
                                <div class="col-md-9">
                                    <input type="text" name="status" class="form-control"
                                           value="{{ old('status', session('user')['status'] ?? '') }}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Alamat</label>
                                <div class="col-md-9">
                                    <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', session('user')['alamat'] ?? '') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-9 offset-md-3">
                                   <button type="submit" class="btn btn-primary" id="btnSaveProfile">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="change-password" role="tabpanel">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

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

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Password Lama</label>
                                <div class="col-md-9">
                                    <input type="password" name="current_password" class="form-control" required autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Password Baru</label>
                                <div class="col-md-9">
                                    <input type="password" name="new_password" class="form-control" required autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Konfirmasi Password</label>
                                <div class="col-md-9">
                                    <input type="password" name="new_password_confirmation" class="form-control" required autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-9 offset-md-3">
                                    <button type="submit" class="btn btn-primary" id="btnUpdatePassword">Update Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success') || session('error') || session('success_password') || session('error_password') || $errors->any())
<script>
    $(document).ready(function() {
        $('#profileSettingsModal').modal('show');

        @if($errors->has('current_password') || $errors->has('new_password') || session('success_password') || session('error_password'))
            $('#change-password-tab').tab('show');
        @else
            $('#edit-profile-tab').tab('show');
        @endif
    });
</script>
@endif
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
        const profileForm = document.querySelector('form[action*="update-profile"]') || document.querySelector('form:not([action*="password"])');
        const passwordForm = document.querySelector('form[action*="password"]');

        const btnSaveProfile = document.getElementById('btnSaveProfile');
        const btnUpdatePassword = document.getElementById('btnUpdatePassword');

        if (profileForm && btnSaveProfile) {
            btnSaveProfile.addEventListener('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menyimpan perubahan profil?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        profileForm.submit();
                    }
                });
            });
        }

        if (passwordForm && btnUpdatePassword) {
            btnUpdatePassword.addEventListener('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi Ubah Password',
                    text: 'Apakah Anda yakin ingin memperbarui password?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Ubah',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        passwordForm.submit();
                    }
                });
            });
        }

        // Notifikasi sukses/gagal
        @if(session('success_password'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session("success_password") }}',
            confirmButtonText: 'OK'
        });
        @endif

        @if(session('error_password'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ session("error_password") }}',
            confirmButtonText: 'OK'
        });
        @endif
    });
</script>
