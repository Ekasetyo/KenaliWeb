<div class="modal fade" id="formTambahUser" tabindex="-1" role="dialog" aria-labelledby="formTambahUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formTambahUser">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.user.store') }}" method="POST" id="userForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama:</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Masukkan nama" required
                            pattern="[A-Za-z\s]+"
                            title="Hanya huruf dan spasi yang diperbolehkan"
                            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Masukkan email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password"
                        placeholder="Masukkan password" required
                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                        title="Password harus mengandung minimal 8 karakter, termasuk huruf besar, huruf kecil, angka, dan karakter khusus">
                    <div class="input-group-append">
                        <span class="input-group-text">
                        <i id="togglePassword" class="fa fa-eye" style="cursor: pointer;"></i>
                        </span>
                    </div>
                            </div>
                        <small class="form-text text-muted">
                                 Password harus mengandung:
                            <ul>
                            <li id="length" class="text-danger">Minimal 8 karakter</li>
                            <li id="capital" class="text-danger">Huruf kapital (A-Z)</li>
                            <li id="number" class="text-danger">Angka (0-9)</li>
                            <li id="special" class="text-danger">Karakter khusus (@$!%*?&)</li>
                            </ul>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password:</label>
                        <input type="password" class="form-control" id="password_confirmation" 
                            name="password_confirmation" placeholder="Masukkan ulang password" required>
                        <div id="passwordMatch" class="invalid-feedback">Password tidak cocok</div>
                    </div>
                    <!-- Field lainnya tetap sama -->
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin:</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir:</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                    </div>
                    <div class="form-group">
                        <label for="no_telepon">No. Telepon:</label>
                        <input type="tel" class="form-control" id="no_telepon" name="no_telepon"
                            placeholder="Masukkan nomor telepon" 
                            pattern="[0-9]*" 
                            inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            required>
                        <small class="form-text text-muted">Hanya angka yang diperbolehkan</small>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat:</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                </form>
            </div>
        </div>
    </div>
</div>
