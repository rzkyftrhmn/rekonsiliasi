<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register | Aplikasi Rekonsiliasi</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-card {
            background: #fff;
            padding: 30px;
            width: 380px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .register-card h3 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            outline: none;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #4e73df;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #1cc88a;
            border: none;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #17a673;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .success {
            background: #d1e7dd;
            color: #0f5132;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .login-link a {
            text-decoration: none;
            color: #4e73df;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>

    @include('auth.styles')
</head>
<body>

<div class="auth-card register">
    <h3>Registrasi Akun</h3>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="/register">
        @csrf

        <div class="form-group">
            <input type="text" name="name" placeholder="Nama Lengkap">
        </div>

        <div class="form-group">
            <input type="email" name="email" placeholder="Email">
        </div>

        <div class="form-group">
            <input type="password" name="password" placeholder="Password">
        </div>

        <div class="form-group">
            <input type="password" name="password_confirmation" placeholder="Ulangi Password">
        </div>

        <button type="submit">Daftar</button>
    </form>

    <div class="auth-link">
        Sudah punya akun? <a href="/login">Login</a>
    </div>
</div>

</body>
</html>
