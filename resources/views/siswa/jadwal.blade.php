@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <div class="input-group" style="max-width:320px;">
    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
    <input type="text" class="form-control" placeholder="Cari jadwal..." />
  </div>
  <button class="btn btn-export btn-sm" data-action="show-toast" data-message="Filter jadwal (demo)">
    <i class="bi bi-funnel me-1"></i>Filter
  </button>
</div>

<div class="card-custom">
  <div class="card-header">
    <i class="bi bi-calendar3 me-2 text-primary"></i>Jadwal Latihan
  </div>
  <div class="card-body p-3">
    <div class="schedule-item">
      <div class="schedule-time">Senin<small>06:00</small></div>
      <div class="schedule-info flex-grow-1"><strong>Kelompok A</strong><small>Kolam 1</small></div>
      <span class="badge rounded-pill badge-aktif">Aktif</span>
    </div>
    <div class="schedule-item">
      <div class="schedule-time">Rabu<small>15:00</small></div>
      <div class="schedule-info flex-grow-1"><strong>Kelompok C</strong><small>Kolam Lomba</small></div>
      <span class="badge rounded-pill badge-penuh">Penuh</span>
    </div>
  </div>
</div>
@endsection
