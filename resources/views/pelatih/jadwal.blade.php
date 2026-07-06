@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <div class="input-group" style="max-width:320px;">
    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
    <input id="jadwal-pelatih-search" type="text" class="form-control" placeholder="Cari jadwal..." />
  </div>
  <button class="btn btn-export btn-sm" data-action="show-toast" data-message="Fitur filter jadwal (demo)">
    <i class="bi bi-funnel me-1"></i>Filter
  </button>
</div>

<div class="card-custom">
  <div class="card-header">
    <i class="bi bi-calendar3 me-2 text-primary"></i>Jadwal Saya
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-custom table-hover mb-0">
        <thead>
          <tr>
            <th>Hari</th><th>Jam</th><th>Siswa</th><th>Kolam</th><th>Status</th><th style="width:120px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Senin</td><td>06:00</td><td><strong>Ahmad Fauzi</strong></td><td>Kolam 1</td><td><span class="badge badge-aktif px-2">Aktif</span></td>
            <td><button class="btn btn-sm btn-outline-primary" data-action="show-toast" data-message="Lihat detail (demo)"><i class="bi bi-eye"></i></button></td>
          </tr>
          <tr>
            <td>Rabu</td><td>15:00</td><td><strong>Citra Dewi</strong></td><td>Kolam Lomba</td><td><span class="badge badge-aktif px-2">Aktif</span></td>
            <td><button class="btn btn-sm btn-outline-primary" data-action="show-toast" data-message="Lihat detail (demo)"><i class="bi bi-eye"></i></button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
