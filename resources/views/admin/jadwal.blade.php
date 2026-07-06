@extends('layouts.app')

@section('content')

{{-- Page Header --}}
<div class="page-header fade-in d-flex justify-content-between align-items-center flex-wrap gap-2">
  <div>
    <h1>Jadwal Kelas</h1>
    <p>Atur jadwal dan sesi kelas renang</p>
  </div>
  <div class="d-flex gap-2">
    <button class="btn btn-secondary btn-sm px-3" data-action="refresh-jadwal">
      <i class="bi bi-download me-1"></i> Ekspor
    </button>
    <button class="btn btn-primary btn-sm px-3" data-action="open-modal" data-target="modal-tambah-jadwal">
      <i class="bi bi-plus-lg me-1"></i> Buat Jadwal
    </button>
  </div>
</div>

{{-- Top Toolbar --}}
<div class="card-custom fade-in mb-4">
  <div class="card-body py-3">
    <div class="table-toolbar">
      <div class="table-toolbar-left" style="gap:8px;">
        <div class="search-input-wrap">
          <i class="bi bi-search"></i>
          <input type="text" id="jadwal-search" placeholder="Cari jadwal...">
        </div>
        <button class="btn btn-secondary btn-sm px-3" style="display:inline-flex;align-items:center;gap:6px;">
          <i class="bi bi-funnel"></i> Filter
        </button>
      </div>
      <div class="table-toolbar-right">
        <span class="pagination-info" id="jadwal-total-summary">Memuat data...</span>
      </div>
    </div>
  </div>
</div>

{{-- Tabel 1: Jadwal Latihan Hari Ini --}}
<div class="card-custom fade-in mb-4" style="border-left: 4px solid var(--primary, #1a6bff);">
  <div class="card-header border-bottom-0 pb-0 d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-2">
      <div class="brand-logo-small bg-primary-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
        <i class="bi bi-calendar-event" style="font-size:16px;"></i>
      </div>
      <h2 class="h6 mb-0 fw-700">Jadwal Latihan Hari Ini</h2>
    </div>
    <span class="badge badge-aktif" id="today-badge">-</span>
  </div>
  <div class="table-responsive mt-3">
    <table class="table table-custom table-hover mb-0">
      <thead>
        <tr>
          <th>Jam</th>
          <th>Siswa</th>
          <th>Pelatih</th>
          <th>Lokasi</th>
          <th>Durasi</th>
          <th>Status</th>
          <th style="text-align:right; width:100px;">Aksi</th>
        </tr>
      </thead>
      <tbody id="jadwal-hari-ini-tbody">
        <tr><td colspan="7" class="text-muted text-center py-4">Memuat jadwal hari ini...</td></tr>
      </tbody>
    </table>
  </div>
</div>

{{-- Tabel 2: Jadwal Latihan Perminggu --}}
<div class="card-custom fade-in mb-4" style="border-left: 4px solid #10b981;">
  <div class="card-header border-bottom-0 pb-0 d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-2">
      <div class="brand-logo-small bg-success-light text-success rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
        <i class="bi bi-calendar3" style="font-size:16px;"></i>
      </div>
      <h2 class="h6 mb-0 fw-700">Jadwal Latihan Perminggu</h2>
    </div>
  </div>
  <div class="table-responsive mt-3">
    <table class="table table-custom table-hover mb-0">
      <thead>
        <tr>
          <th>Hari</th>
          <th>Jam</th>
          <th>Siswa</th>
          <th>Pelatih</th>
          <th>Lokasi</th>
          <th>Durasi</th>
          <th>Status</th>
          <th style="text-align:right; width:100px;">Aksi</th>
        </tr>
      </thead>
      <tbody id="jadwal-perminggu-tbody">
        <tr><td colspan="8" class="text-muted text-center py-4">Memuat jadwal mingguan...</td></tr>
      </tbody>
    </table>
  </div>
</div>

{{-- Tabel 3: Jadwal Backup --}}
<div class="card-custom fade-in mb-4" style="border-left: 4px solid #f59e0b;">
  <div class="card-header border-bottom-0 pb-0 d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-2">
      <div class="brand-logo-small bg-warning-light text-warning rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
        <i class="bi bi-calendar-check" style="font-size:16px;"></i>
      </div>
      <h2 class="h6 mb-0 fw-700">Jadwal Backup</h2>
    </div>
    <span class="badge badge-pending" id="backup-count-badge">-</span>
  </div>
  <div class="table-responsive mt-3">
    <table class="table table-custom table-hover mb-0">
      <thead>
        <tr>
          <th>Hari</th>
          <th>Jam</th>
          <th>Siswa</th>
          <th>Pelatih</th>
          <th>Lokasi</th>
          <th>Durasi</th>
          <th>Status</th>
          <th style="text-align:right; width:100px;">Aksi</th>
        </tr>
      </thead>
      <tbody id="jadwal-backup-tbody">
        <tr><td colspan="8" class="text-muted text-center py-4">Memuat jadwal backup...</td></tr>
      </tbody>
    </table>
  </div>
</div>

@endsection

