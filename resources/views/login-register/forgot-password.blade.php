<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reset Password</title>

    <link rel="stylesheet" href="{{ asset('login-assets/fonts/material-icon/css/material-design-iconic-font.min.css') }}">

    <link rel="stylesheet" href="{{ asset('login-assets/css/style.css') }}">

    <style>
        /* Anda bisa menambahkan atau mengoverride gaya di sini jika ada perbedaan kecil yang tidak bisa diselesaikan oleh style.css */
        /* Contoh: Jika .container di style.css tidak responsif dengan baik, Anda bisa menambahkan: */
        /*
        .container {
            max-width: 1170px; // Contoh max-width dari template bawaan Anda
            margin: 0 auto; // Biasanya template menengahkan container
            padding: 15px; // Contoh padding
        }
        */
        /* Pastikan tidak ada gaya duplikat atau bertabrakan yang tidak disengaja */

        /* Hapus atau sesuaikan gaya berikut jika sudah diatur di style.css utama Anda */
        /* .form-content, .image-content {
            flex: 1;
            padding: 40px;
        }
        .form-content h2 {
            margin-bottom: 30px;
            font-size: 30px;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button[type="submit"] {
            background: #64a2f0;
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
        .image-content {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .image-content img {
            max-width: 100%;
            height: auto;
        }
        */
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 6px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

<div class="main">

    <section class="signup">
        <div class="container">
            <div class="signup-content">
                <div class="signup-form">
                    <h2 class="form-title">Reset Password</h2>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}" class="register-form" id="reset-password-form">
                        @csrf

                        <div class="form-group">
                            <label for="identifier"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input
                                type="text"
                                name="identifier"
                                id="identifier"
                                placeholder="Masukkan Nama Anda"
                                value="{{ old('identifier', $identifier ?? '') }}"
                                required
                            />
                        </div>

                        <div class="form-group">
                            <label for="password"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="password" placeholder="Password Baru" required />
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation"><i class="zmdi zmdi-lock-outline"></i></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" required />
                        </div>

                        <div class="form-group form-button" style="text-align: center;">
                            <input type="submit" name="reset" id="reset" class="form-submit" value="Reset Password"/>
                        </div>
                    </form>
                </div>

                <div class="signup-image">
                    <figure><img src="{{ asset('login-assets/images/forgot-password.png') }}" alt="reset password image"></figure>
                    <a href="{{ url('/login') }}" class="signup-image-link">Back to Login</a>
                </div>

            </div>
        </div>
    </section>

</div>

<script>
    document.getElementById("reset-password-form").addEventListener("submit", function (e) {
        const password = document.getElementById("password").value;
        const passwordConfirm = document.getElementById("password_confirmation").value;
        let errorMessages = [];

        if (password.length < 8) {
            errorMessages.push("Password minimal 8 karakter.");
        }
        if (!/[A-Z]/.test(password)) {
            errorMessages.push("Password harus mengandung huruf kapital (A-Z).");
        }
        if (!/[0-9]/.test(password)) {
            errorMessages.push("Password harus mengandung angka (0-9).");
        }
        if (!/[@$!%*?&]/.test(password)) {
            errorMessages.push("Password harus mengandung karakter khusus (@$!%*?&).");
        }
        if (password !== passwordConfirm) {
            errorMessages.push("Konfirmasi password tidak cocok.");
        }

        if (errorMessages.length > 0) {
            e.preventDefault(); // Menghentikan submit form
            alert(errorMessages.join("\n"));
        }
    });
</script>

<script src="{{ asset('login-assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('login-assets/js/main.js') }}"></script>
</body>
</html>