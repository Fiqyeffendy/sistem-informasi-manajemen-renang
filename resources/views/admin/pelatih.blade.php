@extends('layouts.app')

@section('content')

{{-- Header halaman dengan judul dan tombol tambah pelatih. --}}
<div class="page-header fade-in d-flex justify-content-between align-items-center flex-wrap gap-2">
  <div>
    <h1>Data Pelatih</h1>
    <p>Kelola pelatih dan beban mengajar</p>
  </div>
  <div class="d-flex gap-2">
    <button class="btn btn-secondary btn-sm px-3" data-action="refresh-pelatih">
      <i class="bi bi-download me-1"></i> Ekspor
    </button>
    <button class="btn btn-primary btn-sm px-3" data-action="open-modal" data-target="modal-tambah-pelatih">
      <i class="bi bi-plus-lg me-1"></i> Tambah Pelatih
    </button>
  </div>
</div>

{{-- Daftar pelatih dalam bentuk tabel dengan pencarian dan status. --}}
<div class="card-custom fade-in">
  {{-- Toolbar pencarian dan informasi jumlah data pelatih. --}}

  <div class="card-body py-3 border-bottom">
    <div class="table-toolbar">
      <div class="table-toolbar-left" style="gap:8px;">
        <div class="search-input-wrap">
          <i class="bi bi-search"></i>
          <input type="text" id="search-pelatih" placeholder="Cari data...">
        </div>
        <button class="btn btn-secondary btn-sm px-3" style="display:inline-flex;align-items:center;gap:6px;">
          <i class="bi bi-funnel"></i> Filter
        </button>
      </div>
      <div class="table-toolbar-right">
        <span class="pagination-info" id="pelatih-table-summary">Memuat data...</span>
      </div>
    </div>
  </div>

  {{-- Kolom data pelatih yang diisi secara dinamis. --}}
  <div class="table-responsive">
    <table class="table table-custom table-hover mb-0">
      <thead>
        <tr>
          <th>ID</th>
          <th>PELATIH</th>
          <th>SPESIALISASI</th>
          <th>SISWA</th>
          <th>SESI/MINGGU</th>
          <th>RATING</th>
          <th>STATUS</th>
          <th style="text-align:right; width:100px;">AKSI</th>
        </tr>
      </thead>
      <tbody id="pelatih-table-body">
        <tr><td colspan="8" class="text-muted text-center py-4">Memuat data pelatih...</td></tr>
      </tbody>
    </table>
  </div>

  {{-- Navigasi halaman untuk daftar pelatih. --}}
  <div class="pagination-wrap">
    <span class="pagination-info" id="pelatih-page-summary">Menampilkan 0-0 dari 0 data</span>
    <nav>
      <ul class="pagination pagination-sm mb-0">
        <li class="page-item disabled"><a class="page-link" href="#">‹</a></li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item disabled"><a class="page-link" href="#">›</a></li>
      </ul>
    </nav>
  </div>
</div>

@endsection

