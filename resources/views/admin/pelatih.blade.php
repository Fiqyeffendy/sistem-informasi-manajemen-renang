@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <div class="input-group" style="max-width:260px;">
    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
    <input type="text" class="form-control" placeholder="Cari pelatih...">
  </div>
  <button class="btn btn-primary btn-sm px-3" data-action="open-modal" data-target="modal-tambah-pelatih"><i class="bi bi-plus-lg me-1"></i>Tambah Pelatih</button>
</div>
<div class="card-custom">
  <div class="table-responsive">
    <table class="table table-custom table-hover mb-0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama Pelatih</th>
          <th>No. HP</th>
          <th>Spesialisasi</th>
          <th>Jadwal Mengajar</th>
          <th>Status</th>
          <th>Alasan Cuti</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody id="pelatih-table-body">
        <tr><td colspan="8" class="text-muted">Memuat data pelatih...</td></tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
