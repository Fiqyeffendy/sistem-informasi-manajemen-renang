{{-- Halaman login untuk masuk ke sistem dengan role admin, pelatih, atau siswa. --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIMPEL-Fella – Masuk</title>
    <meta name="description" content="Masuk ke SIMPEL-Fella, sistem manajemen kursus renang Fella." />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
            background: #fff;
        }

        /* ── Layout ── */
        .auth-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ══════════════════════════
           LEFT PANEL
        ══════════════════════════ */
        .auth-left {
            width: 45%;
            background: linear-gradient(160deg, #1a56db 0%, #2563eb 45%, #38bdf8 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            padding: 2.5rem;
        }

        /* Wave decoration SVG at bottom */
        .auth-left-wave {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            pointer-events: none;
            opacity: 0.25;
        }
        /* Subtle circle decorations */
        .auth-left::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            pointer-events: none;
        }
        .auth-left::after {
            content: '';
            position: absolute;
            bottom: 80px; left: -60px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            pointer-events: none;
        }

        /* Brand mark top-left */
        .auth-brand {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            margin-bottom: auto;
            position: relative;
            z-index: 2;
        }
        .auth-brand-icon {
            width: 36px; height: 36px;
            border-radius: 9px;
            background: rgba(255,255,255,0.18);
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 1.1rem;
            backdrop-filter: blur(4px);
        }
        .auth-brand-name {
            font-size: 0.95rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.2px;
        }

        /* Hero text */
        .auth-hero {
            position: relative;
            z-index: 2;
            padding-bottom: 3rem;
        }
        .auth-hero h1 {
            font-size: 2.25rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            letter-spacing: -0.8px;
            margin: 0 0 1rem;
        }
        .auth-hero p {
            font-size: 0.92rem;
            color: rgba(255,255,255,0.75);
            line-height: 1.65;
            margin: 0 0 2.5rem;
            max-width: 360px;
            font-weight: 400;
        }

        /* Feature list */
        .auth-features {
            display: flex;
            flex-direction: column;
            gap: 0.625rem;
        }
        .auth-feature-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            backdrop-filter: blur(8px);
            color: rgba(255,255,255,0.9);
            font-size: 0.855rem;
            font-weight: 500;
            transition: background 0.15s ease;
        }
        .auth-feature-item:hover { background: rgba(255,255,255,0.15); }
        .auth-feature-item i {
            font-size: 1rem;
            color: rgba(255,255,255,0.7);
            flex-shrink: 0;
        }

        /* Wave SVG */
        .wave-svg {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            z-index: 1;
        }

        /* ══════════════════════════
           RIGHT PANEL
        ══════════════════════════ */
        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            background: #fff;
        }

        .auth-form-wrap {
            width: 100%;
            max-width: 400px;
        }

        .auth-form-header {
            margin-bottom: 2rem;
        }
        .auth-form-header h2 {
            font-size: 1.65rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0 0 0.375rem;
            letter-spacing: -0.5px;
        }
        .auth-form-header p {
            font-size: 0.875rem;
            color: #64748B;
            margin: 0;
            font-weight: 400;
        }

        /* Form groups */
        .form-group {
            margin-bottom: 1.125rem;
        }
        .form-group label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #0F172A;
            margin-bottom: 0.4rem;
        }
        .input-wrap {
            position: relative;
        }
        .input-wrap i {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            font-size: 0.9rem;
            pointer-events: none;
        }
        .input-wrap input {
            width: 100%;
            height: 44px;
            padding: 0 0.875rem 0 2.5rem;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            font-size: 0.9rem;
            font-family: inherit;
            background: #fff;
            color: #0F172A;
            transition: border-color 0.15s, box-shadow 0.15s;
            font-weight: 400;
        }
        .input-wrap input::placeholder { color: #CBD5E1; }
        .input-wrap input:focus {
            outline: none;
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }
        .input-wrap.has-toggle input { padding-right: 2.75rem; }
        .btn-eye {
            position: absolute;
            right: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #94A3B8;
            font-size: 0.9rem;
            padding: 0;
            display: flex; align-items: center;
        }
        .btn-eye:hover { color: #475569; }

        /* Remember + Forgot */
        .form-row-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            margin-top: -0.25rem;
        }
        .check-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 0.845rem;
            color: #64748B;
            font-weight: 500;
            user-select: none;
        }
        .check-label input[type="checkbox"] {
            width: 15px; height: 15px;
            border: 1px solid #CBD5E1;
            border-radius: 4px;
            cursor: pointer;
            accent-color: #2563EB;
        }
        .link-forgot {
            font-size: 0.845rem;
            font-weight: 600;
            color: #2563EB;
            text-decoration: none;
        }
        .link-forgot:hover { text-decoration: underline; }

        /* Submit button */
        .btn-submit {
            width: 100%;
            height: 46px;
            background: #2563EB;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.92rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-family: inherit;
            transition: background 0.15s, box-shadow 0.15s, transform 0.1s;
            letter-spacing: -0.1px;
            margin-bottom: 1.25rem;
        }
        .btn-submit:hover {
            background: #1d4ed8;
            box-shadow: 0 6px 20px rgba(37,99,235,0.2);
        }
        .btn-submit:active { transform: scale(0.99); }

        /* Divider */
        .or-divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #94A3B8;
            font-size: 0.78rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }
        .or-divider::before, .or-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #E2E8F0;
        }

        /* Google button */
        .btn-google {
            width: 100%;
            height: 44px;
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #0F172A;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.15s, border-color 0.15s;
            margin-bottom: 1.75rem;
        }
        .btn-google:hover {
            background: #F8FAFC;
            border-color: #CBD5E1;
        }
        .google-icon {
            width: 18px; height: 18px;
        }

        /* Footer link */
        .auth-footer-text {
            text-align: center;
            font-size: 0.855rem;
            color: #64748B;
            font-weight: 400;
        }
        .auth-footer-text a {
            color: #2563EB;
            font-weight: 700;
            text-decoration: none;
        }
        .auth-footer-text a:hover { text-decoration: underline; }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .auth-left { display: none; }
            .auth-right { padding: 2rem 1.25rem; }
        }
        @media (max-width: 480px) {
            .auth-form-wrap { max-width: 100%; }
        }
    </style>
