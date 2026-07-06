<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIMPEL-Fella – Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/shell.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components.css') }}" />
</head>
<body>
    <div id="page-login" class="page active">
        <div class="login-container">
            <!-- HERO SECTION -->
            <div class="hero-section">
                <div class="hero-content">
                    <!-- Hero Illustration -->
                    <div class="hero-illustration">
                        <svg viewBox="0 0 400 350" xmlns="http://www.w3.org/2000/svg" class="swim-illustration">
                            <!-- Pool -->
                            <rect x="30" y="180" width="340" height="120" fill="#E3F2FD" rx="8"/>
                            <path d="M 30 180 Q 200 160 370 180" stroke="#1E88E5" stroke-width="2" fill="none"/>
                            
                            <!-- Water waves -->
                            <path d="M 40 200 Q 50 195 60 200 T 80 200 T 100 200" stroke="#42A5F5" stroke-width="1.5" fill="none" opacity="0.6"/>
                            <path d="M 40 225 Q 55 220 70 225 T 100 225 T 130 225" stroke="#1E88E5" stroke-width="1.5" fill="none" opacity="0.5"/>
                            <path d="M 300 210 Q 315 205 330 210 T 360 210" stroke="#42A5F5" stroke-width="1.5" fill="none" opacity="0.6"/>
                            
                            <!-- Swimmer (left) -->
                            <circle cx="80" cy="170" r="8" fill="#FDB750"/>
                            <ellipse cx="78" cy="185" rx="6" ry="12" fill="#FDB750"/>
                            <line x1="72" y1="188" x2="55" y2="195" stroke="#FDB750" stroke-width="3" stroke-linecap="round"/>
                            <line x1="84" y1="188" x2="105" y2="198" stroke="#FDB750" stroke-width="3" stroke-linecap="round"/>
                            
                            <!-- Swimmer (right) -->
                            <circle cx="280" cy="160" r="8" fill="#64B5F6"/>
                            <ellipse cx="282" cy="175" rx="6" ry="12" fill="#64B5F6"/>
                            <line x1="276" y1="178" x2="255" y2="190" stroke="#64B5F6" stroke-width="3" stroke-linecap="round"/>
                            <line x1="288" y1="178" x2="310" y2="192" stroke="#64B5F6" stroke-width="3" stroke-linecap="round"/>
                            
                            <!-- Coach & Child -->
                            <circle cx="180" cy="155" r="9" fill="#1565C0"/>
                            <path d="M 175 168 Q 175 178 180 185 Q 185 178 185 168 Z" fill="#1565C0"/>
                            <line x1="170" y1="172" x2="150" y2="185" stroke="#1565C0" stroke-width="3" stroke-linecap="round"/>
                            <line x1="190" y1="172" x2="210" y2="180" stroke="#1565C0" stroke-width="3" stroke-linecap="round"/>
                            
                            <!-- Child being taught -->
                            <circle cx="220" cy="165" r="7" fill="#FF9800"/>
                            <path d="M 216 175 Q 216 182 220 188 Q 224 182 224 175 Z" fill="#FF9800"/>
                            <line x1="212" y1="178" x2="200" y2="195" stroke="#FF9800" stroke-width="2.5" stroke-linecap="round"/>
                            <line x1="228" y1="178" x2="240" y2="190" stroke="#FF9800" stroke-width="2.5" stroke-linecap="round"/>
                            
                            <!-- Kickboard -->
                            <rect x="130" y="210" width="35" height="20" fill="#42A5F5" rx="4" opacity="0.7"/>
                            
                            <!-- Float/Pelampung -->
                            <circle cx="320" cy="185" r="15" fill="none" stroke="#FF5252" stroke-width="2" opacity="0.8"/>
                            <circle cx="320" cy="185" r="8" fill="#FFEBEE" opacity="0.6"/>
                            
                            <!-- Goggles icon (decorative) -->
                            <circle cx="110" cy="240" r="8" fill="none" stroke="#42A5F5" stroke-width="1.5" opacity="0.5"/>
                            <circle cx="130" cy="240" r="8" fill="none" stroke="#42A5F5" stroke-width="1.5" opacity="0.5"/>
                            <line x1="118" y1="240" x2="122" y2="240" stroke="#42A5F5" stroke-width="1.5" opacity="0.5"/>
                            
                            <!-- Water splash effect -->
                            <circle cx="150" cy="275" r="3" fill="#64B5F6" opacity="0.6"/>
                            <circle cx="155" cy="270" r="2" fill="#64B5F6" opacity="0.5"/>
                            <circle cx="145" cy="272" r="2" fill="#64B5F6" opacity="0.5"/>
                        </svg>
                    </div>
                    
                    <!-- Hero Text -->
                    <div class="hero-text">
                        <h2 class="hero-title">SIMPEL-Fella</h2>
                        <p class="hero-subtitle">Sistem Informasi Manajemen Penjadwalan &amp; Presensi Les Renang</p>
                        
                        <!-- Features -->
                        <div class="hero-features">
                            <div class="feature-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Jadwal Latihan Digital</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Presensi Otomatis</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Monitoring Sesi Latihan</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Coach Profesional</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LOGIN CARD SECTION -->
            <div class="login-section">
                <div class="login-card fade-in">
                    <div class="login-header">
                        <div class="login-logo"><i class="bi bi-water"></i></div>
                        <h1>Masuk</h1>
                        <p class="login-subtitle">Masukkan kredensial Anda untuk melanjutkan</p>
                    </div>

                    <form class="login-form">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <div class="input-wrapper">
                                <i class="bi bi-envelope input-icon"></i>
                                <input type="email" id="inp-email" class="form-input" placeholder="email@fella.id" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <div class="input-wrapper password-input">
                                <i class="bi bi-lock input-icon"></i>
                                <input type="password" id="inp-pass" class="form-input" placeholder="••••••••" />
                                <button class="btn-toggle-pass" type="button" id="btn-toggle-pass">
                                    <i class="bi bi-eye" id="eye-icon"></i>
                                </button>
                            </div>
                        </div>

                        <button type="button" class="btn-login" id="btn-login">
                            <span>Masuk</span>
                            <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </form>

                    <div class="login-footer">
                        <p class="help-text">Masuk dengan email dan password Anda untuk melanjutkan.</p>
                        <p class="signup-text">Belum punya akun? <a href="{{ route('auth.register') }}" class="signup-link">Daftar siswa baru</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/js/app.js'])
</body>
</html>
