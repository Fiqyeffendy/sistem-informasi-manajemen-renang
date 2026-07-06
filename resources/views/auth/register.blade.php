<!DOCTYPE html>
<html lang="id">
<head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>SIMPEL-Fella – Daftar</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/variables.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/shell.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/components.css') }}" />
        <style>
            body { font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }
            /* page bg gradient */
            #page-register { min-height: 100vh; display:flex; align-items:center; justify-content:center; padding:48px 20px; background: linear-gradient(180deg,#EAF6FF 0%, #CFE8FF 100%); }
            .register-wrapper { width:100%; max-width:1200px; }
            @media(min-width:992px){ .register-grid { display:grid; grid-template-columns:45% 55%; gap:40px; align-items:center; } }
            @media(max-width:991px){ .register-grid { display:block; } }
        </style>
</head>
<body>
        <div id="page-register" class="page active">
            <div class="register-wrapper">
                <div class="register-grid">

                    <!-- LEFT: HERO -->
                    <div class="register-hero p-4 p-lg-5 text-center text-lg-start">
                        <div class="d-flex align-items-center justify-content-center justify-content-lg-start mb-4">
                            <div class="brand-icon bg-white rounded-circle d-flex align-items-center justify-content-center" style="width:64px;height:64px;box-shadow:0 6px 20px rgba(13,110,253,.12);">
                                <i class="bi bi-droplet-fill text-primary" style="font-size:28px;"></i>
                            </div>
                            <div class="ms-3">
                                <h2 class="mb-0" style="font-weight:800; color:var(--pool-deep);">SIMPEL-Fella</h2>
                                <small class="text-muted">Sistem Informasi Penjadwalan & Presensi</small>
                            </div>
                        </div>

                        <h1 class="display-6 fw-bold" style="line-height:1.05;">Belajar Renang Bersama Coach Profesional</h1>
                        <p class="lead text-muted mb-4">Daftarkan diri Anda untuk mengikuti program latihan renang dengan jadwal yang fleksibel dan pelatih berpengalaman.</p>

                        <div class="illustration mb-4">
                            <!-- simple SVG illustration: swimmer -->
                            <svg width="280" height="160" viewBox="0 0 280 160" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="280" height="160" rx="12" fill="#ffffff" opacity="0.25"/>
                                <g transform="translate(20,20)">
                                    <circle cx="40" cy="40" r="12" fill="#0EA5E9" />
                                    <path d="M12 88c20-22 62-24 88-12" stroke="#4DA8DA" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                    <path d="M110 70c8-4 18-6 28-4" stroke="#0D6EFD" stroke-width="6" stroke-linecap="round"/>
                                </g>
                            </svg>
                        </div>

                        <ul class="list-unstyled text-start" style="max-width:360px; margin:auto; margin-top:8px;">
                            <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i>Coach Profesional</li>
                            <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i>Jadwal Fleksibel</li>
                            <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i>Presensi Digital</li>
                            <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i>Monitoring Sesi Latihan</li>
                        </ul>
                    </div>

                    <!-- RIGHT: REGISTER CARD -->
                    <div class="d-flex justify-content-center">
                        <div class="register-card" style="width:100%; max-width:820px;">
                            <div class="card-body p-4 p-lg-5">
                                <h3 class="mb-1" style="font-weight:800;">Daftar Siswa Baru</h3>
                                <p class="text-muted mb-4">Isi data pendaftaran terlebih dahulu untuk memulai sesi latihan.</p>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" id="reg-nama-lengkap" class="form-control form-control-lg" placeholder="Nama lengkap" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Panggilan</label>
                                        <input type="text" id="reg-nama-panggilan" class="form-control form-control-lg" placeholder="Nama panggilan (opsional)" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select id="reg-jenis-kelamin" class="form-select form-select-lg">
                                                <option value="L">Laki-laki</option>
                                                <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tempat Lahir</label>
                                        <input type="text" id="reg-tempat-lahir" class="form-control form-control-lg" placeholder="Kota / tempat lahir" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" id="reg-tanggal-lahir" class="form-control form-control-lg" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">No WhatsApp</label>
                                        <input type="text" id="reg-no-whatsapp" class="form-control form-control-lg" placeholder="0821xxxxxxx" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Wali</label>
                                        <input type="text" id="reg-nama-wali" class="form-control form-control-lg" placeholder="Nama orang tua/wali" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Hubungan Wali</label>
                                        <input type="text" id="reg-hubungan-wali" class="form-control form-control-lg" placeholder="Ayah / Ibu / Wali" />
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Alamat</label>
                                        <textarea id="reg-alamat" class="form-control form-control-lg" rows="3" placeholder="Alamat tinggal"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Program</label>
                                        <select id="reg-program" class="form-select form-select-lg">
                                                <option value="">-- Pilih Program (opsional) --</option>
                                                <option value="Fella WaterBabies (Swimming Lessons for Toddlers)">Fella WaterBabies (Toddlers)</option>
                                                <option value="Fella SwimStars (Swimming Lessons for Kids)">Fella SwimStars (Kids)</option>
                                                <option value="Fella AquaFit (Swimming Lessons for Adults)">Fella AquaFit (Adults)</option>
                                                <option value="Fella SwimElite (Swimming Lessons for Elite)">Fella SwimElite (Elite)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Jenis Program</label>
                                        <select id="reg-jenis-program" class="form-select form-select-lg">
                                                <option value="">-- Pilih Jenis Program (opsional) --</option>
                                                <option value="Private">Private</option>
                                                <option value="Semi-private">Semi-private</option>
                                                <option value="Group">Group</option>
                                                <option value="Small Group">Small Group</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Lokasi Les</label>
                                        <select id="reg-lokasi-les" class="form-select form-select-lg">
                                                <option value="">-- Pilih Lokasi Les (opsional) --</option>
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
                                    <div class="col-md-6">
                                        <label class="form-label">Instagram</label>
                                        <input type="text" id="reg-instagram" class="form-control form-control-lg" placeholder="Instagram (opsional)" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Catatan</label>
                                        <input type="text" id="reg-catatan" class="form-control form-control-lg" placeholder="Catatan tambahan (opsional)" />
                                    </div>
                                </div>

                                <div class="d-grid gap-2 mt-4">
                                    <button class="btn btn-outline-secondary btn-lg" onclick="window.location.href='{{ route('auth.login') }}'">
                                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Login
                                    </button>
                                    <button type="button" class="btn btn-primary btn-lg" id="btn-register" data-role="register">
                                        <i class="bi bi-send me-2"></i>Daftar Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
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
                    return {
                        nama_lengkap: document.getElementById('reg-nama-lengkap')?.value?.trim(),
                        nama_panggilan: document.getElementById('reg-nama-panggilan')?.value?.trim(),
                        jenis_kelamin: document.getElementById('reg-jenis-kelamin')?.value,
                        tempat_lahir: document.getElementById('reg-tempat-lahir')?.value?.trim(),
                        tanggal_lahir: document.getElementById('reg-tanggal-lahir')?.value,
                        no_whatsapp: document.getElementById('reg-no-whatsapp')?.value?.trim(),
                        nama_wali: document.getElementById('reg-nama-wali')?.value?.trim(),
                        hubungan_wali: document.getElementById('reg-hubungan-wali')?.value?.trim(),
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
                    if (!payload.nama_lengkap || !payload.jenis_kelamin || !payload.tempat_lahir || !payload.tanggal_lahir || !payload.no_whatsapp || !payload.nama_wali || !payload.hubungan_wali || !payload.alamat) {
                        fallbackToast('Lengkapi semua data penting terlebih dahulu.', 'danger');
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
                        fallbackToast('Pendaftaran berhasil. Silakan masuk.', 'success');
                        
                        // Redirect after 1.5s to ensure UI updates
                        setTimeout(() => {
                            console.log('[register] redirecting to login');
                            window.location.href = '{{ route('auth.login') }}';
                        }, 1500);

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
                    const btn = document.getElementById('btn-register');
                    console.log('[register] manual trigger called, payload=', collectPayload());
                    return submitRegistration(btn || { innerHTML: 'debug' });
                };

                // Delegated listener only (avoid double-handler issues)
                document.body.addEventListener('click', function (e) {
                    const target = e.target;
                    if (!target) return;
                    const btn = target.closest && target.closest('#btn-register');
                    if (btn) {
                        e.preventDefault();
                        e.stopPropagation();
                        if (!isSubmitting) {
                            submitRegistration(btn);
                        }
                    }
                });


                // Debug helper: expose collector
                window._collectRegisterPayload = collectPayload;
                // Watchdog: if the register button stays disabled (>12s), reset it and notify the user
                (function registerWatchdog(){
                    const BTN_ID = 'btn-register';
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
                                        b.innerHTML = '<i class="bi bi-send me-2"></i>Daftar Sekarang';
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
            })();
        </script>
</body>
</html>
