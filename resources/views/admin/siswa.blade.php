@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <div class="input-group" style="max-width:260px;">
    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
    <input type="text" class="form-control" placeholder="Cari siswa...">
  </div>
  <div class="d-flex gap-2 flex-wrap">
    <button class="btn btn-secondary btn-sm px-3" data-action="refresh-siswa"><i class="bi bi-arrow-clockwise me-1"></i>Refresh</button>
    <button class="btn btn-primary btn-sm px-3" data-action="open-modal" data-target="modal-tambah-siswa"><i class="bi bi-plus-lg me-1"></i>Tambah Siswa</button>
  </div>
</div>
<div class="card-custom">
  <div class="table-responsive">
    <table class="table table-custom table-hover mb-0">
      <thead><tr><th>No</th><th>ID</th><th>Nama Siswa</th><th>Umur</th><th>Program</th><th>Jenis Program</th><th>Lokasi Les</th><th>Total Sesi</th><th>Sisa Sesi</th><th>Aksi</th></tr></thead>
      <tbody id="siswa-table-body">
        <tr><td colspan="10" class="text-muted">Memuat data siswa...</td></tr>
      </tbody>
    </table>
  </div>
  <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2 border-top py-2 px-3">
    <small class="text-muted" id="siswa-table-summary">Memuat data...</small>
    <nav><ul class="pagination pagination-sm mb-0">
      <li class="page-item disabled"><a class="page-link">‹</a></li>
      <li class="page-item active"><a class="page-link">1</a></li>
      <li class="page-item"><a class="page-link">2</a></li>
      <li class="page-item"><a class="page-link">3</a></li>
      <li class="page-item"><a class="page-link">›</a></li>
    </ul></nav>
  </div>
</div>
@endsection
