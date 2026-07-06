@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <div class="input-group" style="max-width:320px;">
    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
    <input id="siswa-pelatih-search" type="text" class="form-control" placeholder="Cari siswa..." />
  </div>
  <button class="btn btn-primary btn-sm px-3" data-action="show-toast" data-message="Tambah siswa ke pelatih (demo)">
    <i class="bi bi-plus-lg me-1"></i>Tambah
  </button>
</div>

<div class="card-custom">
  <div class="card-header">
    <i class="bi bi-people me-2 text-primary"></i>Daftar Siswa
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-custom table-hover mb-0">
        <thead>
          <tr>
            <th>Nama</th><th>Paket</th><th>Sisa Sesi</th><th style="width:120px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr><td><strong>Ahmad Fauzi</strong></td><td><span class="badge badge-aktif px-2">Silver</span></td><td><span class="badge badge-sisa-ok px-2">14</span></td><td><button class="btn btn-sm btn-outline-primary" data-action="show-toast" data-message="Detail siswa (demo)"><i class="bi bi-eye"></i></button></td></tr>
          <tr><td><strong>Budi Santoso</strong></td><td><span class="badge badge-aktif px-2">Bronze</span></td><td><span class="badge badge-sisa-warn px-2">9</span></td><td><button class="btn btn-sm btn-outline-primary" data-action="show-toast" data-message="Detail siswa (demo)"><i class="bi bi-eye"></i></button></td></tr>
          <tr><td><strong>Citra Dewi</strong></td><td><span class="badge badge-penuh px-2">Gold</span></td><td><span class="badge badge-sisa-ok px-2">8</span></td><td><button class="btn btn-sm btn-outline-primary" data-action="show-toast" data-message="Detail siswa (demo)"><i class="bi bi-eye"></i></button></td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
