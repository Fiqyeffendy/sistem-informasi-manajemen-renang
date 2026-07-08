@extends('layouts.app')

@section('content')
{{-- Dashboard pelatih menampilkan ringkasan kelas, jadwal terdekat, dan panduan kerja. --}}

{{-- Banner sambutan untuk memberi konteks suasana kerja pelatih saat membuka halaman. --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="p-4 rounded-4 shadow-sm position-relative overflow-hidden text-white" 
             style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); min-height: 160px; display: flex; flex-direction: column; justify-content: center;">
            <div class="position-absolute end-0 bottom-0 opacity-10" style="font-size: 160px; transform: translate(10%, 20%); line-height: 1;">
                <i class="bi bi-droplet-fill"></i>
            </div>
            <div class="position-relative">
                <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-3 py-1 mb-2 small fw-600" style="letter-spacing: 0.5px;">
                    <i class="bi bi-shield-check me-1"></i> PANEL PELATIH
                </span>
                <h1 class="fw-800 mb-1" style="font-size: 1.75rem; letter-spacing: -0.5px;">
                    Halo, Pelatih {{ $pelatih->nama }}!
                </h1>
                <p class="mb-0 opacity-80 small" id="dynamic-greeting-text">
                    Selamat beraktivitas kembali. Tetap semangat melatih hari ini!
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Ringkasan KPI utama untuk memantau jumlah siswa, jadwal, dan presensi. --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        {{-- Kartu jumlah siswa aktif yang sedang dibina pelatih. --}}
        <div class="stat-card c1 p-4 rounded-4 shadow-sm h-100 bg-white border d-flex align-items-center">
            <div class="icon me-3 bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                <i class="bi bi-people-fill fs-5"></i>
            </div>
            <div>
                <h3 class="fw-800 text-main mb-0 fs-3">{{ $totalSiswa }}</h3>
                <p class="text-secondary small mb-0">Total Siswa Aktif</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        {{-- Kartu jumlah jadwal mengajar yang sudah terdaftar. --}}
        <div class="stat-card c3 p-4 rounded-4 shadow-sm h-100 bg-white border d-flex align-items-center">
            <div class="icon me-3 bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                <i class="bi bi-calendar3 fs-5"></i>
            </div>
            <div>
                <h3 class="fw-800 text-main mb-0 fs-3">{{ $totalJadwal }}</h3>
                <p class="text-secondary small mb-0">Jadwal Mengajar</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        {{-- Kartu jumlah presensi yang sudah dicatat. --}}
        <div class="stat-card c2 p-4 rounded-4 shadow-sm h-100 bg-white border d-flex align-items-center">
            <div class="icon me-3 bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                <i class="bi bi-clipboard-check fs-5"></i>
            </div>
            <div>
                <h3 class="fw-800 text-main mb-0 fs-3">{{ $totalPresensi }}</h3>
                <p class="text-secondary small mb-0">Presensi Dicatat</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Daftar jadwal mengajar terdekat yang harus diperhatikan. --}}
    <div class="col-12 col-lg-8">
        <div class="card-custom border shadow-sm rounded-4 bg-white overflow-hidden">
            <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="bi bi-clock-history me-2 text-primary fs-5"></i>
                    <h2 class="fw-800 text-main mb-0" style="font-size: 1.1rem;">Jadwal Mengajar Terdekat</h2>
                </div>
                <a href="{{ route('pelatih.jadwal') }}" class="text-primary small fw-600 text-decoration-none">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                @if($jadwals->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-x fs-1 opacity-40 mb-3 d-block"></i>
                        Belum ada jadwal mengajar terdaftar.
                    </div>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($jadwals as $jadwal)
                            {{-- Tampilkan tiap jadwal sebagai baris ringkas dengan detail kelas. --}}
                            <div class="list-group-item p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light text-main rounded-3 p-2.5 text-center me-3 d-flex flex-column align-items-center justify-content-center" style="min-width: 68px;">
                                        <span class="small fw-700 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px; color:#4b5563;">{{ $jadwal->hari }}</span>
                                        <span class="fw-800 text-primary" style="font-size: 1.05rem;">{{ $jadwal->jam }}</span>
                                    </div>
                                    <div>
                                        <strong class="d-block text-main mb-1 fs-6">{{ $jadwal->siswa?->nama }}</strong>
                                        <div class="d-flex align-items-center gap-2 text-secondary small">
                                            <span><i class="bi bi-geo-alt me-1"></i>{{ $jadwal->lokasi }}</span>
                                            <span>•</span>
                                            <span><i class="bi bi-clock me-1"></i>{{ $jadwal->durasi }}</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success-subtle px-3 py-1.5 fw-600">
                                    {{ ucfirst($jadwal->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Panel panduan singkat untuk membantu pelatih bekerja dengan lebih konsisten. --}}
    <div class="col-12 col-lg-4">
        <div class="card-custom border shadow-sm rounded-4 bg-white h-100 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle me-2 text-warning fs-5"></i>
                    <h2 class="fw-800 text-main mb-0" style="font-size: 1.1rem;">Panduan &amp; Informasi</h2>
                </div>
            </div>
            <div class="card-body p-4 d-flex flex-column gap-3">
                <div class="d-flex gap-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                        <i class="bi bi-1-circle-fill"></i>
                    </div>
                    <p class="text-secondary small mb-0 align-self-center">Pastikan presensi dicatat sesegera mungkin setelah kelas renang berakhir.</p>
                </div>
                <div class="d-flex gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                        <i class="bi bi-2-circle-fill"></i>
                    </div>
                    <p class="text-secondary small mb-0 align-self-center">Validasi nama siswa sebelum mengisi laporan presensi untuk mencegah kesalahan input.</p>
                </div>
                <div class="d-flex gap-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                        <i class="bi bi-3-circle-fill"></i>
                    </div>
                    <p class="text-secondary small mb-0 align-self-center">Gunakan menu <strong>Input Presensi</strong> di sidebar untuk mencatat riwayat kehadiran baru.</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script sederhana untuk mengubah sapaan sesuai jam saat halaman dibuka. --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const hour = new Date().getHours();
        const text = document.getElementById('dynamic-greeting-text');
        if (text) {
            if (hour < 11) {
                text.textContent = 'Selamat pagi, Pelatih! Tetap berikan energi positif pagi ini.';
            } else if (hour < 15) {
                text.textContent = 'Selamat siang, Pelatih! Jaga kesehatan & terhidrasi dengan baik.';
            } else if (hour < 18) {
                text.textContent = 'Selamat sore, Pelatih! Selamat melatih sesi sore hari ini.';
            } else {
                text.textContent = 'Selamat malam, Pelatih! Terima kasih atas dedikasi Anda melatih hari ini.';
            }
        }
    });
</script>
@endsection
