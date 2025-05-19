function updateDateTime() {
    const now = new Date();

    // Format tanggal: Hari, DD MMMM YYYY (contoh: Senin, 15 Januari 2024)
    const optionsDate = {
        weekday: "long",
        day: "numeric",
        month: "long",
        year: "numeric",
    };
    const liveDateElement = document.getElementById("live-date");
    if (liveDateElement) {
        liveDateElement.textContent = now.toLocaleDateString(
            "id-ID",
            optionsDate
        );
    }

    // Format jam: HH:MM:SS (contoh: 14:30:45)
    const timeString = now.toLocaleTimeString("id-ID", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: false,
    });
    const liveClockElement = document.getElementById("live-clock");
    if (liveClockElement) {
        liveClockElement.textContent = timeString;
    }
}

// Update setiap detik
setInterval(updateDateTime, 1000);

// Jalankan sekali saat pertama load
updateDateTime();

const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#password");

togglePassword.addEventListener("click", function (e) {
    // toggle the type attribute
    const type =
        password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    // toggle the eye slash icon
    this.classList.toggle("fa-eye-slash");
});



document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-edit').forEach(function (button) {
            button.addEventListener('click', function () {
                const userId = this.dataset.id;
                fetch(`/admin/user/${userId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('editUserForm').action = `/admin/user/${userId}`;
                        document.getElementById('edit_name').value = data.name;
                        document.getElementById('edit_email').value = data.email;
                        document.getElementById('edit_jenis_kelamin').value = data.jenis_kelamin ?? '';
                        document.getElementById('edit_tanggal_lahir').value = data.tanggal_lahir ?? '';
                        document.getElementById('edit_no_telepon').value = data.no_telepon ?? '';
                        document.getElementById('edit_alamat').value = data.alamat ?? '';
                        document.getElementById('edit_status').value = data.status ?? 'user';

                        $('#formEditUser').modal('show');
                    });
            });
        });
    });

// ===== Password Validasi ===== //
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const togglePassword = document.getElementById('togglePassword');
    const form = document.getElementById('userForm');
    
    // Toggle password visibility
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        passwordConfirmation.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
    
    // Password validation
    password.addEventListener('input', function() {
        const value = this.value;
        
        // Validate length
        document.getElementById('length').className = value.length >= 8 ? 'text-success' : 'text-danger';
        
        // Validate capital letter
        document.getElementById('capital').className = /[A-Z]/.test(value) ? 'text-success' : 'text-danger';
        
        // Validate number
        document.getElementById('number').className = /[0-9]/.test(value) ? 'text-success' : 'text-danger';
        
        // Validate special character
        document.getElementById('special').className = /[@$!%*?&]/.test(value) ? 'text-success' : 'text-danger';
    });
    
    // Password confirmation validation
    passwordConfirmation.addEventListener('input', function() {
        if (this.value !== password.value) {
            this.classList.add('is-invalid');
            document.getElementById('passwordMatch').style.display = 'block';
        } else {
            this.classList.remove('is-invalid');
            document.getElementById('passwordMatch').style.display = 'none';
        }
    });
    
    // Form submission validation
    form.addEventListener('submit', function(e) {
        if (password.value !== passwordConfirmation.value) {
            e.preventDefault();
            passwordConfirmation.classList.add('is-invalid');
            document.getElementById('passwordMatch').style.display = 'block';
            return false;
        }
        
        // Check password strength
        const strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        if (!strongRegex.test(password.value)) {
            e.preventDefault();
            alert('Password harus mengandung minimal 8 karakter, termasuk huruf besar, huruf kecil, angka, dan karakter khusus');
            return false;
        }
        
        return true;
    });
});

// ==== Inputan Angka di No.Telepon ==== //
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.getElementById('no_telepon');
    
    // Mencegah input non-numerik
    phoneInput.addEventListener('keydown', function(e) {
        // Izinkan: backspace, delete, tab, escape, enter, arrow keys
        if ([46, 8, 9, 27, 13, 110, 190].includes(e.keyCode) || 
            // Izinkan: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
            (e.keyCode === 65 && e.ctrlKey === true) || 
            (e.keyCode === 67 && e.ctrlKey === true) ||
            (e.keyCode === 86 && e.ctrlKey === true) ||
            (e.keyCode === 88 && e.ctrlKey === true) ||
            // Izinkan: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                return;
        }
        // Pastikan itu angka
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
    // Validasi saat paste
    phoneInput.addEventListener('paste', function(e) {
        e.preventDefault();
        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
        this.value = pastedText.replace(/[^0-9]/g, '');
    });
});
