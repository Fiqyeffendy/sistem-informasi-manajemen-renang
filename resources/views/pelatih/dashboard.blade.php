@extends('layouts.app')

@section('content')
<div class="row g-3 mb-3">
  <div class="col-12 col-lg-3">
    <div class="stat-card c1">
      <div class="icon"><i class="bi bi-people-fill"></i></div>
      <h2>12</h2><p>Jumlah Siswa</p>
    </div>
  </div>
  <div class="col-12 col-lg-3">
    <div class="stat-card c3">
      <div class="icon"><i class="bi bi-calendar3"></i></div>
      <h2>4</h2><p>Jadwal Minggu Ini</p>
    </div>
  </div>
  <div class="col-12 col-lg-3">
    <div class="stat-card c4">
      <div class="icon"><i class="bi bi-hourglass-split"></i></div>
      <h2>18</h2><p>Sesi Terjadwal</p>
    </div>
  </div>
  <div class="col-12 col-lg-3">
    <div class="stat-card c2">
      <div class="icon"><i class="bi bi-clipboard-check"></i></div>
      <h2>56</h2><p>Presensi Dicatat</p>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-12 col-lg-7">
    <div class="card-custom">
      <div class="card-header">
        <i class="bi bi-clock-history me-2 text-primary"></i>Jadwal Pelatih (Mendatang)
      </div>
      <div class="card-body p-3">
        <div class="schedule-item">
          <div class="schedule-time">Senin<small></small></div>
          <div class="schedule-info flex-grow-1"><strong>06:00</strong><small>Kolam 1 | Kelompok A</small></div>
          <span class="badge rounded-pill badge-aktif">Aktif</span>
        </div>
        <div class="schedule-item">
          <div class="schedule-time">Rabu<small></small></div>
          <div class="schedule-info flex-grow-1"><strong>15:00</strong><small>Kolam Lomba | Kelompok C</small></div>
          <span class="badge rounded-pill badge-aktif">Aktif</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-5">
    <div class="card-custom h-100">
      <div class="card-header"><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Catatan</div>
      <div class="card-body p-3">
        <div class="mb-2">• Pastikan perangkat presensi siap sebelum sesi dimulai.</div>
        <div class="mb-2">• Validasi siswa sebelum mengisi presensi.</div>
        <div class="mb-0">• Gunakan menu <strong>Input Presensi</strong> untuk pencatatan harian.</div>
      </div>
    </div>
  </div>
</div>
@endsection
