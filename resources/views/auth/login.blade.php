<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Aplikasi Rekonsiliasi</title>
    @include('auth.styles')
</head>
<body>

    {{-- ─── LEFT: IMAGE PANEL ─── --}}
    <div class="panel-image">
        <img class="bg-img" src="{{ asset('img/bg-rekonsiliasi.jpg') }}" alt="Rekonsiliasi Keuangan">

        <div class="panel-image-content">
            <div class="badge-app">
                <div class="badge-dot"></div>
                <span>Sistem Aktif</span>
            </div>

            <h2 class="panel-title">
                Rekonsiliasi<br>
                <em>Keuangan</em> Cerdas
            </h2>

            <div class="panel-divider"></div>

            <p class="panel-desc">
                Kelola dan verifikasi transaksi keuangan dengan akurasi tinggi, efisien, dan terdokumentasi dengan baik.
            </p>
        </div>
    </div>

    {{-- ─── RIGHT: FORM PANEL ─── --}}
    <div class="panel-form">

        {{-- Logo --}}
        <div class="logo-wrap">
            <div class="logo-icon">
                <img class="logo-img" src="{{ asset('img/logo_BKAD.png') }}" alt="Logo Rekonsiliasi">
            </div>
            <div class="logo-text">Rekonsiliasi</div>
            <div class="logo-sub">Management System</div>
        </div>

        {{-- Heading --}}
        <div class="form-heading">
            <h1>Selamat Datang</h1>
            <p>Masuk untuk melanjutkan ke dashboard Anda</p>
        </div>
        <span class="gold-rule"></span>

        {{-- Error Alert --}}
        @if(session('error'))
        <div class="alert-error">
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            {{ session('error') }}
        </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="/login">
            @csrf

            <div class="field">
                <label for="username">Username</label>
                <div class="input-wrap">
                    <input
                        id="username"
                        type="text"
                        name="username"
                        placeholder="Masukkan username Anda"
                        value="{{ old('username') }}"
                        autocomplete="username"
                        required
                    >
                    <svg class="icon-field" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Masukkan password Anda"
                        autocomplete="current-password"
                        class="has-eye"
                        required
                    >
                    <svg class="icon-field" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0110 0v4"/>
                    </svg>
                    <button type="button" class="btn-eye" onclick="togglePassword()" aria-label="Tampilkan password">
                        <svg id="eye-icon" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-footer-row">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember">
                    Ingat saya
                </label>
            </div>

            <button type="submit" class="btn-login">
                <span>Masuk ke Dashboard</span>
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </button>
        </form>

        <p class="form-note">
            Butuh akses? Hubungi <strong>Administrator</strong> Anda.
        </p>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eye-icon');
            const isHidden = input.type === 'password';

            input.type = isHidden ? 'text' : 'password';

            icon.innerHTML = isHidden
                ? `<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/>
                   <path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/>
                   <line x1="1" y1="1" x2="23" y2="23"/>`
                : `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                   <circle cx="12" cy="12" r="3"/>`;
        }
    </script>

</body>
</html>
