@extends('layouts.app')

@section('content')
{{-- Halaman ini menampilkan daftar pendaftaran siswa yang menunggu diproses admin. --}}

{{-- Header halaman dengan judul dan tombol tambah pendaftaran. --}}
<div class="page-header fade-in d-flex justify-content-between align-items-center flex-wrap gap-2">
  <div>
    <h1>Pendaftaran</h1>
    <p>Daftar dan kelola pendaftaran siswa</p>
  </div>
  <div class="d-flex gap-2">
    <button class="btn btn-secondary btn-sm px-3" data-action="refresh-pendaftaran">
      <i class="bi bi-download me-1"></i> Ekspor
    </button>
    <button class="btn btn-primary btn-sm px-3" data-action="open-modal" data-target="modal-tambah-pendaftaran">
      <i class="bi bi-plus-lg me-1"></i> Daftar Baru
    </button>
  </div>
</div>

{{-- Tabel pendaftaran yang akan diisi dari data dinamis. --}}
<div class="card-custom fade-in">
  <div class="card-body py-3 border-bottom">
    <div class="table-toolbar">
      <div class="table-toolbar-left" style="gap:8px;">
        <div class="search-input-wrap">
          <i class="bi bi-search"></i>
          <input type="text" id="search-pendaftaran" placeholder="Cari data...">
        </div>
        <button class="btn btn-secondary btn-sm px-3" style="display:inline-flex;align-items:center;gap:6px;">
          <i class="bi bi-funnel"></i> Filter
        </button>
      </div>
      <div class="table-toolbar-right">
        <span class="pagination-info" id="pendaftaran-table-summary">Memuat data...</span>
      </div>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-custom table-hover mb-0">
      <thead>
        <tr>
          <th>NO. REGISTRASI</th>
          <th>NAMA SISWA</th>
          <th>PROGRAM</th>
          <th>JENIS PROGRAM</th>
          <th>LOKASI LES</th>
          <th>TGL. DAFTAR</th>
          <th>STATUS</th>
          <th style="text-align:right; width:100px;">AKSI</th>
        </tr>
      </thead>
      <tbody id="pendaftaran-table-body">
        <tr><td colspan="8" class="text-muted text-center py-4">Memuat data pendaftaran...</td></tr>
      </tbody>
    </table>
  </div>

  <div class="pagination-wrap">
    <span class="pagination-info" id="pendaftaran-page-summary">Menampilkan 0-0 dari 0 data</span>
    <nav>
      <ul class="pagination pagination-sm mb-0">
        <li class="page-item disabled"><a class="page-link" href="#">‹</a></li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item disabled"><a class="page-link" href="#">›</a></li>
      </ul>
    </nav>
  </div>
</div>

{{-- Modal untuk menambahkan data pendaftaran baru. --}}
<div class="modal fade" id="modal-tambah-pendaftaran" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-700"><i class="bi bi-person-plus me-2" style="color:#1a6bff;"></i>Tambah Pendaftaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body pt-2">
        <div class="row g-3">
          <div class="col-md-6"><label class="form-label fw-600">Nama Lengkap</label><input id="pendaftaran-nama-lengkap" class="form-control" placeholder="Nama lengkap"></div>
          <div class="col-md-6"><label class="form-label fw-600">Nama Panggilan</label><input id="pendaftaran-nama-panggilan" class="form-control" placeholder="Nama panggilan (opsional)"></div>
          <div class="col-md-6"><label class="form-label fw-600">Jenis Kelamin</label><select id="pendaftaran-jenis-kelamin" class="form-select"><option value="L">Laki-laki</option><option value="P">Perempuan</option></select></div>
          <div class="col-md-6"><label class="form-label fw-600">Tempat Lahir</label><input id="pendaftaran-tempat-lahir" class="form-control" placeholder="Tempat lahir"></div>
          <div class="col-md-6"><label class="form-label fw-600">Tanggal Lahir</label><input id="pendaftaran-tanggal-lahir" class="form-control" type="date"></div>
          <div class="col-md-6"><label class="form-label fw-600">No WhatsApp</label><input id="pendaftaran-no-whatsapp" class="form-control" placeholder="0821xxxxxxx"></div>
          <div class="col-md-6"><label class="form-label fw-600">Nama Wali</label><input id="pendaftaran-nama-wali" class="form-control" placeholder="Nama orang tua / wali"></div>
          <div class="col-md-6"><label class="form-label fw-600">Hubungan Wali</label><input id="pendaftaran-hubungan-wali" class="form-control" placeholder="Ayah / Ibu / Wali"></div>
          <div class="col-12"><label class="form-label fw-600">Alamat</label><textarea id="pendaftaran-alamat" class="form-control" rows="3" placeholder="Alamat lengkap"></textarea></div>
          <div class="col-md-6"><label class="form-label fw-600">Program</label><select id="pendaftaran-program" class="form-select"><option value="">-- Pilih Program --</option><option value="Fella WaterBabies (Swimming Lessons for Toddlers)">Fella WaterBabies (Toddlers)</option><option value="Fella SwimStars (Swimming Lessons for Kids)">Fella SwimStars (Kids)</option><option value="Fella AquaFit (Swimming Lessons for Adults)">Fella AquaFit (Adults)</option><option value="Fella SwimElite (Swimming Lessons for Elite)">Fella SwimElite (Elite)</option></select></div>
          <div class="col-md-6"><label class="form-label fw-600">Jenis Program</label><select id="pendaftaran-jenis-program" class="form-select"><option value="">-- Pilih Jenis Program --</option><option value="Private">Private</option><option value="Semi-private">Semi-private</option><option value="Group">Group</option><option value="Small Group">Small Group</option></select></div>
          <div class="col-md-6"><label class="form-label fw-600">Lokasi Les</label><select id="pendaftaran-lokasi-les" class="form-select"><option value="">-- Pilih Lokasi Les --</option><option value="Perumahan Istana Mentari">Perumahan Istana Mentari</option><option value="Hotel Aston Sidoarjo">Hotel Aston Sidoarjo</option><option value="Hotel Swiss Berlinn">Hotel Swiss Berlinn</option><option value="Hotel Sofia Juanda">Hotel Sofia Juanda</option><option value="Permata Waterpark Tanggulangin">Permata Waterpark Tanggulangin</option><option value="Regency 21">Regency 21</option><option value="Premier Place Hotel Juanda">Premier Place Hotel Juanda</option><option value="Apartment Prospero Sidoarjo">Apartment Prospero Sidoarjo</option><option value="Legok Asri Park">Legok Asri Park</option></select></div>
          <div class="col-md-6"><label class="form-label fw-600">Instagram</label><input id="pendaftaran-instagram" class="form-control" placeholder="Instagram (opsional)"></div>
          <div class="col-md-6"><label class="form-label fw-600">Catatan</label><input id="pendaftaran-catatan" class="form-control" placeholder="Catatan (opsional)"></div>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-primary" data-action="save-pendaftaran" data-bs-dismiss="modal">
          <i class="bi bi-save me-1"></i>Simpan Pendaftaran
        </button>
      </div>
    </div>
  </div>
</div>

@endsection

