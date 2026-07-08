@extends('layouts.app')

@section('content')
{{-- Halaman ini menampilkan daftar siswa dengan pencarian dan aksi CRUD melalui modal. --}}
{{-- Header halaman yang menampilkan judul dan tombol utama. --}}
<div class="page-header fade-in d-flex justify-content-between align-items-center flex-wrap gap-2">
  <div>
    <h1>Data Siswa</h1>
    <p>Kelola semua siswa yang terdaftar</p>
  </div>
  <div class="d-flex gap-2">
    <!-- Tombol refresh akan ditangani oleh JavaScript pada resources/js/main.js -->
    <button class="btn btn-secondary btn-sm px-3" data-action="refresh-siswa">
      <i class="bi bi-arrow-clockwise"></i> Refresh
    </button>
    <!-- Tombol tambah siswa membuka modal input data siswa. -->
    <button class="btn btn-primary btn-sm px-3" data-action="open-modal" data-target="modal-tambah-siswa">
      <i class="bi bi-plus-lg"></i> Tambah Siswa
    </button>
  </div>
</div>

{{-- Kartu utama yang berisi toolbar pencarian, tabel siswa, dan navigasi halaman. --}}
<div class="card-custom fade-in">
  {{-- Toolbar pencarian dan ringkasan data siswa. --}}
  <div class="card-body py-3 border-bottom">
    <div class="table-toolbar">
      <div class="table-toolbar-left">
        <!-- Pencarian siswa: dihubungkan dengan pencarian di JavaScript. -->
        <div class="search-input-wrap">
          <i class="bi bi-search"></i>
          <input type="text" id="siswa-search-input" placeholder="Cari siswa...">
        </div>
      </div>
      <div class="table-toolbar-right">
        <!-- Ringkasan jumlah data ditampilkan melalui JavaScript saat data berhasil dimuat. -->
        <span class="pagination-info" id="siswa-count-summary">0 data ditemukan</span>
      </div>
    </div>
  </div>

  {{-- Tabel daftar siswa yang akan diisi dari data API. --}}
  <div class="table-responsive">
    <table class="table table-custom table-hover mb-0">
      <thead>
        <tr>
          <th>No</th>
          <th>ID</th>
          <th>Nama Siswa</th>
          <th>Umur</th>
          <th>Program</th>
          <th>Jenis Program</th>
          <th>Lokasi Les</th>
          <th>Total Sesi</th>
          <th>Sisa Sesi</th>
          <th style="width: 100px; text-align: right;">Aksi</th>
        </tr>
      </thead>
      <tbody id="siswa-table-body">
        <!-- Baris ini muncul saat data sedang dimuat. JavaScript nanti akan menggantinya. -->
        <tr>
          <td colspan="10" class="text-muted text-center py-4">Memuat data siswa...</td>
        </tr>
      </tbody>
    </table>
  </div>

  {{-- Bagian navigasi halaman daftar siswa. --}}
  <div class="pagination-wrap">
    <span class="pagination-info" id="siswa-table-summary">Menampilkan 0-0 dari 0 data</span>
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
