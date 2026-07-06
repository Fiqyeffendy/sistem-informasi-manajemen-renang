@extends('layouts.app')

@section('content')
<div id="dashboard-admin" class="section fade-in">
  <div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
      <div class="stat-card c1">
        <div class="icon"><i class="bi bi-people-fill"></i></div>
        <h2>48</h2><p>Total Siswa</p>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card c2">
        <div class="icon"><i class="bi bi-person-badge-fill"></i></div>
        <h2>7</h2><p>Total Pelatih</p>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card c3">
        <div class="icon"><i class="bi bi-calendar-day-fill"></i></div>
        <h2>12</h2><p>Jadwal Hari Ini</p>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card c4">
        <div class="icon"><i class="bi bi-clipboard2-check-fill"></i></div>
        <h2>315</h2><p>Total Presensi</p>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-lg-7">
      <div class="card-custom">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span><i class="bi bi-calendar3 me-2 text-primary"></i>Jadwal Latihan Hari Ini</span>
          <span class="badge" style="background:var(--foam);color:var(--pool-mid);">Senin, 29 Jun 2026</span>
        </div>
        <div class="card-body p-3">
          <div class="schedule-item">
            <div class="schedule-time">06:00<small>AM</small></div>
            <div class="schedule-info flex-grow-1">
              <strong>Kelompok A – Pemula</strong>
              <small><i class="bi bi-person-badge me-1"></i>Pak Rizal &nbsp;|&nbsp; <i class="bi bi-water me-1"></i>Kolam 1</small>
            </div>
            <span class="badge rounded-pill badge-aktif">Aktif</span>
          </div>
          <div class="schedule-item">
            <div class="schedule-time">07:00<small>AM</small></div>
            <div class="schedule-info flex-grow-1">
              <strong>Kelompok B – Menengah</strong>
              <small><i class="bi bi-person-badge me-1"></i>Bu Sari &nbsp;|&nbsp; <i class="bi bi-water me-1"></i>Kolam 2</small>
            </div>
            <span class="badge rounded-pill badge-aktif">Aktif</span>
          </div>
          <div class="schedule-item">
            <div class="schedule-time">15:00<small>PM</small></div>
            <div class="schedule-info flex-grow-1">
              <strong>Kelompok C – Kompetisi</strong>
              <small><i class="bi bi-person-badge me-1"></i>Pak Doni &nbsp;|&nbsp; <i class="bi bi-water me-1"></i>Kolam Lomba</small>
            </div>
            <span class="badge rounded-pill badge-penuh">Penuh</span>
          </div>
          <div class="schedule-item">
            <div class="schedule-time">16:00<small>PM</small></div>
            <div class="schedule-info flex-grow-1">
              <strong>Kelompok D – Lanjutan</strong>
              <small><i class="bi bi-person-badge me-1"></i>Bu Rini &nbsp;|&nbsp; <i class="bi bi-water me-1"></i>Kolam 1</small>
            </div>
            <span class="badge rounded-pill badge-aktif">Aktif</span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card-custom h-100">
        <div class="card-header">
          <i class="bi bi-exclamation-triangle me-2 text-warning"></i>Sesi Hampir Habis
        </div>
        <div class="card-body p-3">
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
              <span class="fw-600" style="font-size:.87rem;">Rafi Pratama</span>
              <span class="badge badge-sisa-low px-2">2 sesi</span>
            </div>
            <div class="sesi-bar"><div class="fill fill-low" style="width:10%"></div></div>
          </div>
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
              <span style="font-size:.87rem;">Nadia Kusuma</span>
              <span class="badge badge-sisa-warn px-2">4 sesi</span>
            </div>
            <div class="sesi-bar"><div class="fill fill-warn" style="width:20%"></div></div>
          </div>
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
              <span style="font-size:.87rem;">Bagas Wirawan</span>
              <span class="badge badge-sisa-warn px-2">5 sesi</span>
            </div>
            <div class="sesi-bar"><div class="fill fill-warn" style="width:25%"></div></div>
          </div>
          <div class="mb-2">
            <div class="d-flex justify-content-between mb-1">
              <span style="font-size:.87rem;">Citra Dewi</span>
              <span class="badge badge-sisa-ok px-2">8 sesi</span>
            </div>
            <div class="sesi-bar"><div class="fill fill-ok" style="width:40%"></div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
