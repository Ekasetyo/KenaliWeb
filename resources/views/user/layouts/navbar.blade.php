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
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">UserKenali@gmail.com</span>
                <img class="img-profile rounded-circle"
                     src="https://ui-avatars.com/api/?name=Eka+Ganteng&background=random" width="40" height="40">
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ubahPasswordModal">
                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                    Ubah Password
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ url('/logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
<!-- End of Topbar -->

<!-- Modal Ubah Password -->
<div class="modal fade" id="ubahPasswordModal" tabindex="-1" aria-labelledby="ubahPasswordModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <form method="POST" action="{{ url('/user/ubah-password') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ubahPasswordModalLabel">Ubah Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" @if(session('success')) style="display:none" @endif>
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          {{-- Pesan sukses --}}
          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          {{-- Pesan error dari session --}}
          @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
          @endif

          {{-- Validasi error --}}
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="form-group">
            <label for="old_password">Password Lama</label>
            <input type="password" name="old_password" id="old_password" class="form-control" autocomplete="current-password" required>
          </div>
          <div class="form-group">
            <label for="new_password">Password Baru</label>
            <input type="password" name="new_password" id="new_password" class="form-control" autocomplete="new-password" required>
          </div>
          <div class="form-group">
            <label for="new_password_confirmation">Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" autocomplete="new-password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" @if(session('success')) style="display:none" @endif>Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- Script untuk menampilkan modal jika ada pesan sukses, error, atau validasi gagal --}}
@if(session('success') || session('error') || $errors->any())
<script>
    $(document).ready(function() {
        $('#ubahPasswordModal').modal('show');
    });
</script>
@endif
