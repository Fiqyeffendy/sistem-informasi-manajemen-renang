@extends('layouts.app')

@section('content')
<div class="card-custom">
  <div class="card-header">
    <i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Presensi
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-custom table-hover mb-0">
        <thead>
          <tr><th>Tanggal</th><th>Jam</th><th>Status</th><th>Keterangan</th></tr>
        </thead>
        <tbody>
          <tr><td>Senin</td><td>06:00</td><td><span class="badge badge-hadir px-2">Hadir</span></td><td>Datang tepat waktu</td></tr>
          <tr><td>Selasa</td><td>07:00</td><td><span class="badge badge-izin px-2">Izin</span></td><td>Sakit ringan</td></tr>
          <tr><td>Rabu</td><td>15:00</td><td><span class="badge badge-alpha px-2">Alpha</span></td><td>Tidak hadir</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
