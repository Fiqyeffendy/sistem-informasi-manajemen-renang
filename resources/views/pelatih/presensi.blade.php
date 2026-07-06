@extends('layouts.app')

@section('content')
<div class="row g-3 mb-3">
  <div class="col-12 col-lg-5">
    <div class="card-custom h-100">
      <div class="card-header">
        <i class="bi bi-clipboard2-check me-2 text-primary"></i>Input Presensi (Demo)
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label class="form-label small fw-600">Pilih Jadwal</label>
          <select class="form-select" id="input-presensi-jadwal">
            <option value="senin" selected>Senin 06:00 - Kolam 1</option>
            <option value="rabu">Rabu 15:00 - Kolam Lomba</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label small fw-600">Pilih Siswa</label>
          <select class="form-select" id="input-presensi-siswa">
            <option value="ahmad" selected>Ahmad Fauzi</option>
            <option value="budi">Budi Santoso</option>
            <option value="citra">Citra Dewi</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label small fw-600">Status</label>
          <div class="d-flex gap-2 flex-wrap">
            <button class="btn btn-light btn-sm active" type="button" data-action="set-presensi-status" data-status="Hadir">Hadir</button>
            <button class="btn btn-light btn-sm" type="button" data-action="set-presensi-status" data-status="Izin">Izin</button>
            <button class="btn btn-light btn-sm" type="button" data-action="set-presensi-status" data-status="Alpha">Alpha</button>
          </div>
        </div>

        <button class="btn btn-export w-100" data-action="save-presensi">
          <i class="bi bi-save me-1"></i>Simpan Presensi
        </button>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-7">
    <div class="card-custom h-100">
      <div class="card-header">
        <i class="bi bi-card-list me-2 text-primary"></i>Daftar Presensi Terkini
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-custom table-hover mb-0">
            <thead>
              <tr><th>Siswa</th><th>Jam</th><th>Status</th><th>Keterangan</th><th style="width:140px;">Aksi</th></tr>
            </thead>
            <tbody id="input-presensi-tbody">
              <tr><td><strong>Ahmad Fauzi</strong></td><td>06:00</td><td><span class="badge badge-hadir px-2">Hadir</span></td><td>Datang tepat waktu</td><td><button class="btn btn-sm btn-outline-danger" data-action="confirm-hapus" data-type="presensi"><i class="bi bi-trash"></i></button></td></tr>
              <tr><td><strong>Budi Santoso</strong></td><td>07:00</td><td><span class="badge badge-izin px-2">Izin</span></td><td>Sakit ringan</td><td><button class="btn btn-sm btn-outline-danger" data-action="confirm-hapus" data-type="presensi"><i class="bi bi-trash"></i></button></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
