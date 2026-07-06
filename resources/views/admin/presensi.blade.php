@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <div class="input-group" style="max-width:320px;">
    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
    <input id="presensi-search" type="text" class="form-control" placeholder="Cari presensi..." />
  </div>
  <button class="btn btn-primary btn-sm px-3" data-action="show-toast" data-message="Pindah ke Input Presensi (demo)">
    <i class="bi bi-plus-lg me-1"></i>Input Presensi
  </button>
</div>

<div class="card-custom">
  <div class="card-header">
    <i class="bi bi-clipboard2-check me-2 text-primary"></i>Presensi Hari Ini
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-custom table-hover mb-0">
        <thead>
          <tr>
            <th>Siswa</th>
            <th>Jam</th>
            <th>Status</th>
            <th>Keterangan</th>
            <th style="width:160px;">Aksi</th>
          </tr>
        </thead>
        <tbody id="presensi-tbody">
          <tr>
            <td><strong>Ahmad Fauzi</strong></td>
            <td>06:00</td>
            <td><span class="badge badge-hadir px-2">Hadir</span></td>
            <td>Datang tepat waktu</td>
            <td>
              <button class="btn btn-sm btn-outline-primary me-1" data-action="show-toast" data-message="Presensi diperbarui!"><i class="bi bi-pencil"></i></button>
              <button class="btn btn-sm btn-outline-danger" data-action="confirm-hapus" data-type="presensi"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
          <tr>
            <td><strong>Budi Santoso</strong></td>
            <td>07:00</td>
            <td><span class="badge badge-izin px-2">Izin</span></td>
            <td>Sakit ringan</td>
            <td>
              <button class="btn btn-sm btn-outline-primary me-1" data-action="show-toast" data-message="Presensi diperbarui!"><i class="bi bi-pencil"></i></button>
              <button class="btn btn-sm btn-outline-danger" data-action="confirm-hapus" data-type="presensi"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
          <tr>
            <td><strong>Citra Dewi</strong></td>
            <td>15:00</td>
            <td><span class="badge badge-alpha px-2">Alpha</span></td>
            <td>Tidak hadir</td>
            <td>
              <button class="btn btn-sm btn-outline-primary me-1" data-action="show-toast" data-message="Presensi diperbarui!"><i class="bi bi-pencil"></i></button>
              <button class="btn btn-sm btn-outline-danger" data-action="confirm-hapus" data-type="presensi"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
