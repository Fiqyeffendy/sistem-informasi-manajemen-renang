{{-- Halaman pendaftaran publik untuk membuat akun siswa baru. --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIMPEL-Fella – Pendaftaran Siswa Baru</title>
    <meta name="description" content="Daftarkan siswa baru ke kursus renang Fella — isi data lengkap dalam 4 langkah mudah." />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components.css') }}" />

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #EEF5FF 0%, #E8F4FF 50%, #F0EEFF 100%);
            min-height: 100vh;
            color: #1a1a2e;
        }
        .reg-topnav {
            position: sticky; top: 0; z-index: 100;
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(0,0,0,0.06);
            padding: 14px 32px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .reg-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; color: inherit; }
        .reg-brand-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #1a6bff, #3b82f6);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(26,107,255,0.3);
        }
        .reg-brand-icon i { color: #fff; font-size: 18px; }
        .reg-brand-name { font-weight: 800; font-size: 18px; color: #1a1a2e; letter-spacing: -0.3px; }
        .reg-brand-sub { font-size: 11px; color: #6b7280; font-weight: 500; margin-top: -2px; }
        .reg-back-link {
            display: flex; align-items: center; gap: 6px;
            font-size: 14px; font-weight: 600; color: #1a6bff;
            text-decoration: none; padding: 8px 16px;
            border: 1.5px solid #c7d9ff; border-radius: 10px;
            background: rgba(26,107,255,0.04); transition: all 0.2s;
        }
        .reg-back-link:hover { background: #1a6bff; color: #fff; border-color: #1a6bff; }
        .reg-container { max-width: 700px; margin: 0 auto; padding: 48px 20px 80px; }
        .reg-page-title { text-align: center; margin-bottom: 36px; }
        .reg-page-title h1 { font-size: 28px; font-weight: 800; color: #1a1a2e; letter-spacing: -0.5px; margin-bottom: 8px; }
        .reg-page-title p { color: #6b7280; font-size: 15px; }

        /* Step indicator */
        .step-indicator { display: flex; align-items: flex-start; justify-content: center; gap: 0; margin-bottom: 36px; }
        .step-item { display: flex; flex-direction: column; align-items: center; flex: 1; position: relative; }
        .step-item::after {
            content: ''; position: absolute; top: 20px; left: 50%;
            width: 100%; height: 2px; background: #e5e7eb; transition: background 0.3s;
        }
        .step-item:last-child::after { display: none; }
        .step-item.completed::after { background: #1a6bff; }
        .step-circle {
            width: 40px; height: 40px; border-radius: 50%;
            background: #e5e7eb; border: 2.5px solid #e5e7eb;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px; color: #9ca3af;
            position: relative; z-index: 1; transition: all 0.3s;
        }
        .step-item.active .step-circle {
            background: #1a6bff; border-color: #1a6bff; color: #fff;
            box-shadow: 0 0 0 5px rgba(26,107,255,0.15);
        }
        .step-item.completed .step-circle { background: #1a6bff; border-color: #1a6bff; color: #fff; }
        .step-label { margin-top: 8px; font-size: 11px; font-weight: 600; color: #9ca3af; text-align: center; line-height: 1.3; transition: color 0.3s; }
        .step-item.active .step-label, .step-item.completed .step-label { color: #1a6bff; }

        /* Card */
        .reg-card { background: #fff; border-radius: 20px; box-shadow: 0 8px 40px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04); overflow: hidden; }
        .reg-card-header { padding: 28px 32px 20px; border-bottom: 1px solid #f3f4f6; }
        .reg-card-header h2 { font-size: 20px; font-weight: 700; color: #1a1a2e; margin-bottom: 4px; }
        .reg-card-header p { font-size: 14px; color: #6b7280; }
        .reg-card-body { padding: 28px 32px; }

        /* Form controls */
        .reg-group { margin-bottom: 20px; }
        .reg-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .reg-label .req { color: #ef4444; margin-left: 2px; }
        .reg-input, .reg-select, .reg-textarea {
            display: block; width: 100%; padding: 11px 14px;
            font-size: 14px; font-family: inherit; color: #1a1a2e;
            background: #fafafa; border: 1.5px solid #e5e7eb;
            border-radius: 10px; outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            appearance: none; -webkit-appearance: none;
        }
        .reg-input:focus, .reg-select:focus, .reg-textarea:focus {
            border-color: #1a6bff; box-shadow: 0 0 0 3px rgba(26,107,255,0.12); background: #fff;
        }
        .reg-input::placeholder, .reg-textarea::placeholder { color: #c0c4cc; }
        .reg-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 12px center; background-size: 18px; padding-right: 36px; cursor: pointer;
        }
        .reg-textarea { resize: vertical; min-height: 90px; }
        .reg-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        @media (max-width: 540px) { .reg-row { grid-template-columns: 1fr; } }

        /* Confirm table */
        .confirm-section { margin-bottom: 20px; }
        .confirm-section-title {
            font-size: 12px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.8px; color: #9ca3af;
            margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1px solid #f3f4f6;
        }
        .confirm-row { display: flex; align-items: flex-start; padding: 8px 0; font-size: 14px; border-bottom: 1px solid #fafafa; }
        .confirm-row:last-child { border-bottom: none; }
        .confirm-key { color: #6b7280; min-width: 150px; flex-shrink: 0; font-weight: 500; }
        .confirm-val { color: #1a1a2e; font-weight: 600; flex: 1; }
        .confirm-empty { color: #d1d5db; font-style: italic; font-weight: 400; }

        /* Actions */
        .step-actions {
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 32px 28px; border-top: 1px solid #f3f4f6; gap: 12px;
        }
        .btn-step-back {
            display: flex; align-items: center; gap: 6px;
            padding: 11px 22px; font-size: 14px; font-weight: 600;
            color: #6b7280; background: #f9fafb; border: 1.5px solid #e5e7eb;
            border-radius: 10px; cursor: pointer; transition: all 0.2s;
        }
        .btn-step-back:hover { background: #f3f4f6; color: #374151; border-color: #d1d5db; }
        .btn-step-back.hidden { visibility: hidden; pointer-events: none; }
        .btn-step-next {
            display: flex; align-items: center; gap: 6px;
            padding: 11px 28px; font-size: 14px; font-weight: 700;
            color: #fff; background: linear-gradient(135deg, #1a6bff, #3b82f6);
            border: none; border-radius: 10px; cursor: pointer;
            transition: all 0.2s; box-shadow: 0 4px 14px rgba(26,107,255,0.35);
        }
        .btn-step-next:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(26,107,255,0.45); }
        .btn-step-next:active { transform: translateY(0); }
        .btn-step-next:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

        /* Panels */
        .step-panel { display: none; }
        .step-panel.active { display: block; }

        /* Badge optional */
        .badge-optional {
            display: inline-block; font-size: 10px; font-weight: 600;
            color: #9ca3af; background: #f3f4f6;
            border-radius: 5px; padding: 2px 6px; margin-left: 6px; vertical-align: middle;
        }

        /* Progress bar */
        .reg-progress-bar { height: 3px; background: #e5e7eb; border-radius: 2px; overflow: hidden; }
        .reg-progress-fill {
            height: 100%; background: linear-gradient(90deg, #1a6bff, #3b82f6);
            border-radius: 2px; transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Success overlay */
        .reg-success { display: none; text-align: center; padding: 60px 32px; }
        .reg-success.show { display: block; }
        .success-icon {
            width: 80px; height: 80px;
            background: linear-gradient(135deg, #10b981, #34d399);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 24px; box-shadow: 0 8px 24px rgba(16,185,129,0.35);
        }
        .success-icon i { color: #fff; font-size: 36px; }

        /* Input with icon */
        .reg-input-icon-wrap {
            position: relative;
            display: block;
        }
        .reg-input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: #9ca3af;
            pointer-events: none;
            z-index: 1;
        }
        .reg-input-has-icon {
            padding-left: 38px;
        }

        /* Helper text */
        .reg-helper-text {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 5px;
            margin-bottom: 0;
        }

        /* Selection Card Intro styling */
        .selection-card {
            background: var(--surface);
            border: 2px solid var(--border) !important;
            border-radius: 16px;
            text-align: center;
            padding: 2rem;
            cursor: pointer;
            transition: all var(--transition-base);
            height: 100%;
        }
        .selection-card:hover {
            border-color: var(--primary) !important;
            background: var(--primary-light);
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }
        .selection-card .icon-circle {
            width: 64px;
            height: 64px;
            background: var(--primary-light);
            color: var(--primary);
            font-size: 1.5rem;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            transition: transform var(--transition-base);
        }
        .selection-card:hover .icon-circle {
            transform: scale(1.1);
            background: var(--primary);
            color: var(--white);
        }
    </style>
</head>
<body>

    {{-- TOP NAV --}}
    <nav class="reg-topnav">
        <a class="reg-brand" href="#">
            <div class="reg-brand-icon"><i class="bi bi-droplet-fill"></i></div>
            <div>
                <div class="reg-brand-name">SIMPEL-Fella</div>
                <div class="reg-brand-sub">Sistem Informasi Penjadwalan &amp; Presensi</div>
            </div>
        </a>
        <a href="{{ route('auth.login') }}" class="reg-back-link">
            <i class="bi bi-arrow-left"></i> Kembali ke Login
        </a>
    </nav>

    <div class="reg-container">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- LAYAR AWAL: PILIHAN TIPE PENDAFTARAN --}}
        <div id="selection-screen" class="fade-in py-4">
            <div class="text-center mb-5">
                <h1 class="fw-800 text-main mb-2" style="font-size:2.25rem; letter-spacing:-0.75px;">Pendaftaran Siswa Baru</h1>
                <p class="text-secondary mb-0">Silakan pilih jenis pendaftaran di bawah ini untuk memulai.</p>
            </div>
            
            <div class="row g-4 justify-content-center">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="selection-card" id="select-card-self">
                        <div class="icon-circle">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <h3 class="fw-800 text-main fs-5 mb-2">Saya sendiri</h3>
                        <p class="text-secondary small mb-0">Saya adalah siswa mandiri / dewasa yang akan mendaftar untuk diri saya sendiri.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="selection-card" id="select-card-wali">
                        <div class="icon-circle">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h3 class="fw-800 text-main fs-5 mb-2">Orang Tua / Wali</h3>
                        <p class="text-secondary small mb-0">Saya mendaftarkan anak, keluarga, atau orang lain yang berada di bawah perwalian saya.</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <p class="text-secondary small">Sudah memiliki akun login? <a href="{{ route('auth.login') }}" class="text-primary fw-600">Masuk di sini</a></p>
            </div>
        </div>

        {{-- FORM WIZARD CONTAINER (Hidden by default) --}}
        <div id="wizard-form-container" style="display: none;" class="fade-in">
            {{-- PAGE TITLE --}}
            <div class="reg-page-title">
                <h1>Formulir Pendaftaran</h1>
                <p>Silakan lengkapi formulir pendaftaran di bawah ini untuk memulai latihan renang.</p>
            </div>

            {{-- STEP INDICATOR --}}
            <div class="step-indicator" id="step-indicator">
                {{-- Di-render secara dinamis lewat JS --}}
            </div>

            {{-- FORM CARD --}}
            <div class="reg-card">
                {{-- PROGRESS BAR --}}
                <div class="reg-progress-bar">
                    <div class="reg-progress-fill" id="reg-progress" style="width:25%"></div>
                </div>

                {{-- Hidden input untuk menyimpan tipe pendaftaran --}}
                <input type="hidden" name="tipe_pendaftar" id="reg-tipe-pendaftar" value="wali" />

                {{-- STEP 1: INFORMASI SISWA --}}
                <div class="step-panel active" id="panel-1">
                    <div class="reg-card-header">
                        <h2><i class="bi bi-person-fill me-2" style="color:#1a6bff;"></i>Informasi Siswa</h2>
                        <p>Isi data pribadi siswa yang akan mengikuti kursus renang.</p>
                    </div>
                    <div class="reg-card-body">
                    <div class="reg-group">
                        <label class="reg-label" for="reg-nama-lengkap">Nama Lengkap <span class="req">*</span></label>
                        <input type="text" id="reg-nama-lengkap" class="reg-input" placeholder="Masukkan nama lengkap siswa" autocomplete="name" />
                    </div>
                    <div class="reg-group">
                        <label class="reg-label" for="reg-nama-panggilan">Nama Panggilan <span class="badge-optional">Opsional</span></label>
                        <input type="text" id="reg-nama-panggilan" class="reg-input" placeholder="Nama yang biasa dipanggil" />
                    </div>
                    <div class="reg-row">
                        <div class="reg-group" style="margin-bottom:0">
                            <label class="reg-label" for="reg-tanggal-lahir">Tanggal Lahir <span class="req">*</span></label>
                            <input type="date" id="reg-tanggal-lahir" class="reg-input" />
                        </div>
                        <div class="reg-group" style="margin-bottom:0">
                            <label class="reg-label" for="reg-jenis-kelamin">Jenis Kelamin <span class="req">*</span></label>
                            <select id="reg-jenis-kelamin" class="reg-select">
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="reg-group" style="margin-top:20px;">
                        <label class="reg-label" for="reg-tempat-lahir">Tempat Lahir <span class="req">*</span></label>
                        <input type="text" id="reg-tempat-lahir" class="reg-input" placeholder="Kota / tempat lahir" />
                    </div>
                    <div class="reg-group">
                        <label class="reg-label" for="reg-no-whatsapp">Nomor WhatsApp <span class="req">*</span></label>
                        <input type="text" id="reg-no-whatsapp" class="reg-input" placeholder="0821xxxxxxxx" inputmode="tel" />
                    </div>
                    <div class="reg-group" style="margin-bottom:0">
                        <label class="reg-label" for="reg-alamat">Alamat Lengkap <span class="req">*</span></label>
                        <textarea id="reg-alamat" class="reg-textarea" rows="3" placeholder="Jl. ..., No. ..., Kelurahan, Kecamatan, Kota"></textarea>
                    </div>
                </div>
            </div>

            {{-- STEP 2: INFORMASI ORANG TUA --}}
            <div class="step-panel" id="panel-2">
                <div class="reg-card-header">
                    <h2><i class="bi bi-people-fill me-2" style="color:#1a6bff;"></i>Informasi Orang Tua / Wali</h2>
                    <p>Data penanggung jawab siswa</p>
                </div>
                <div class="reg-card-body">
                    {{-- Nama Wali — full width with icon --}}
                    <div class="reg-group">
                        <label class="reg-label" for="reg-nama-wali">Nama Orang Tua / Wali <span class="req">*</span></label>
                        <div class="reg-input-icon-wrap">
                            <i class="bi bi-person reg-input-icon"></i>
                            <input type="text" id="reg-nama-wali" class="reg-input reg-input-has-icon" placeholder="Nama lengkap orang tua" autocomplete="name" />
                        </div>
                    </div>

                    {{-- Hubungan + Nomor HP — side by side --}}
                    <div class="reg-row">
                        <div class="reg-group" style="margin-bottom:0">
                            <label class="reg-label" for="reg-hubungan-wali">Hubungan <span class="req">*</span></label>
                            <select id="reg-hubungan-wali" class="reg-select">
                                <option value="">Pilih hubungan</option>
                                <option value="Ayah">Ayah</option>
                                <option value="Ibu">Ibu</option>
                                <option value="Wali">Wali</option>
                                <option value="Kakak">Kakak</option>
                                <option value="Paman">Paman</option>
                                <option value="Bibi">Bibi</option>
                            </select>
                        </div>
                        <div class="reg-group" style="margin-bottom:0">
                            <label class="reg-label" for="reg-no-hp-wali">Nomor HP <span class="badge-optional">Opsional</span></label>
                            <div class="reg-input-icon-wrap">
                                <i class="bi bi-telephone reg-input-icon"></i>
                                <input type="text" id="reg-no-hp-wali" class="reg-input reg-input-has-icon" placeholder="08xx xxxx xxxx" inputmode="tel" />
                            </div>
                        </div>
                    </div>

                    {{-- Email — full width with icon --}}
                    <div class="reg-group" style="margin-top:20px; margin-bottom:0">
                        <label class="reg-label" for="reg-email-wali">Email <span class="badge-optional">Opsional</span></label>
                        <div class="reg-input-icon-wrap">
                            <i class="bi bi-envelope reg-input-icon"></i>
                            <input type="email" id="reg-email-wali" class="reg-input reg-input-has-icon" placeholder="email@contoh.com" autocomplete="email" />
                        </div>
                        <p class="reg-helper-text">Digunakan untuk notifikasi jadwal dan tagihan</p>
                    </div>
                </div>
            </div>


            {{-- STEP 3: PROGRAM & JADWAL --}}
            <div class="step-panel" id="panel-3">
                <div class="reg-card-header">
                    <h2><i class="bi bi-calendar2-week-fill me-2" style="color:#1a6bff;"></i>Program &amp; Jadwal</h2>
                    <p>Pilih program kursus renang, tipe kelas, dan lokasi yang sesuai.</p>
                </div>
                <div class="reg-card-body">
                    <div class="reg-group">
                        <label class="reg-label" for="reg-program">Program <span class="badge-optional">Opsional</span></label>
                        <select id="reg-program" class="reg-select">
                            <option value="">-- Pilih Program --</option>
                            <option value="Fella WaterBabies (Swimming Lessons for Toddlers)">Fella WaterBabies (Toddlers)</option>
                            <option value="Fella SwimStars (Swimming Lessons for Kids)">Fella SwimStars (Kids)</option>
                            <option value="Fella AquaFit (Swimming Lessons for Adults)">Fella AquaFit (Adults)</option>
                            <option value="Fella SwimElite (Swimming Lessons for Elite)">Fella SwimElite (Elite)</option>
                        </select>
                    </div>
                    <div class="reg-group">
                        <label class="reg-label" for="reg-jenis-program">Jenis Program <span class="badge-optional">Opsional</span></label>
                        <select id="reg-jenis-program" class="reg-select">
                            <option value="">-- Pilih Jenis Program --</option>
                            <option value="Private">Private</option>
                            <option value="Semi-private">Semi-private</option>
                            <option value="Group">Group</option>
                            <option value="Small Group">Small Group</option>
                        </select>
                    </div>
                    <div class="reg-group">
                        <label class="reg-label" for="reg-lokasi-les">Lokasi Les <span class="badge-optional">Opsional</span></label>
                        <select id="reg-lokasi-les" class="reg-select">
                            <option value="">-- Pilih Lokasi --</option>
                            <option value="Perumahan Istana Mentari">Perumahan Istana Mentari</option>
                            <option value="Hotel Aston Sidoarjo">Hotel Aston Sidoarjo</option>
                            <option value="Hotel Swiss Berlinn">Hotel Swiss Berlinn</option>
                            <option value="Hotel Sofia Juanda">Hotel Sofia Juanda</option>
                            <option value="Permata Waterpark Tanggulangin">Permata Waterpark Tanggulangin</option>
                            <option value="Regency 21">Regency 21</option>
                            <option value="Premier Place Hotel Juanda">Premier Place Hotel Juanda</option>
                            <option value="Apartment Prospero Sidoarjo">Apartment Prospero Sidoarjo</option>
                            <option value="Legok Asri Park">Legok Asri Park</option>
                        </select>
                    </div>
                    <div class="reg-row">
                        <div class="reg-group" style="margin-bottom:0">
                            <label class="reg-label" for="reg-instagram">Instagram <span class="badge-optional">Opsional</span></label>
                            <input type="text" id="reg-instagram" class="reg-input" placeholder="@username" />
                        </div>
                        <div class="reg-group" style="margin-bottom:0">
                            <label class="reg-label" for="reg-catatan">Catatan Tambahan <span class="badge-optional">Opsional</span></label>
                            <input type="text" id="reg-catatan" class="reg-input" placeholder="Catatan khusus..." />
                        </div>
                    </div>
                </div>
            </div>

            {{-- STEP 4: PEMBUATAN AKUN --}}
            <div class="step-panel" id="panel-4">
                <div class="reg-card-header">
                    <h2><i class="bi bi-shield-lock-fill me-2" style="color:#1a6bff;"></i>Pembuatan Akun</h2>
                    <p>Buat email dan password untuk login ke akun siswa Anda.</p>
                </div>
                <div class="reg-card-body">
                    <div class="reg-group">
                        <label class="reg-label" for="reg-email-login">Email untuk Login <span class="req">*</span></label>
                        <input type="email" id="reg-email-login" class="reg-input" placeholder="email@contoh.com" autocomplete="email" />
                        <p class="reg-helper-text">Email ini akan dipakai untuk masuk ke akun Anda setelah diverifikasi.</p>
                    </div>
                    <div class="reg-row">
                        <div class="reg-group" style="margin-bottom:0">
                            <label class="reg-label" for="reg-password-login">Password <span class="req">*</span></label>
                            <input type="password" id="reg-password-login" class="reg-input" placeholder="Minimal 8 karakter" autocomplete="new-password" />
                        </div>
                        <div class="reg-group" style="margin-bottom:0">
                            <label class="reg-label" for="reg-password-confirm">Konfirmasi Password <span class="req">*</span></label>
                            <input type="password" id="reg-password-confirm" class="reg-input" placeholder="Ulangi password" autocomplete="new-password" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- STEP 5: KONFIRMASI --}}
            <div class="step-panel" id="panel-5">
                <div class="reg-card-header" id="confirm-header">
                    <h2><i class="bi bi-check2-circle me-2" style="color:#1a6bff;"></i>Konfirmasi Data</h2>
                    <p>Periksa kembali data sebelum mengirimkan pendaftaran.</p>
                </div>
                <div class="reg-card-body" id="confirm-body">
                    {{-- Filled dynamically by JS --}}
                </div>
                <div id="reg-success" class="reg-success">
                    <div class="success-icon"><i class="bi bi-check-lg"></i></div>
                    <h2 style="font-weight:800; font-size:22px; margin-bottom:8px; color:#1a1a2e;">Pendaftaran Berhasil!</h2>
                    <p style="color:#6b7280; margin-bottom:24px;">Akun Anda berhasil dibuat. Silakan masuk dengan email dan password yang Anda pilih.</p>
                    <a href="{{ route('auth.login') }}" style="display:inline-flex; align-items:center; gap:8px; padding:12px 28px; background:linear-gradient(135deg,#1a6bff,#3b82f6); color:#fff; border-radius:10px; font-weight:700; text-decoration:none;">
                        <i class="bi bi-box-arrow-in-right"></i> Ke Halaman Login
                    </a>
                </div>
            </div>

            {{-- STEP ACTIONS --}}
            <div class="step-actions" id="step-actions">
                <button class="btn-step-back hidden" id="btn-back" type="button">
                    <i class="bi bi-arrow-left"></i> Kembali
                </button>
                <button class="btn-step-next" id="btn-next" type="button">
                    Lanjutkan <i class="bi bi-arrow-right"></i>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/js/app.js'])

    <script>
        // Register page submit handler — posts to existing API /api/pendaftaran
        (function(){
            let isSubmitting = false; // flag to prevent double-submit

            // Fallback toast if showToast not available
            const fallbackToast = (msg, type) => {
                console.log(`[toast] ${type}: ${msg}`);
                if (window.showToast) {
                    window.showToast(msg, type);
                } else if (type === 'success') {
                    alert('✓ ' + msg);
                } else if (type === 'danger') {
                    alert('✗ ' + msg);
                }
            };

            function collectPayload() {
                const isMandiri = document.getElementById('reg-tipe-pendaftar')?.value === 'self';
                const namaSiswa = document.getElementById('reg-nama-lengkap')?.value?.trim();
                const waSiswa = document.getElementById('reg-no-whatsapp')?.value?.trim();
                const emailSiswa = document.getElementById('reg-email-login')?.value?.trim();
                
                return {
                    tipe_pendaftar: isMandiri ? 'self' : 'wali',
                    nama_lengkap: namaSiswa,
                    nama_panggilan: document.getElementById('reg-nama-panggilan')?.value?.trim(),
                    jenis_kelamin: document.getElementById('reg-jenis-kelamin')?.value,
                    tempat_lahir: document.getElementById('reg-tempat-lahir')?.value?.trim(),
                    tanggal_lahir: document.getElementById('reg-tanggal-lahir')?.value,
                    no_whatsapp: waSiswa,
                    email: emailSiswa,
                    password: document.getElementById('reg-password-login')?.value,
                    password_confirmation: document.getElementById('reg-password-confirm')?.value,
                    nama_wali: isMandiri ? namaSiswa : document.getElementById('reg-nama-wali')?.value?.trim(),
                    hubungan_wali: isMandiri ? 'Diri Sendiri' : document.getElementById('reg-hubungan-wali')?.value?.trim(),
                    alamat: document.getElementById('reg-alamat')?.value?.trim(),
                    program: document.getElementById('reg-program')?.value?.trim(),
                    jenis_program: document.getElementById('reg-jenis-program')?.value,
                    lokasi_les: document.getElementById('reg-lokasi-les')?.value?.trim(),
                    instagram: document.getElementById('reg-instagram')?.value?.trim(),
                    catatan: document.getElementById('reg-catatan')?.value?.trim(),
                };
            }

            async function submitRegistration(btn) {
                // prevent duplicate/concurrent submissions
                if (isSubmitting) {
                    console.log('[register] already submitting, ignoring click');
                    return;
                }
                isSubmitting = true;
                console.log('[register] submitRegistration called', { btnPresent: !!btn });
                try { console.log('[register] fetch implementation:', (window.fetch && window.fetch.toString && window.fetch.toString().slice(0,200)) || String(window.fetch)); } catch(e) { console.log('fetch toString error', e); }
                if (!btn) { isSubmitting = false; return; }
                const payload = collectPayload();

                // basic client-side check for required fields
                if (!payload.nama_lengkap || !payload.jenis_kelamin || !payload.tempat_lahir || !payload.tanggal_lahir || !payload.no_whatsapp || !payload.email || !payload.password || !payload.password_confirmation || !payload.nama_wali || !payload.hubungan_wali || !payload.alamat) {
                    fallbackToast('Lengkapi semua data penting termasuk email dan password.', 'danger');
                    isSubmitting = false;
                    return;
                }

                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(payload.email)) {
                    fallbackToast('Format email tidak valid.', 'danger');
                    isSubmitting = false;
                    return;
                }

                if (payload.password.length < 8) {
                    fallbackToast('Password minimal 8 karakter.', 'danger');
                    isSubmitting = false;
                    return;
                }

                if (payload.password !== payload.password_confirmation) {
                    fallbackToast('Konfirmasi password tidak cocok.', 'danger');
                    isSubmitting = false;
                    return;
                }

                const oldHtml = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...`;

                // add timeout to avoid spinner stuck if fetch hangs (increased to 30s for slow networks)
                const controller = new AbortController();
                const timeoutMs = 30000; // 30s timeout
                const timeoutId = setTimeout(() => controller.abort(), timeoutMs);
                try {
                    const res = await fetch('/api/pendaftaran', {
                        method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload), signal: controller.signal
                    });
                    clearTimeout(timeoutId);
                    console.log('[register] fetch response received', { status: res.status, ok: res.ok });

                    // Clone response to read body
                    let data = {};
                    try {
                        const contentType = res.headers.get('content-type');
                        if (contentType && contentType.includes('application/json')) {
                            data = await res.json();
                            console.log('[register] response data', data);
                        } else {
                            const text = await res.text();
                            console.log('[register] response not json', { status: res.status, body: text.slice(0, 200) });
                            data = { message: `Server returned non-JSON (${res.status})` };
                        }
                    } catch (parseErr) {
                        console.error('[register] failed to parse response', parseErr);
                        data = { message: 'Failed to parse server response' };
                    }

                    if (!res.ok) {
                        throw new Error(data.message || `HTTP ${res.status}: ${res.statusText}`);
                    }

                    console.log('[register] submission successful', { id: data.id, kode: data.kode_pendaftaran });

                    // Show success UI in Step 4
                    const confirmHeader = document.getElementById('confirm-header');
                    const confirmBody = document.getElementById('confirm-body');
                    if (confirmHeader) confirmHeader.style.display = 'none';
                    if (confirmBody) confirmBody.style.display = 'none';
                    document.getElementById('reg-success').classList.add('show');
                    document.getElementById('step-actions').style.display = 'none';

                    // Redirect after 2.5s to ensure UI updates
                    setTimeout(() => {
                        console.log('[register] redirecting to login');
                        window.location.href = '{{ route('auth.login') }}';
                    }, 2500);

                    // Hindari watchdog mengubah UI saat redirect sudah terjadi
                    delete btn.dataset.disabledSince;
                } catch (err) {
                    clearTimeout(timeoutId);
                    console.error('[register] submit failed', { name: err.name, message: err.message });
                    if (err && err.name === 'AbortError') {
                        fallbackToast('Permintaan melebihi waktu tunggu. Coba lagi.', 'danger');
                    } else {
                        fallbackToast(err.message || 'Gagal mendaftar. Coba lagi.', 'danger');
                    }
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = oldHtml;
                    isSubmitting = false;
                    console.log('[register] submission complete', { isSubmitting, btnDisabled: btn.disabled });
                }
            }

            // Expose manual debug trigger so user can call from console
            window.submitRegisterForDebug = function() {
                const btn = document.getElementById('btn-next');
                console.log('[register] manual trigger called, payload=', collectPayload());
                return submitRegistration(btn || { innerHTML: 'debug' });
            };

            // Debug helper: expose collector
            window._collectRegisterPayload = collectPayload;

            // Watchdog: if the register button stays disabled (>12s), reset it and notify the user
            (function registerWatchdog(){
                const BTN_ID = 'btn-next';
                const MAX_MS = 35000; // Slightly longer than fetch timeout to catch real hangs
                setInterval(() => {
                    try {
                        const b = document.getElementById(BTN_ID);
                        if (!b) return;
                        const now = Date.now();
                        // use dataset to track when it was disabled
                        if (b.disabled) {
                            if (!b.dataset.disabledSince) b.dataset.disabledSince = now;
                            const since = parseInt(b.dataset.disabledSince || now, 10);
                            if (now - since > MAX_MS) {
                                // reset button and inform user - AND reset the submission flag
                                b.disabled = false;
                                isSubmitting = false;
                                // restore basic label if innerHTML stuck
                                if (b.innerText && b.innerText.toLowerCase().includes('memproses')) {
                                    b.innerHTML = 'Kirim Pendaftaran <i class="bi bi-send ms-1"></i>';
                                }
                                fallbackToast('Permintaan melebihi waktu tunggu. Tombol dikembalikan. Silakan coba lagi.', 'warning');
                                delete b.dataset.disabledSince;
                                console.log('[watchdog] reset submission flag and button after timeout');
                            }
                        } else {
                            if (b.dataset.disabledSince) delete b.dataset.disabledSince;
                        }
                    } catch (e) { /* ignore */ }
                }, 2000);
            })();

            // ─────────────────────────────────────────────
            //  MULTI-STEP WIZARD NAVIGATION
            // ─────────────────────────────────────────────
            let currentStep = 1;
            const TOTAL_STEPS = 5;

            const btnNext = document.getElementById('btn-next');
            const btnBack = document.getElementById('btn-back');

            // Intro Selection Cards Click Event Listeners
            const cardSelf = document.getElementById('select-card-self');
            const cardWali = document.getElementById('select-card-wali');
            
            if (cardSelf) {
                cardSelf.addEventListener('click', function () {
                    document.getElementById('reg-tipe-pendaftar').value = 'self';
                    document.getElementById('selection-screen').style.display = 'none';
                    document.getElementById('wizard-form-container').style.display = 'block';
                    updateTipeUi();
                    goToStep(1);
                });
            }

            if (cardWali) {
                cardWali.addEventListener('click', function () {
                    document.getElementById('reg-tipe-pendaftar').value = 'wali';
                    document.getElementById('selection-screen').style.display = 'none';
                    document.getElementById('wizard-form-container').style.display = 'block';
                    updateTipeUi();
                    goToStep(1);
                });
            }

            function renderStepIndicators(isMandiri) {
                const indicator = document.getElementById('step-indicator');
                if (!indicator) return;
                
                if (isMandiri) {
                    indicator.innerHTML = `
                        <div class="step-item active" data-step="1" data-step-label-num="1">
                            <div class="step-circle" id="sc-1">1</div>
                            <div class="step-label">Informasi<br>Siswa</div>
                        </div>
                        <div class="step-item" data-step="3" data-step-label-num="2">
                            <div class="step-circle" id="sc-3">2</div>
                            <div class="step-label">Program &amp;<br>Jadwal</div>
                        </div>
                        <div class="step-item" data-step="4" data-step-label-num="3">
                            <div class="step-circle" id="sc-4">3</div>
                            <div class="step-label">Buat Akun</div>
                        </div>
                        <div class="step-item" data-step="5" data-step-label-num="4">
                            <div class="step-circle" id="sc-5">4</div>
                            <div class="step-label">Konfirmasi</div>
                        </div>
                    `;
                } else {
                    indicator.innerHTML = `
                        <div class="step-item active" data-step="1" data-step-label-num="1">
                            <div class="step-circle" id="sc-1">1</div>
                            <div class="step-label">Informasi<br>Siswa</div>
                        </div>
                        <div class="step-item" data-step="2" data-step-label-num="2">
                            <div class="step-circle" id="sc-2">2</div>
                            <div class="step-label">Informasi<br>Orang Tua</div>
                        </div>
                        <div class="step-item" data-step="3" data-step-label-num="3">
                            <div class="step-circle" id="sc-3">3</div>
                            <div class="step-label">Program &amp;<br>Jadwal</div>
                        </div>
                        <div class="step-item" data-step="4" data-step-label-num="4">
                            <div class="step-circle" id="sc-4">4</div>
                            <div class="step-label">Buat Akun</div>
                        </div>
                        <div class="step-item" data-step="5" data-step-label-num="5">
                            <div class="step-circle" id="sc-5">5</div>
                            <div class="step-label">Konfirmasi</div>
                        </div>
                    `;
                }
            }

            function updateTipeUi() {
                const isMandiri = document.getElementById('reg-tipe-pendaftar').value === 'self';
                renderStepIndicators(isMandiri);
            }

            function getVal(id) { return document.getElementById(id)?.value?.trim() || ''; }

            function validateStep(step) {
                if (step === 1) {
                    if (!getVal('reg-nama-lengkap')) { fallbackToast('Nama lengkap wajib diisi.', 'danger'); return false; }
                    if (!getVal('reg-tanggal-lahir')) { fallbackToast('Tanggal lahir wajib diisi.', 'danger'); return false; }
                    if (!document.getElementById('reg-jenis-kelamin').value) { fallbackToast('Jenis kelamin wajib dipilih.', 'danger'); return false; }
                    if (!getVal('reg-tempat-lahir')) { fallbackToast('Tempat lahir wajib diisi.', 'danger'); return false; }
                    if (!getVal('reg-no-whatsapp')) { fallbackToast('Nomor WhatsApp wajib diisi.', 'danger'); return false; }
                    if (!getVal('reg-alamat')) { fallbackToast('Alamat wajib diisi.', 'danger'); return false; }
                }
                if (step === 2) {
                    const isMandiri = document.getElementById('reg-tipe-pendaftar').value === 'self';
                    if (!isMandiri) {
                        if (!getVal('reg-nama-wali')) { fallbackToast('Nama orang tua/wali wajib diisi.', 'danger'); return false; }
                        if (!document.getElementById('reg-hubungan-wali').value) { fallbackToast('Hubungan dengan siswa wajib dipilih.', 'danger'); return false; }
                        if (!getVal('reg-no-hp-wali')) { fallbackToast('Nomor HP orang tua/wali wajib diisi.', 'danger'); return false; }
                    }
                }
                if (step === 4) {
                    if (!getVal('reg-email-login')) { fallbackToast('Email untuk login wajib diisi.', 'danger'); return false; }
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailPattern.test(getVal('reg-email-login'))) { fallbackToast('Format email tidak valid.', 'danger'); return false; }
                    if (!getVal('reg-password-login')) { fallbackToast('Password wajib diisi.', 'danger'); return false; }
                    if (getVal('reg-password-login').length < 8) { fallbackToast('Password minimal 8 karakter.', 'danger'); return false; }
                    if (getVal('reg-password-login') !== getVal('reg-password-confirm')) { fallbackToast('Konfirmasi password tidak cocok.', 'danger'); return false; }
                }
                return true;
            }

            function buildConfirmation() {
                const p = collectPayload();
                const isMandiri = document.getElementById('reg-tipe-pendaftar').value === 'self';
                const val = (v) => v ? `<span class="confirm-val">${v}</span>` : `<span class="confirm-val confirm-empty">—</span>`;
                const genderLabel = p.jenis_kelamin === 'L' ? 'Laki-laki' : (p.jenis_kelamin === 'P' ? 'Perempuan' : '');
                
                let waliHtml = '';
                if (isMandiri) {
                    waliHtml = `
                        <div class="confirm-row"><span class="confirm-key">Tipe Pendaftaran</span><span class="confirm-val text-primary fw-600"><i class="bi bi-person-check me-1"></i>Saya sendiri (Siswa Mandiri / Dewasa)</span></div>
                    `;
                } else {
                    waliHtml = `
                        <div class="confirm-row"><span class="confirm-key">Nama Wali</span>${val(p.nama_wali)}</div>
                        <div class="confirm-row"><span class="confirm-key">Hubungan</span>${val(p.hubungan_wali)}</div>
                        <div class="confirm-row"><span class="confirm-key">No. HP Wali</span>${val(p.no_hp_wali || getVal('reg-no-hp-wali'))}</div>
                    `;
                }

                document.getElementById('confirm-body').innerHTML = `
                    <div class="confirm-section">
                        <div class="confirm-section-title">Informasi Siswa</div>
                        <div class="confirm-row"><span class="confirm-key">Nama Lengkap</span>${val(p.nama_lengkap)}</div>
                        <div class="confirm-row"><span class="confirm-key">Nama Panggilan</span>${val(p.nama_panggilan)}</div>
                        <div class="confirm-row"><span class="confirm-key">Tanggal Lahir</span>${val(p.tanggal_lahir)}</div>
                        <div class="confirm-row"><span class="confirm-key">Tempat Lahir</span>${val(p.tempat_lahir)}</div>
                        <div class="confirm-row"><span class="confirm-key">Jenis Kelamin</span>${val(genderLabel)}</div>
                        <div class="confirm-row"><span class="confirm-key">No. WhatsApp</span>${val(p.no_whatsapp)}</div>
                        <div class="confirm-row"><span class="confirm-key">Alamat</span>${val(p.alamat)}</div>
                    </div>
                    <div class="confirm-section">
                        <div class="confirm-section-title">Informasi Orang Tua / Wali</div>
                        ${waliHtml}
                    </div>
                    <div class="confirm-section">
                        <div class="confirm-section-title">Program & Jadwal</div>
                        <div class="confirm-row"><span class="confirm-key">Program</span>${val(p.program)}</div>
                        <div class="confirm-row"><span class="confirm-key">Jenis Program</span>${val(p.jenis_program)}</div>
                        <div class="confirm-row"><span class="confirm-key">Lokasi Les</span>${val(p.lokasi_les)}</div>
                        <div class="confirm-row"><span class="confirm-key">Instagram</span>${val(p.instagram)}</div>
                        <div class="confirm-row"><span class="confirm-key">Catatan</span>${val(p.catatan)}</div>
                    </div>
                    <div class="confirm-section">
                        <div class="confirm-section-title">Informasi Akun Login</div>
                        <div class="confirm-row"><span class="confirm-key">Email Login</span>${val(p.email)}</div>
                        <div class="confirm-row"><span class="confirm-key">Password</span>${val('Tersimpan aman')}</div>
                    </div>
                `;
            }

            function goToStep(step) {
                const isMandiri = document.getElementById('reg-tipe-pendaftar').value === 'self';
                const totalStepsNum = isMandiri ? 4 : 5;

                for (let i = 1; i <= 5; i++) {
                    const panelEl = document.getElementById(`panel-${i}`);
                    if (panelEl) panelEl.classList.remove('active');
                }
                const activePanel = document.getElementById(`panel-${step}`);
                if (activePanel) activePanel.classList.add('active');

                const stepItems = document.querySelectorAll('.step-indicator .step-item');
                stepItems.forEach(si => {
                    const targetStep = parseInt(si.getAttribute('data-step'), 10);
                    si.classList.remove('active', 'completed');
                    const sc = si.querySelector('.step-circle');
                    
                    if (targetStep < step) {
                        si.classList.add('completed');
                        if (sc) sc.innerHTML = '<i class="bi bi-check-lg" style="font-size:16px;"></i>';
                    } else if (targetStep === step) {
                        si.classList.add('active');
                        if (sc) sc.textContent = si.getAttribute('data-step-label-num');
                    } else {
                        if (sc) sc.textContent = si.getAttribute('data-step-label-num');
                    }
                });

                // progress bar
                let stepIndex = 1;
                if (isMandiri) {
                    if (step === 3) stepIndex = 2;
                    else if (step === 4) stepIndex = 3;
                    else if (step === 5) stepIndex = 4;
                } else {
                    stepIndex = step;
                }
                const progressFill = document.getElementById('reg-progress');
                if (progressFill) {
                    progressFill.style.width = ((stepIndex / totalStepsNum) * 100) + '%';
                }

                // back button text/visibility
                if (step === 1) {
                    btnBack.innerHTML = '<i class="bi bi-arrow-left"></i> Ganti Tipe';
                    btnBack.classList.remove('hidden');
                } else {
                    btnBack.innerHTML = '<i class="bi bi-arrow-left"></i> Kembali';
                    btnBack.classList.remove('hidden');
                }

                // next button label
                if (step === 5) {
                    btnNext.innerHTML = 'Kirim Pendaftaran <i class="bi bi-send ms-1"></i>';
                    buildConfirmation();
                } else {
                    btnNext.innerHTML = 'Lanjutkan <i class="bi bi-arrow-right ms-1"></i>';
                }

                currentStep = step;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            btnNext.addEventListener('click', function () {
                const isMandiri = document.getElementById('reg-tipe-pendaftar').value === 'self';
                if (currentStep < TOTAL_STEPS) {
                    if (!validateStep(currentStep)) return;
                    let next = currentStep + 1;
                    if (currentStep === 1 && isMandiri) {
                        next = 3;
                    }
                    goToStep(next);
                } else {
                    // Final step: submit
                    submitRegistration(this);
                }
            });

            btnBack.addEventListener('click', function () {
                if (currentStep === 1) {
                    // Go back to the selection screen
                    document.getElementById('wizard-form-container').style.display = 'none';
                    document.getElementById('selection-screen').style.display = 'block';
                } else {
                    const isMandiri = document.getElementById('reg-tipe-pendaftar').value === 'self';
                    let prev = currentStep - 1;
                    if (currentStep === 3 && isMandiri) {
                        prev = 1;
                    }
                    goToStep(prev);
                }
            });

        })();
    </script>

</body>
</html>
