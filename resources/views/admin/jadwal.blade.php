@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <div class="input-group" style="max-width:320px;">
    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
    <input id="jadwal-search" type="text" class="form-control" placeholder="Cari jadwal..." />
  </div>
  <button class="btn btn-primary btn-sm px-3" data-action="open-modal" data-target="modal-tambah-jadwal">
    <i class="bi bi-plus-lg me-1"></i>Tambah Jadwal
  </button>
</div>

<!-- Tabel 1: Jadwal Latihan Hari Ini -->
<div class="card-custom mb-4" style="border-left: 5px solid var(--primary, #0d6efd);">
  <div class="card-header d-flex justify-content-between align-items-center">
    <div>
      <i class="bi bi-calendar-event me-2 text-primary"></i><strong>Jadwal Latihan Hari Ini</strong>
    </div>
    <span class="badge bg-primary px-3" id="today-badge">-</span>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-custom table-hover mb-0">
        <thead>
          <tr>
            <th>Jam</th>
            <th>Siswa</th>
            <th>Pelatih</th>
            <th>Lokasi</th>
            <th>Durasi</th>
            <th>Status</th>
            <th style="width:120px;">Aksi</th>
          </tr>
        </thead>
        <tbody id="jadwal-hari-ini-tbody">
          <tr><td colspan="7" class="text-muted text-center py-3">Memuat jadwal hari ini...</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Tabel 2: Jadwal Latihan Perminggu -->
<div class="card-custom mb-4">
  <div class="card-header">
    <i class="bi bi-calendar3 me-2 text-success"></i><strong>Jadwal Latihan Perminggu</strong>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
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
            <th style="width:120px;">Aksi</th>
          </tr>
        </thead>
        <tbody id="jadwal-perminggu-tbody">
          <tr><td colspan="8" class="text-muted text-center py-3">Memuat jadwal mingguan...</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Tabel 3: Jadwal Backup -->
<div class="card-custom mb-4" style="border-left: 5px solid #fd7e14;">
  <div class="card-header d-flex justify-content-between align-items-center">
    <div>
      <i class="bi bi-calendar-check me-2 text-warning"></i><strong>Jadwal Backup</strong>
    </div>
    <span class="badge" style="background:#fd7e14;" id="backup-count-badge">-</span>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
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
            <th style="width:120px;">Aksi</th>
          </tr>
        </thead>
        <tbody id="jadwal-backup-tbody">
          <tr><td colspan="8" class="text-muted text-center py-3">Memuat jadwal backup...</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
