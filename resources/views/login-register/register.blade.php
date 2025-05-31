<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ asset('login-assets/fonts/material-icon/css/material-design-iconic-font.min.css') }}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('login-assets/css/style.css') }}">
</head>
<body>

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign Up</h2>

                        <!-- FORM BARU -->
                        <form method="POST" action="{{ route('register') }}" class="register-form" id="register-form">
                            @csrf

                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name" value="{{ old('name') }}" required />
                            </div>

                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email" value="{{ old('email') }}" required />
                            </div>

                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Password" required />
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required />
                            </div>

                            <div class="form-group form-button" style="text-align: center;">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>

                    </div>
                    <div class="signup-image">
                        <figure><img src="{{ asset('login-assets/images/sign_up.png') }}" alt="sign up image"></figure>
                        <a href="{{ url('/login') }}" class="signup-image-link">Back to Login</a>
                    </div>
                </div>
            </div>
        </section>

    </div>
<script>
    document.getElementById("register-form").addEventListener("submit", function (e) {
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

    <!-- JS -->
    <script src="{{ asset('login-assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('login-assets/js/main.js') }}"></script>
</body>
</html>
