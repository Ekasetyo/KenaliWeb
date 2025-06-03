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
    <style>
        body {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            min-height: 100vh !important;
            margin: 0 !important;
        }
        .main {
            flex-grow: 0 !important;
            /* atau */
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
        }
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }
        .forgot-password {
            color:rgb(61, 66, 74);
            text-decoration: none;
            font-size: 14px;
        }
        .forgot-password:hover {
            text-decoration: underline;
        
        }
    </style>
</head>
<body>
    <div class="main">
        <!-- Form Login -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
    <figure>
        <img src="{{ asset('login-assets/images/Login_Kenali.png') }}" alt="Logo Kenali" style="max-width: 200px;">
    </figure>
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
                                <div class="form-actions">
                                    <!-- <a href="{{ route('password.request') }}" class="forgot-password">Lupa password?</a> -->
                                    <button type="submit" name="signin" id="signin" class="form-submit">Login</button>
                                </div>
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