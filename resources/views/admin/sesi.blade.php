@extends('layouts.app')

@section('content')
<div class="row g-3 mb-2">
  <div class="col-12 col-lg-5">
    <div class="card-custom h-100">
      <div class="card-header">
        <i class="bi bi-hourglass-split me-2 text-primary"></i>Sesi Latihan Tersisa
      </div>
      <div class="card-body p-3">
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-1">
            <span class="fw-600" style="font-size:.87rem;">Rafi Pratama</span>
            <span class="badge badge-sisa-low px-2">2 sesi</span>
          </div>
          <div class="sesi-bar"><div class="fill fill-low" style="width:10%"></div></div>
        </div>
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-1">
            <span style="font-size:.87rem;">Nadia Kusuma</span>
            <span class="badge badge-sisa-warn px-2">4 sesi</span>
          </div>
          <div class="sesi-bar"><div class="fill fill-warn" style="width:20%"></div></div>
        </div>
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-1">
            <span style="font-size:.87rem;">Bagas Wirawan</span>
            <span class="badge badge-sisa-warn px-2">5 sesi</span>
          </div>
          <div class="sesi-bar"><div class="fill fill-warn" style="width:25%"></div></div>
        </div>
        <div class="mb-2">
          <div class="d-flex justify-content-between mb-1">
            <span style="font-size:.87rem;">Citra Dewi</span>
            <span class="badge badge-sisa-ok px-2">8 sesi</span>
          </div>
          <div class="sesi-bar"><div class="fill fill-ok" style="width:40%"></div></div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-7">
    <div class="card-custom h-100">
      <div class="card-header">
        <i class="bi bi-calendar3 me-2 text-primary"></i>Rekap Sesi (Minggu Ini)
      </div>
      <div class="card-body p-3">
        <div class="table-responsive">
          <table class="table table-custom table-hover mb-0">
            <thead>
              <tr>
                <th>Hari</th>
                <th>Jumlah Sesi</th>
                <th>Aktif</th>
                <th>Penuh</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Senin</td><td>4</td><td><span class="badge badge-aktif px-2">3</span></td><td><span class="badge badge-penuh px-2">1</span></td>
              </tr>
              <tr>
                <td>Selasa</td><td>4</td><td><span class="badge badge-aktif px-2">2</span></td><td><span class="badge badge-penuh px-2">2</span></td>
              </tr>
              <tr>
                <td>Rabu</td><td>3</td><td><span class="badge badge-aktif px-2">2</span></td><td><span class="badge badge-penuh px-2">1</span></td>
              </tr>
              <tr>
                <td>Kamis</td><td>0</td><td><span class="badge badge-sisa-ok px-2">0</span></td><td><span class="badge badge-sisa-low px-2">0</span></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="mt-3 d-flex justify-content-end">
          <button class="btn btn-export" data-action="show-toast" data-message="Rekap sesi disegarkan!">
            <i class="bi bi-arrow-clockwise me-1"></i>Refresh
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
