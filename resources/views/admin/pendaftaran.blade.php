@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <div class="input-group" style="max-width:260px;">
    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
    <input type="text" id="search-pendaftaran" class="form-control" placeholder="Cari pendaftaran...">
  </div>
  <div class="d-flex gap-2 flex-wrap">
    <button class="btn btn-secondary btn-sm px-3" data-action="refresh-pendaftaran"><i class="bi bi-arrow-clockwise me-1"></i>Refresh</button>
    <button class="btn btn-primary btn-sm px-3" data-action="open-modal" data-target="modal-tambah-pendaftaran"><i class="bi bi-plus-lg me-1"></i>Tambah Pendaftaran</button>
  </div>
</div>
<div class="card-custom">
  <div class="table-responsive">
    <table class="table table-custom table-hover mb-0">
      <thead><tr><th>No</th><th>Kode</th><th>Nama</th><th>WhatsApp</th><th>Status</th><th>Tgl Daftar</th><th>Aksi</th></tr></thead>
      <tbody id="pendaftaran-table-body">
        <tr><td colspan="7" class="text-muted">Memuat data pendaftaran...</td></tr>
      </tbody>
    </table>
  </div>
  <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2 border-top py-2 px-3">
    <small class="text-muted" id="pendaftaran-table-summary">Memuat data...</small>
  </div>
</div>

<div class="modal fade" id="modal-tambah-pendaftaran" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Tambah Pendaftaran</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6"><label class="form-label">Nama Lengkap</label><input id="pendaftaran-nama-lengkap" class="form-control" placeholder="Nama lengkap"></div>
          <div class="col-md-6"><label class="form-label">Nama Panggilan</label><input id="pendaftaran-nama-panggilan" class="form-control" placeholder="Nama panggilan (opsional)"></div>
          <div class="col-md-6"><label class="form-label">Jenis Kelamin</label><select id="pendaftaran-jenis-kelamin" class="form-select"><option value="L">Laki-laki</option><option value="P">Perempuan</option></select></div>
          <div class="col-md-6"><label class="form-label">Tempat Lahir</label><input id="pendaftaran-tempat-lahir" class="form-control" placeholder="Tempat lahir"></div>
          <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input id="pendaftaran-tanggal-lahir" class="form-control" type="date"></div>
          <div class="col-md-6"><label class="form-label">No WhatsApp</label><input id="pendaftaran-no-whatsapp" class="form-control" placeholder="0821xxxxxxx"></div>
          <div class="col-md-6"><label class="form-label">Nama Wali</label><input id="pendaftaran-nama-wali" class="form-control" placeholder="Nama orang tua / wali"></div>
          <div class="col-md-6"><label class="form-label">Hubungan Wali</label><input id="pendaftaran-hubungan-wali" class="form-control" placeholder="Ayah / Ibu / Wali"></div>
          <div class="col-12"><label class="form-label">Alamat</label><textarea id="pendaftaran-alamat" class="form-control" rows="3" placeholder="Alamat lengkap"></textarea></div>
          <div class="col-md-6"><label class="form-label">Program</label><select id="pendaftaran-program" class="form-select"><option value="">-- Pilih Program --</option><option value="Fella WaterBabies (Swimming Lessons for Toddlers)">Fella WaterBabies (Toddlers)</option><option value="Fella SwimStars (Swimming Lessons for Kids)">Fella SwimStars (Kids)</option><option value="Fella AquaFit (Swimming Lessons for Adults)">Fella AquaFit (Adults)</option><option value="Fella SwimElite (Swimming Lessons for Elite)">Fella SwimElite (Elite)</option></select></div>
          <div class="col-md-6"><label class="form-label">Jenis Program</label><select id="pendaftaran-jenis-program" class="form-select"><option value="">-- Pilih Jenis Program --</option><option value="Private">Private</option><option value="Semi-private">Semi-private</option><option value="Group">Group</option><option value="Small Group">Small Group</option></select></div>
          <div class="col-md-6"><label class="form-label">Lokasi Les</label><select id="pendaftaran-lokasi-les" class="form-select"><option value="">-- Pilih Lokasi Les --</option><option value="Perumahan Istana Mentari">Perumahan Istana Mentari</option><option value="Hotel Aston Sidoarjo">Hotel Aston Sidoarjo</option><option value="Hotel Swiss Berlinn">Hotel Swiss Berlinn</option><option value="Hotel Sofia Juanda">Hotel Sofia Juanda</option><option value="Permata Waterpark Tanggulangin">Permata Waterpark Tanggulangin</option><option value="Regency 21">Regency 21</option><option value="Premier Place Hotel Juanda">Premier Place Hotel Juanda</option><option value="Apartment Prospero Sidoarjo">Apartment Prospero Sidoarjo</option><option value="Legok Asri Park">Legok Asri Park</option></select></div>
          <div class="col-md-6"><label class="form-label">Instagram</label><input id="pendaftaran-instagram" class="form-control" placeholder="Instagram (opsional)"></div>
          <div class="col-md-6"><label class="form-label">Catatan</label><input id="pendaftaran-catatan" class="form-control" placeholder="Catatan (opsional)"></div>
        </div>
      </div>
      <div class="modal-footer border-0"><button class="btn btn-light" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary" data-action="save-pendaftaran" data-bs-dismiss="modal"><i class="bi bi-save me-1"></i>Simpan Pendaftaran</button></div>
    </div>
  </div>
</div>
@endsection
