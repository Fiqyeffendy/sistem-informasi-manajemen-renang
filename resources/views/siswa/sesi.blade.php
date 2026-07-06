@extends('layouts.app')

@section('content')
<div class="row g-3 mb-3">
  <div class="col-12 col-lg-5">
    <div class="card-custom h-100">
      <div class="card-header">
        <i class="bi bi-hourglass-split me-2 text-primary"></i>Sisa Sesi
      </div>
      <div class="card-body p-3">
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-1">
            <span class="fw-600" style="font-size:.87rem;">Sisa Sesi Anda</span>
            <span class="badge badge-sisa-warn px-2">9 sesi</span>
          </div>
          <div class="sesi-bar"><div class="fill fill-warn" style="width:45%"></div></div>
        </div>
        <div class="mb-0 text-muted">Gunakan riwayat untuk melihat pencatatan presensi Anda.</div>
      </div>
    </div>
  </div>
  <div class="col-12 col-lg-7">
    <div class="card-custom h-100">
      <div class="card-header">
        <i class="bi bi-graph-up-arrow me-2 text-primary"></i>Progres Minggu Ini
      </div>
      <div class="card-body p-3">
        <div class="mb-2 d-flex justify-content-between"><span>Aktif</span><span class="badge badge-aktif px-2">6</span></div>
        <div class="mb-2 d-flex justify-content-between"><span>Penuh</span><span class="badge badge-penuh px-2">1</span></div>
        <div class="mb-0 d-flex justify-content-between"><span>Sisa</span><span class="badge badge-sisa-ok px-2">2</span></div>
      </div>
    </div>
  </div>
</div>
@endsection
