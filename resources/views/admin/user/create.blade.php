<div class="modal fade" id="formTambahUser" tabindex="-1" role="dialog" aria-labelledby="formTambahUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formTambahUser">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeButton">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.user.store') }}" method="POST" id="userForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama" required
                            pattern="[A-Za-z\s]+" title="Hanya huruf dan spasi yang diperbolehkan"
                            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Masukkan password" required
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i id="togglePassword" class="fa fa-eye" style="cursor: pointer;"></i>
                                </span>
                            </div>
                        </div>
                        <small class="form-text text-muted">
                            Password harus mengandung:
                            <ul id="passwordRequirements" class="pl-3 mb-0">
                                <li id="length"><span class="indicator" style="color: red;">✗</span> Minimal 8 karakter</li>
                                <li id="capital"><span class="indicator" style="color: red;">✗</span> Huruf kapital (A-Z)</li>
                                <li id="number"><span class="indicator" style="color: red;">✗</span> Angka (0-9)</li>
                                <li id="special"><span class="indicator" style="color: red;">✗</span> Karakter khusus (@$!%*?&)</li>
                            </ul>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password:</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            placeholder="Masukkan ulang password" required>
                        <div id="passwordMatch" class="invalid-feedback" style="display: none;">Password tidak cocok</div>
                    </div>
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
                            placeholder="Masukkan nomor telepon" pattern="[0-9]*" inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="backButton">Kembali</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
#passwordRequirements li {
    list-style-type: none;
    position: relative;
    padding-left: 1.5em;
    margin-bottom: 5px;
}
#passwordRequirements .indicator {
    position: absolute;
    left: 0;
    width: 20px;
    display: inline-block;
    text-align: center;
}
</style>

<script>
// Fungsi utama validasi password
function validatePassword(value) {
    const isLengthValid = value.length >= 8;
    const hasCapital = /[A-Z]/.test(value);
    const hasNumber = /[0-9]/.test(value);
    const hasSpecialChar = /[@$!%*?&]/.test(value);

    updateIndicator('length', isLengthValid);
    updateIndicator('capital', hasCapital);
    updateIndicator('number', hasNumber);
    updateIndicator('special', hasSpecialChar);

    checkPasswordMatch();
}

// Update indikator visual
function updateIndicator(id, isValid) {
    const element = document.getElementById(id);
    if (element) {
        const indicator = element.querySelector('.indicator');
        if (indicator) {
            indicator.style.color = isValid ? 'green' : 'red';
            indicator.textContent = isValid ? '✓' : '✗';
        }
    }
}

// Cek kesamaan password & konfirmasi
function checkPasswordMatch() {
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const matchElement = document.getElementById('passwordMatch');

    // Jangan validasi jika password confirmation masih kosong
    if (passwordConfirmation.value === '') {
        passwordConfirmation.classList.remove('is-invalid');
        matchElement.style.display = 'none';
        return;
    }

    const isMatch = password.value === passwordConfirmation.value;
    passwordConfirmation.classList.toggle('is-invalid', !isMatch);
    matchElement.style.display = isMatch ? 'none' : 'block';
}


// DOM Ready
document.addEventListener('DOMContentLoaded', function () {
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const togglePassword = document.getElementById('togglePassword');
    const form = document.getElementById('userForm');
    const closeButton = document.getElementById('closeButton');
    const backButton = document.getElementById('backButton');

    if (password) {
        password.addEventListener('input', function () {
            validatePassword(this.value);
        });
    }

    if (passwordConfirmation) {
        passwordConfirmation.addEventListener('input', checkPasswordMatch);
        passwordConfirmation.addEventListener('blur', checkPasswordMatch);

    }

    if (togglePassword) {
        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            passwordConfirmation.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    }

    if (form) {
        form.addEventListener('submit', function (e) {
            if (password.value !== passwordConfirmation.value) {
                e.preventDefault();
                passwordConfirmation.classList.add('is-invalid');
                document.getElementById('passwordMatch').style.display = 'block';
                return false;
            }

            const strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            if (!strongRegex.test(password.value)) {
                e.preventDefault();
                alert('Password harus mengandung minimal 8 karakter, termasuk huruf besar, huruf kecil, angka, dan karakter khusus');
                return false;
            }
        });
    }

    function resetForm() {
        if (form) {
            form.reset();
            const indicators = document.querySelectorAll('#passwordRequirements .indicator');
            indicators.forEach(indicator => {
                indicator.style.color = 'red';
                indicator.textContent = '✗';
            });
            if (passwordConfirmation) {
                passwordConfirmation.classList.remove('is-invalid');
                const matchElement = document.getElementById('passwordMatch');
                if (matchElement) matchElement.style.display = 'none';
            }
            if (togglePassword && togglePassword.classList.contains('fa-eye-slash')) {
                togglePassword.classList.remove('fa-eye-slash');
                password.setAttribute('type', 'password');
                passwordConfirmation.setAttribute('type', 'password');
            }
        }
    }

    if (closeButton) closeButton.addEventListener('click', resetForm);
    if (backButton) backButton.addEventListener('click', resetForm);

    $('#formTambahUser').on('hidden.bs.modal', function () {
        resetForm();
    });
});
</script>
