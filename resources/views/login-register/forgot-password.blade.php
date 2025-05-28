<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ asset('login-assets/css/style.css') }}">
    <style>
        .container {
            display: flex;
            max-width: 900px;
            margin: 50px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .form-content, .image-content {
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
    <div class="container">
        <div class="form-content">
            <h2>Reset Password</h2>

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
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

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token ?? '' }}">
                
                <div class="form-group">
                    <label>Email kamu</label>
                    <input type="email" name="email" value="{{ $email ?? old('email') }}" required>
                </div>

                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password" required>
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required>
                </div>

                <button type="submit">Reset Password</button>
            </form>
        </div>
        <div class="image-content">
            <img src="{{ asset('login-assets/images/desk-image.png') }}" alt="Reset Password Illustration">
        </div>
    </div>
</div>

<script src="{{ asset('login-assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('login-assets/js/main.js') }}"></script>
</body>
</html>
