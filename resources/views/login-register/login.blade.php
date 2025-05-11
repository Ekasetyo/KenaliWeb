<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ asset('login-assets/fonts/material-icon/css/material-design-iconic-font.min.css') }}">
    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('login-assets/css/style.css') }}">
</head>
<body>
    <div class="main">
        <!-- Form Login -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="{{ asset('login-assets/images/signin-image.jpg') }}" alt="sing up image"></figure>
                        <a href="{{ url('/register') }}" class="signup-image-link">Buat akun baru</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Login</h2>
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login.submit') }}" class="register-form" id="login-form">
                            @csrf
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Email Anda" required/>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Password" required/>
                            </div>
                            <div class="form-group form-button" style="text-align: center;">
                                <button type="submit" name="signin" id="signin" class="form-submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script src="{{ asset('login-assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('login-assets/js/main.js') }}"></script>
</body>
</html>