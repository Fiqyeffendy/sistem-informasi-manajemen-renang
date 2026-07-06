@extends('layouts.app')

@section('content')
<div class="row g-3 mb-3">
  <div class="col-12 col-lg-3">
    <div class="stat-card c1">
      <div class="icon"><i class="bi bi-house"></i></div>
      <h2>Beranda</h2><p>Halo Siswa</p>
    </div>
  </div>
  <div class="col-12 col-lg-3">
    <div class="stat-card c2">
      <div class="icon"><i class="bi bi-calendar3"></i></div>
      <h2>2</h2><p>Jadwal Minggu Ini</p>
    </div>
  </div>
  <div class="col-12 col-lg-3">
    <div class="stat-card c4">
      <div class="icon"><i class="bi bi-hourglass-split"></i></div>
      <h2>9</h2><p>Sisa Sesi</p>
    </div>
  </div>
  <div class="col-12 col-lg-3">
    <div class="stat-card c3">
      <div class="icon"><i class="bi bi-clipboard-check"></i></div>
      <h2>5</h2><p>Presensi</p>
    </div>
  </div>
</div>

<div class="card-custom">
  <div class="card-header">
    <i class="bi bi-bell me-2 text-primary"></i>Pengumuman (Demo)
  </div>
  <div class="card-body">
    <div class="mb-2">• Jadwal latihan mungkin berubah jika cuaca buruk.</div>
    <div class="mb-2">• Pastikan membawa perlengkapan latihan.</div>
    <div class="mb-0">• Gunakan menu Jadwal dan Riwayat Presensi untuk cek data.</div>
  </div>
</div>
@endsection