</head>
<body>

<div class="auth-layout">

    <!-- ════════════════════════
         LEFT PANEL
    ════════════════════════ -->
    <div class="auth-left">

        <!-- Brand -->
        <div class="auth-brand">
            <div class="auth-brand-icon">
                <i class="bi bi-water"></i>
            </div>
            <span class="auth-brand-name">SIMPEL-Fella</span>
        </div>

        <!-- Hero -->
        <div class="auth-hero">
            <h1>Kelola kursus renang<br>lebih cerdas, lebih mudah.</h1>
            <p>Platform manajemen kursus renang terpadu<br>— dari pendaftaran siswa hingga laporan<br>kehadiran dalam satu dasbor.</p>

            <!-- Feature list -->
            <div class="auth-features">
                <div class="auth-feature-item">
                    <i class="bi bi-people"></i>
                    Manajemen siswa &amp; pelatih terpusat
                </div>
                <div class="auth-feature-item">
                    <i class="bi bi-calendar-check"></i>
                    Jadwal &amp; kehadiran otomatis
                </div>
                <div class="auth-feature-item">
                    <i class="bi bi-bar-chart-line"></i>
                    Laporan &amp; analitik real-time
                </div>
            </div>
        </div>

        <!-- Wave SVG decoration -->
        <svg class="wave-svg" viewBox="0 0 900 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,120 C150,180 300,60 450,100 C600,140 750,40 900,80 L900,180 L0,180 Z" fill="rgba(255,255,255,0.08)"/>
            <path d="M0,140 C200,100 400,160 600,120 C750,90 850,140 900,130 L900,180 L0,180 Z" fill="rgba(255,255,255,0.06)"/>
        </svg>
    </div>

    <!-- ════════════════════════
         RIGHT PANEL
    ════════════════════════ -->
    <div class="auth-right">
        <div class="auth-form-wrap">

            <div class="auth-form-header">
                <h2>Selamat datang kembali</h2>
                <p>Masuk ke akun SIMPEL-Fella untuk mengakses dashboard Anda.</p>
            </div>

            @if (session('status'))
                <div class="alert-success" style="margin-bottom:1rem; padding:0.8rem 1rem; border-radius:10px; background:#ecfdf3; color:#047857; border:1px solid #a7f3d0; font-size:0.9rem;">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-danger" style="margin-bottom:1rem; padding:0.8rem 1rem; border-radius:10px; background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; font-size:0.9rem;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form id="form-login" method="POST" action="{{ route('auth.login') }}" novalidate>
                @csrf
                <!-- Email -->
                <div class="form-group">
                    <label for="inp-email">Email</label>
                    <div class="input-wrap">
                        <i class="bi bi-envelope"></i>
                        <input
                            type="email"
                            id="inp-email"
                            name="email"
                            placeholder="admin@simpelfella.id"
                            autocomplete="email"
                            required
                        />
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="inp-password">Kata Sandi</label>
                    <div class="input-wrap has-toggle">
                        <i class="bi bi-lock"></i>
                        <input
                            type="password"
                            id="inp-password"
                            name="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                        />
                        <button type="button" class="btn-eye" id="btn-toggle-pass" title="Tampilkan/sembunyikan sandi">
                            <i class="bi bi-eye" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember + Forgot -->
                <div class="form-row-meta">
                    <label class="check-label">
                        <input type="checkbox" id="inp-remember" name="remember" />
                        Ingat saya
                    </label>
                    <a href="#" class="link-forgot">Lupa kata sandi?</a>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit" id="btn-login">
                    Masuk
                    <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <!-- Divider -->
            <div class="or-divider">atau lanjutkan dengan</div>

            <!-- Google -->
            <button class="btn-google" type="button" id="btn-google-login">
                <!-- Google G icon -->
                <svg class="google-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Masuk dengan Google
            </button>

            <!-- Footer -->
            <p class="auth-footer-text">
                Belum punya akun? <a href="{{ route('auth.register') }}">Daftar sekarang</a>
            </p>

        </div>
    </div>

</div>

<script>
(function () {
    // Toggle password visibility
    const btnEye  = document.getElementById('btn-toggle-pass');
    const passInp = document.getElementById('inp-password');
    const eyeIcon = document.getElementById('eye-icon');

    if (btnEye && passInp) {
        btnEye.addEventListener('click', function () {
            const isPass = passInp.type === 'password';
            passInp.type = isPass ? 'text' : 'password';
            eyeIcon.className = isPass ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    }

    // Let the form submit to Laravel directly.
    const form = document.getElementById('form-login');
    if (form) {
        form.addEventListener('submit', function () {
            const btn = document.getElementById('btn-login');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="bi bi-arrow-repeat" style="animation:spin 0.8s linear infinite;display:inline-block;"></i> Memuat...';
            }
        });
    }

    // Google login placeholder
    const btnGoogle = document.getElementById('btn-google-login');
    if (btnGoogle) {
        btnGoogle.addEventListener('click', function () {
            alert('Login Google belum tersedia. Gunakan email & kata sandi.');
        });
    }
})();
</script>

<style>
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>

</body>
</html>
