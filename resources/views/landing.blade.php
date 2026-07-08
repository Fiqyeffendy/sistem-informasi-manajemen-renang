{{-- Halaman landing page yang memperkenalkan brand dan program les renang. --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIMPEL-Fella | Kursus Renang Profesional</title>
    <meta name="description" content="Kursus renang profesional untuk anak, remaja, dan dewasa dengan metode aman, menyenangkan, dan terarah." />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}" />
</head>
<body>
    <header class="topbar" id="topbar">
        <a href="#home" class="brand">
            <img src="{{ asset('images/logo-swimming.svg') }}" alt="SIMPEL-Fella Logo" class="brand-logo">
            <span>SIMPEL-Fella</span>
        </a>
        <nav class="nav-links" aria-label="Navigasi utama">
            <a href="#home">Beranda</a>
            <a href="#program">Program</a>
            <a href="#gallery">Galeri</a>
            <a href="#testimonials">Testimoni</a>
            <a href="#faq">FAQ</a>
            <a href="#contact">Kontak</a>
        </nav>
        <div class="auth-buttons">
            <a href="{{ route('auth.login') }}" class="btn btn-auth-login">Masuk</a>
            <a href="{{ route('auth.register') }}" class="btn btn-primary">Daftar Sekarang</a>
        </div>
    </header>

    <main id="home">
        <section class="hero">
            <div class="hero-content">
                <span class="eyebrow">Les renang profesional untuk semua usia</span>
                <h1>Bangun percaya diri di air bersama Fella Swimming Course</h1>
                <p>SIMPEL-Fella hadir untuk membantu Anda belajar renang dengan metode yang aman, menyenangkan, dan terarah. Cocok untuk anak, remaja, dewasa, hingga mereka yang ingin meningkatkan kemampuan berenang.</p>
                <div class="hero-actions">
                    <a href="{{ route('auth.register') }}" class="btn btn-primary">Daftar Les Sekarang</a>
                    <a href="#program" class="btn btn-secondary">Lihat Program</a>
                </div>
                <div class="stats-row">
                    <div class="stat-card">
                        <strong>500+</strong>
                        <span>Siswa</span>
                    </div>
                    <div class="stat-card">
                        <strong>20+</strong>
                        <span>Pelatih</span>
                    </div>
                    <div class="stat-card">
                        <strong>4</strong>
                        <span>Program Unggulan</span>
                    </div>
                    <div class="stat-card">
                        <strong>8</strong>
                        <span>Lokasi Les</span>
                    </div>
                </div>
            </div>
            <div class="hero-visual" aria-hidden="true">
                <div class="hero-card main-card">
                    <div class="card-top">
                        <span class="chip chip-blue">Kelas Mingguan</span>
                        <span class="chip chip-soft">97%</span>
                    </div>
                    <div class="progress-ring">
                        <div class="ring-inner">+12%</div>
                    </div>
                    <div class="mini-grid">
                        <div class="mini-card">
                            <i class="bi bi-water"></i>
                            <span>Peningkatan Keterampilan</span>
                        </div>
                        <div class="mini-card">
                            <i class="bi bi-calendar2-week"></i>
                            <span>Jadwal Flexibel</span>
                        </div>
                    </div>
                </div>
                <div class="hero-card floating-card top-card">
                    <i class="bi bi-trophy"></i>
                    <div>
                        <strong>Prestasi</strong>
                        <p>Target baru tercapai</p>
                    </div>
                </div>
                <div class="hero-card floating-card bottom-card">
                    <i class="bi bi-person-check"></i>
                    <div>
                        <strong>Pelatih Pendamping</strong>
                        <p>Pendampingan personal setiap sesi</p>
                    </div>
                </div>
                <div class="wave wave-one"></div>
                <div class="wave wave-two"></div>
            </div>
        </section>

        <section class="trusted-by">
            <p>Dipercaya oleh komunitas sekolah, klub, dan keluarga yang ingin belajar renang dengan nyaman</p>
            <div class="logo-row">
                <span>BlueWave</span>
                <span>Ocean Kids</span>
                <span>Swift Club</span>
                <span>AquaStars</span>
                <span>Wave Academy</span>
            </div>
        </section>

        <section class="section why-section">
            <div class="section-heading">
                <span class="eyebrow">Mengapa Orang Tua Percaya</span>
                <h2>Kursus renang yang aman, terarah, dan nyaman untuk anak Anda</h2>
                <p>Program kami dirancang agar anak belajar dengan tenang, orang tua merasa terbantu, dan setiap sesi terasa lebih berarti.</p>
            </div>
            <div class="why-grid">
                <div class="why-item"><i class="bi bi-shield-check"></i><div><h3>Pelatih Profesional</h3><p>Instruktur berpengalaman yang sabar dan aman dalam mengajar setiap level.</p></div></div>
                <div class="why-item"><i class="bi bi-laptop"></i><div><h3>Informasi Terpadu</h3><p>Semua data les, jadwal, dan perkembangan bisa dipantau dengan mudah.</p></div></div>
                <div class="why-item"><i class="bi bi-journal-check"></i><div><h3>Pendaftaran Praktis</h3><p>Proses daftar yang simpel dan cepat untuk orang tua maupun siswa.</p></div></div>
                <div class="why-item"><i class="bi bi-eye"></i><div><h3>Perkembangan Jelas</h3><p>Setiap kemajuan siswa dapat dilihat dengan lebih transparan dan terarah.</p></div></div>
            </div>
        </section>

        <section class="section" id="features">
            <div class="section-heading">
                <span class="eyebrow">Kenapa Pilih Kami</span>
                <h2>Pelayanan les renang yang aman, terarah, dan menyenangkan</h2>
                <p>Setiap program dirancang untuk membantu siswa belajar dengan nyaman, percaya diri, dan tetap termotivasi.</p>
            </div>
            <div class="card-grid">
                <article class="info-card">
                    <div class="icon-wrap"><i class="bi bi-people"></i></div>
                    <h3>Program yang Sesuai Usia</h3>
                    <p>Les disesuaikan untuk anak, remaja, dan dewasa agar setiap siswa merasa nyaman belajar.</p>
                </article>
                <article class="info-card">
                    <div class="icon-wrap"><i class="bi bi-person-plus"></i></div>
                    <h3>Pendaftaran Mudah</h3>
                    <p>Proses pendaftaran yang simpel sehingga orang tua bisa langsung mendaftarkan anak dengan cepat.</p>
                </article>
                <article class="info-card">
                    <div class="icon-wrap"><i class="bi bi-clipboard-check"></i></div>
                    <h3>Absensi Teratur</h3>
                    <p>Setiap sesi dicatat dengan rapi agar perkembangan belajar lebih mudah dipantau.</p>
                </article>
                <article class="info-card">
                    <div class="icon-wrap"><i class="bi bi-calendar3"></i></div>
                    <h3>Jadwal Fleksibel</h3>
                    <p>Jadwal les yang disusun sesuai kebutuhan siswa dan keluarga agar lebih praktis.</p>
                </article>
                <article class="info-card">
                    <div class="icon-wrap"><i class="bi bi-person-badge"></i></div>
                    <h3>Pelatih Profesional</h3>
                    <p>Didukung oleh pelatih berpengalaman yang sabar, aman, dan siap membimbing setiap siswa.</p>
                </article>
                <article class="info-card">
                    <div class="icon-wrap"><i class="bi bi-graph-up"></i></div>
                    <h3>Perkembangan Terpantau</h3>
                    <p>Orang tua bisa melihat perkembangan belajar anak secara jelas dari setiap sesi.</p>
                </article>
            </div>
        </section>

        <section class="section" id="program">
            <div class="section-heading">
                <span class="eyebrow">Program Les</span>
                <h2>Pilih program yang sesuai untuk setiap usia dan level</h2>
                <p>Kami menyediakan program renang profesional yang dirancang khusus untuk setiap kelompok usia, dari bayi hingga dewasa.</p>
            </div>
            <div class="program-grid">
                <article class="program-card">
                    <div class="program-image beginner"></div>
                    <div class="program-body">
                        <h3>Fella WaterBabies</h3>
                        <p class="program-subtitle">Untuk Balita (0-3 tahun)</p>
                        <p>Pengenalan air dengan permainan menyenangkan dan aman untuk bayi dan balita kecil.</p>
                        <ul>
                            <li>Adaptasi air yang aman</li>
                            <li>Permainan air interaktif</li>
                            <li>Sesi singkat & fleksibel</li>
                        </ul>
                        <a href="{{ route('auth.register') }}" class="text-link">Daftar Sekarang</a>
                    </div>
                </article>
                <article class="program-card">
                    <div class="program-image intermediate"></div>
                    <div class="program-body">
                        <h3>Fella SwimStars</h3>
                        <p class="program-subtitle">Untuk Anak-anak (4-12 tahun)</p>
                        <p>Program renang komprehensif dengan fokus teknik dasar, keamanan, dan kepercayaan diri anak.</p>
                        <ul>
                            <li>Dasar renang lengkap</li>
                            <li>Keselamatan di air</li>
                            <li>Pembangunan kepercayaan diri</li>
                        </ul>
                        <a href="{{ route('auth.register') }}" class="text-link">Daftar Sekarang</a>
                    </div>
                </article>
                <article class="program-card">
                    <div class="program-image advanced"></div>
                    <div class="program-body">
                        <h3>Fella AquaFit</h3>
                        <p class="program-subtitle">Untuk Dewasa (13+ tahun)</p>
                        <p>Program khusus untuk remaja dan dewasa dengan fokus teknik, stamina, dan kesehatan.</p>
                        <ul>
                            <li>Teknik renang profesional</li>
                            <li>Latihan stamina & kondisi</li>
                            <li>Fleksibilitas jadwal</li>
                        </ul>
                        <a href="{{ route('auth.register') }}" class="text-link">Daftar Sekarang</a>
                    </div>
                </article>
                <article class="program-card">
                    <div class="program-image beginner"></div>
                    <div class="program-body">
                        <h3>Fella SwimElite</h3>
                        <p class="program-subtitle">Untuk Atlet (Kompetisi)</p>
                        <p>Program intensif untuk perenang berprestasi dengan pelatihan profesional dan program kompetisi.</p>
                        <ul>
                            <li>Pelatihan intensif</li>
                            <li>Persiapan kompetisi</li>
                            <li>Nutrisi & analisis performa</li>
                        </ul>
                        <a href="{{ route('auth.register') }}" class="text-link">Daftar Sekarang</a>
                    </div>
                </article>
            </div>
        </section>

        <section class="section timeline-section">
            <div class="section-heading">
                <span class="eyebrow">Alur Belajar</span>
                <h2>Dari pendaftaran hingga pencapaian, semuanya berjalan sederhana</h2>
            </div>
            <div class="timeline">
                <div class="timeline-item">
                    <span>1</span>
                    <h3>Daftar</h3>
                    <p>Daftarkan diri atau anak Anda ke program les yang paling sesuai.</p>
                </div>
                <div class="timeline-item">
                    <span>2</span>
                    <h3>Atur Jadwal</h3>
                    <p>Pilih waktu les yang fleksibel sesuai kebutuhan keluarga.</p>
                </div>
                <div class="timeline-item">
                    <span>3</span>
                    <h3>Ikuti Les</h3>
                    <p>Belajar renang dengan bimbingan pelatih yang aman dan terarah.</p>
                </div>
                <div class="timeline-item">
                    <span>4</span>
                    <h3>Perkembangan & Prestasi</h3>
                    <p>Pantau perkembangan dan raih pencapaian bersama setiap sesi.</p>
                </div>
            </div>
        </section>

        <section class="section" id="gallery">
            <div class="section-heading">
                <span class="eyebrow">Galeri</span>
                <h2>Momen seru dan pencapaian siswa kami</h2>
            </div>
            <div class="gallery-grid">
                <div class="gallery-item tall">
                    <img src="{{ asset('images/swimmer-freestyle.jpg') }}" alt="Siswa berenang gaya bebas" />
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('images/swimmer-butterfly.jpg') }}" alt="Siswa renang gaya kupu-kupu" />
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('images/kids-swimming.jpg') }}" alt="Anak-anak belajar renang" />
                </div>
                <div class="gallery-item wide">
                    <img src="{{ asset('images/young-swimmer-happy.jpg') }}" alt="Siswa muda bahagia di kolam" />
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('images/indoor-pool.jpg') }}" alt="Kolam renang indoor modern" />
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('images/competitive-swimmer.jpg') }}" alt="Atlet renang kompetitif" />
                </div>
            </div>
        </section>

        <section class="section" id="testimonials">
            <div class="section-heading">
                <span class="eyebrow">Testimoni</span>
                <h2>Apa kata orang tua dan siswa tentang pengalaman les kami</h2>
            </div>
            <div class="testimonial-grid">
                <article class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p>“Saya senang karena jadwal dan perkembangan belajar anak jadi lebih mudah dipantau.”</p>
                    <div class="person">
                        <div class="avatar">AR</div>
                        <div>
                            <strong>Ayu R.</strong>
                            <span>Orang Tua</span>
                        </div>
                    </div>
                </article>
                <article class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p>“Saya sebagai pelatih merasa lebih mudah mengatur jadwal dan memantau perkembangan siswa.”</p>
                    <div class="person">
                        <div class="avatar">RM</div>
                        <div>
                            <strong>Rizal M.</strong>
                            <span>Pelatih</span>
                        </div>
                    </div>
                </article>
                <article class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p>“Saya jadi lebih semangat belajar karena jadwal dan progres lesnya jelas dan teratur.”</p>
                    <div class="person">
                        <div class="avatar">NF</div>
                        <div>
                            <strong>Nadia F.</strong>
                            <span>Siswa</span>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <section class="stats-section">
            <div class="stat-block"><strong>1,200+</strong><span>Siswa Aktif</span></div>
            <div class="stat-block"><strong>35+</strong><span>Pelatih</span></div>
            <div class="stat-block"><strong>92%</strong><span>Berhasil Naik Level</span></div>
            <div class="stat-block"><strong>4.8/5</strong><span>Rating Orang Tua</span></div>
        </section>

        <section class="section" id="faq">
            <div class="section-heading">
                <span class="eyebrow">FAQ</span>
                <h2>Pertanyaan yang sering ditanyakan</h2>
            </div>
            <div class="faq-list">
                <details class="faq-item" open>
                    <summary>Apakah ada program yang cocok untuk balita?</summary>
                    <p>Ya. Program Fella WaterBabies dirancang khusus untuk balita dengan pendekatan aman, santai, dan penuh permainan.</p>
                </details>
                <details class="faq-item">
                    <summary>Apakah ada program untuk anak, remaja, dan dewasa?</summary>
                    <p>Tentu. Kami menyediakan Fella SwimStars untuk anak, Fella AquaFit untuk remaja dan dewasa, serta Fella SwimElite untuk atlet atau yang ingin fokus pada kompetisi.</p>
                </details>
                <details class="faq-item">
                    <summary>Bagaimana cara memilih jadwal yang sesuai?</summary>
                    <p>Anda dapat memilih jadwal yang paling nyaman berdasarkan kebutuhan keluarga, lokasi les, dan target belajar masing-masing siswa.</p>
                </details>
                <details class="faq-item">
                    <summary>Apakah orang tua bisa memantau perkembangan siswa?</summary>
                    <p>Ya. Orang tua bisa melihat perkembangan belajar, kehadiran, dan pencapaian siswa dari setiap sesi secara lebih jelas.</p>
                </details>
                <details class="faq-item">
                    <summary>Apakah ada pilihan lokasi les yang fleksibel?</summary>
                    <p>Ya. Kami menyediakan beberapa lokasi les yang dapat dipilih sesuai kenyamanan dan kemudahan akses keluarga.</p>
                </details>
            </div>
        </section>

        <section class="cta-section" id="contact">
            <h2>Siap mulai perjalanan renang Anda?</h2>
            <p>Daftarkan diri atau anak Anda sekarang dan rasakan pengalaman les renang yang lebih terarah, aman, dan menyenangkan.</p>
            <div class="hero-actions">
                <a href="{{ route('auth.register') }}" class="btn btn-primary">Daftar Sekarang</a>
                <a href="mailto:hello@simpelfella.id" class="btn btn-secondary">Hubungi Kami</a>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div>
            <h3>SIMPEL-Fella</h3>
            <p>Kursus renang yang membantu anak tumbuh lebih percaya diri, aman di air, dan semangat belajar setiap minggu.</p>
        </div>
        <div>
            <h4>Program</h4>
            <a href="#program">Fella WaterBabies</a>
            <a href="#program">Fella SwimStars</a>
            <a href="#program">Fella AquaFit</a>
            <a href="#program">Fella SwimElite</a>
        </div>
        <div>
            <h4>Bantuan</h4>
            <a href="#faq">FAQ</a>
            <a href="mailto:hello@simpelfella.id">Kontak</a>
            <a href="{{ route('auth.login') }}">Login</a>
        </div>
        <div>
            <h4>Kontak</h4>
            <span>hello@simpelfella.id</span>
            <span>+62 812 3456 7890</span>
            <span>Surabaya, Indonesia</span>
        </div>
    </footer>

    <script>
        const topbar = document.getElementById('topbar');
        if (topbar) {
            window.addEventListener('scroll', () => {
                topbar.classList.toggle('scrolled', window.scrollY > 20);
            });
        }
    </script>
</body>
</html>
