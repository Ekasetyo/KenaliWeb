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