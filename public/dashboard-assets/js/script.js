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
        passwordInput.setAttribute('type', type);
        
        // Toggle ikon mata antara terbuka dan tertutup
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
        
        // Fokus kembali ke input setelah toggle
        passwordInput.focus();
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

// ==== Inputan Nama ==== //
document.getElementById('name').addEventListener('input', function() {
    this.value = this.value.replace(/[^A-Za-z\s]/g, '');
});

$(document).ready(function() {
        // Fungsi untuk mereset form
        function resetUserForm() {
            $('#userForm')[0].reset(); // Reset semua input
            $('#passwordMatch').removeClass('is-invalid'); // Hapus validasi password match
            $('.text-danger').removeClass('text-success'); // Reset indikator password
        }

        // Ketika modal ditutup
        $('#formTambahUser').on('hidden.bs.modal', function () {
            resetUserForm();
        });

        // Ketika tombol Kembali diklik
        $('.btn-secondary').click(function() {
            resetUserForm();
        });

        // Validasi password match
        $('#password_confirmation').on('keyup', function() {
            const password = $('#password').val();
            const confirmPassword = $(this).val();
            
            if (password !== confirmPassword) {
                $(this).addClass('is-invalid');
                $('#passwordMatch').show();
            } else {
                $(this).removeClass('is-invalid');
                $('#passwordMatch').hide();
            }
        });

        // Validasi kriteria password
        $('#password').on('keyup', function() {
            const value = $(this).val();
            
            // Minimal 8 karakter
            $('#length').toggleClass('text-success', value.length >= 8);
            
            // Huruf kapital
            $('#capital').toggleClass('text-success', /[A-Z]/.test(value));
            
            // Angka
            $('#number').toggleClass('text-success', /[0-9]/.test(value));
            
            // Karakter khusus
            $('#special').toggleClass('text-success', /[@$!%*?&]/.test(value));
        });
    });

// $(document).ready(function() {
//         // Scroll to bottom of chat
//         $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight);
        
//         // Pusher configuration for real-time chat
//         const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
//             cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
//             encrypted: true
//         });
        
//         const channel = pusher.subscribe('consultation.{{ $consultation->id }}');
        
//         channel.bind('new-message', function(data) {
//             // Append new message to chat
//             const messageClass = data.sender === 'admin' ? 'admin-message' : 'user-message';
//             const senderName = data.sender === 'admin' ? 'Admin' : '{{ $consultation->user->name }}';
            
//             const messageHtml = `
//                 <div class="message ${messageClass}">
//                     <div class="message-header">
//                         <strong>${senderName}</strong>
//                         <small class="text-muted">${new Date(data.created_at).toLocaleString()}</small>
//                     </div>
//                     <div class="message-body">
//                         ${data.message}
//                     </div>
//                 </div>
//             `;
            
//             $('#chat-messages').append(messageHtml);
//             $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight);
//         });
        
//         // Handle form submission
//         $('#consultation-form').submit(function(e) {
//             e.preventDefault();
            
//             const formData = $(this).serialize();
//             const messageInput = $('#message-input');
            
//             $.ajax({
//                 url: '{{ route('admin.consultations.reply') }}',
//                 method: 'POST',
//                 data: formData,
//                 beforeSend: function() {
//                     $('#send-button').prop('disabled', true);
//                 },
//                 success: function(response) {
//                     messageInput.val('');
//                 },
//                 error: function(error) {
//                     console.error(error);
//                     alert('Gagal mengirim pesan');
//                 },
//                 complete: function() {
//                     $('#send-button').prop('disabled', false);
//                 }
//             });
//         });
//     });

$(document).ready(function() {
        // Sample chat data
        const chatData = {
            1: [
                {
                    sender: 'user',
                    name: 'Budi Santoso',
                    message: 'Selamat pagi, saya ingin bertanya tentang produk terbaru Anda.',
                    time: '15 Jun 2023 10:30'
                },
                {
                    sender: 'admin',
                    name: 'Admin',
                    message: 'Selamat pagi Pak Budi, produk apa yang ingin Anda tanyakan?',
                    time: '15 Jun 2023 10:35'
                }
            ],
            2: [
                {
                    sender: 'user',
                    name: 'Ani Wijaya',
                    message: 'Saya mengalami masalah dengan pesanan saya.',
                    time: '14 Jun 2023 09:15'
                },
                {
                    sender: 'admin',
                    name: 'Admin',
                    message: 'Bisa Anda jelaskan masalahnya lebih detail?',
                    time: '14 Jun 2023 09:20'
                }
            ]
        };

        // Open chat modal
        $('.view-chat').click(function() {
            const id = $(this).data('id');
            const consultation = $(this).closest('tr');
            
            // Set customer info
            $('#customer-name').text(consultation.find('td:eq(1)').text());
            $('#customer-email').text(consultation.find('td:eq(2)').text());
            $('#consultation-topic').text(consultation.find('td:eq(3)').text());
            
            // Load messages
            $('#chat-messages').empty();
            chatData[id].forEach(msg => {
                const messageClass = msg.sender === 'admin' ? 'admin-message' : 'user-message';
                const messageHtml = `
                    <div class="message ${messageClass}">
                        <div class="message-header">
                            <strong>${msg.name}</strong>
                            <small class="text-muted">${msg.time}</small>
                        </div>
                        <div class="message-body">
                            ${msg.message}
                        </div>
                    </div>
                `;
                $('#chat-messages').append(messageHtml);
            });
            
            $('#chatModal').modal('show');
            $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight);
        });

        // Handle reply form submission
        $('#reply-form').submit(function(e) {
            e.preventDefault();
            const message = $('#message-input').val().trim();
            
            if (message) {
                // Get current time
                const now = new Date();
                const timeString = `${now.getDate()} ${['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'][now.getMonth()]} ${now.getFullYear()} ${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}`;
                
                // Create new message element
                const messageHtml = `
                    <div class="message admin-message">
                        <div class="message-header">
                            <strong>Admin</strong>
                            <small class="text-muted">${timeString}</small>
                        </div>
                        <div class="message-body">
                            ${message}
                        </div>
                    </div>
                `;
                
                // Append to chat
                $('#chat-messages').append(messageHtml);
                
                // Clear input and scroll to bottom
                $('#message-input').val('');
                $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight);
            }
        });

        // Refresh button
        $('#refresh-btn').click(function() {
            alert('Daftar konsultasi diperbarui');
        });
    });