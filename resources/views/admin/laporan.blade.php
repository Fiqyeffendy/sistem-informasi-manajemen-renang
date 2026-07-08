@extends('layouts.app')

@section('content')
{{-- Halaman ini menampilkan ringkasan serta rekapan presensi siswa dalam bentuk laporan. --}}

<div class="row g-3 mb-3">
  <div class="col-12 col-lg-4">
    <div class="card-custom h-100">
      <div class="card-header">
        <i class="bi bi-bar-chart-line me-2 text-primary"></i>Ringkasan Laporan
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted">Total Jadwal</span>
          <strong>{{ $totalJadwal }}</strong>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted">Total Presensi</span>
          <strong>{{ $totalPresensi }}</strong>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted">Hadir</span>
          <strong class="text-success">{{ $hadirCount }}</strong>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span class="text-muted">Izin</span>
          <strong class="text-warning">{{ $izinCount }}</strong>
        </div>
        <div class="d-flex justify-content-between">
          <span class="text-muted">Alpha</span>
          <strong class="text-danger">{{ $alphaCount }}</strong>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-8">
    <div class="card-custom h-100">
      <div class="card-header">
        <i class="bi bi-funnel me-2 text-primary"></i>Filter Laporan
      </div>
      <div class="card-body">
        <form method="GET" action="{{ route('admin.laporan') }}">
          <div class="row g-2">
            <div class="col-12 col-md-4">
              <label class="form-label small fw-600">Periode</label>
              <select class="form-select" name="periode" id="laporan-periode">
                <option value="minggu" {{ $periode === 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="bulan" {{ $periode === 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="tahun" {{ $periode === 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
              </select>
            </div>
            <div class="col-12 col-md-4">
              <label class="form-label small fw-600">Status Presensi</label>
              <select class="form-select" name="status" id="laporan-status">
                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua</option>
                <option value="hadir" {{ $status === 'hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="izin" {{ $status === 'izin' ? 'selected' : '' }}>Izin</option>
                <option value="alpha" {{ $status === 'alpha' ? 'selected' : '' }}>Alpha</option>
              </select>
            </div>
            <div class="col-12 col-md-4 d-flex align-items-end">
              <button class="btn btn-export w-100" type="submit">
                <i class="bi bi-search me-1"></i>Tampilkan
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="card-custom">
  <div class="card-header d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
      <i class="bi bi-table me-2 text-primary"></i>
      <span class="fw-700" style="font-size:0.95rem;">Rekap Presensi Siswa</span>
    </div>
    <div class="input-group input-group-sm" style="max-width: 200px;">
        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
        <input id="laporan-search-input" type="text" class="form-control border-start-0 ps-0" placeholder="Cari siswa..." />
    </div>
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
          @if($rekapSiswa->isEmpty())
            <tr><td colspan="6" class="text-muted text-center py-4">Belum ada data rekap presensi siswa.</td></tr>
          @else
            @foreach($rekapSiswa as $siswa)
              <tr class="laporan-row">
                <td><strong>{{ $siswa->nama }}</strong></td>
                <td><span class="badge badge-hadir px-2">{{ $siswa->total_hadir }}</span></td>
                <td><span class="badge badge-izin px-2">{{ $siswa->total_izin }}</span></td>
                <td><span class="badge badge-alpha px-2">{{ $siswa->total_alpha }}</span></td>
                <td>{{ $siswa->total_hadir + $siswa->total_izin + $siswa->total_alpha }}</td>
                <td>
                  <button class="btn btn-sm btn-outline-primary me-1" data-action="show-toast" data-message="Detail laporan {{ $siswa->nama }}"><i class="bi bi-eye"></i></button>
                </td>
              </tr>
            @endforeach
          @endif
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('laporan-search-input');
        if (input) {
            input.addEventListener('input', function() {
                const term = this.value.toLowerCase().trim();
                const rows = document.querySelectorAll('.laporan-row');
                
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    if (text.includes(term)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endsection
