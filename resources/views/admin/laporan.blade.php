@extends('layouts.app')

@section('content')
<div class="row g-3 mb-3">
  <div class="col-12 col-lg-4">
    <div class="card-custom h-100">
      <div class="card-header">
        <i class="bi bi-bar-chart-line me-2 text-primary"></i>Ringkasan Laporan
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted">Total Jadwal</span>
          <strong>18</strong>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted">Total Presensi</span>
          <strong>315</strong>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted">Hadir</span>
          <strong>240</strong>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted">Izin</span>
          <strong>45</strong>
        </div>
        <div class="d-flex justify-content-between">
          <span class="text-muted">Alpha</span>
          <strong>30</strong>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-8">
    <div class="card-custom h-100">
      <div class="card-header">
        <i class="bi bi-funnel me-2 text-primary"></i>Filter
      </div>
      <div class="card-body">
        <div class="row g-2">
          <div class="col-12 col-md-4">
            <label class="form-label small fw-600">Periode</label>
            <select class="form-select" id="laporan-periode">
              <option value="minggu" selected>Minggu Ini</option>
              <option value="bulan">Bulan Ini</option>
              <option value="tahun">Tahun Ini</option>
            </select>
          </div>
          <div class="col-12 col-md-4">
            <label class="form-label small fw-600">Status Presensi</label>
            <select class="form-select" id="laporan-status">
              <option value="all" selected>Semua</option>
              <option value="hadir">Hadir</option>
              <option value="izin">Izin</option>
              <option value="alpha">Alpha</option>
            </select>
          </div>
          <div class="col-12 col-md-4 d-flex align-items-end">
            <button class="btn btn-export w-100" data-action="show-toast" data-message="Laporan diperbarui!">
              <i class="bi bi-search me-1"></i>Tampilkan
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card-custom">
  <div class="card-header">
    <i class="bi bi-table me-2 text-primary"></i>Rekap Presensi (Demo)
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-custom table-hover mb-0">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Total Hadir</th>
            <th>Total Izin</th>
            <th>Total Alpha</th>
            <th>Akumulasi Sesi</th>
            <th style="width:160px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><strong>Ahmad Fauzi</strong></td>
            <td><span class="badge badge-hadir px-2">12</span></td>
            <td><span class="badge badge-izin px-2">2</span></td>
            <td><span class="badge badge-alpha px-2">1</span></td>
            <td>15</td>
            <td>
              <button class="btn btn-sm btn-outline-primary me-1" data-action="show-toast" data-message="Detail siswa (demo)">
                <i class="bi bi-eye"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger" data-action="confirm-hapus" data-type="laporan">
                <i class="bi bi-trash"></i>
              </button>
            </td>
          </tr>
          <tr>
            <td><strong>Budi Santoso</strong></td>
            <td><span class="badge badge-hadir px-2">9</span></td>
            <td><span class="badge badge-izin px-2">3</span></td>
            <td><span class="badge badge-alpha px-2">0</span></td>
            <td>12</td>
            <td>
              <button class="btn btn-sm btn-outline-primary me-1" data-action="show-toast" data-message="Detail siswa (demo)">
                <i class="bi bi-eye"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger" data-action="confirm-hapus" data-type="laporan">
                <i class="bi bi-trash"></i>
              </button>
            </td>
          </tr>
          <tr>
            <td><strong>Citra Dewi</strong></td>
            <td><span class="badge badge-hadir px-2">11</span></td>
            <td><span class="badge badge-izin px-2">1</span></td>
            <td><span class="badge badge-alpha px-2">2</span></td>
            <td>14</td>
            <td>
              <button class="btn btn-sm btn-outline-primary me-1" data-action="show-toast" data-message="Detail siswa (demo)">
                <i class="bi bi-eye"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger" data-action="confirm-hapus" data-type="laporan">
                <i class="bi bi-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="card-body border-top d-flex justify-content-end">
    <button class="btn btn-export" data-action="show-toast" data-message="Ekspor laporan (demo)">
      <i class="bi bi-download me-1"></i>Ekspor
    </button>
  </div>
</div>
@endsection
