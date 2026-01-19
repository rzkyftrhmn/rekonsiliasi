<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Aplikasi Rekonsiliasi</title>

    @include('auth.styles')
</head>
<body>

<div class="auth-card login">
    <h3>Login</h3>

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <div class="form-group">
            <input type="text" name="username" placeholder="Username">
        </div>

        <div class="form-group">
            <input type="password" name="password" placeholder="Password">
        </div>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
