@extends('layouts.app')

@section('content')
{{-- Halaman ini menampilkan sisa sesi siswa dan rekap sesi minggu ini. --}}
<div class="row g-3 mb-2">
  <div class="col-12 col-lg-5">
    <div class="card-custom h-100">
      <div class="card-header">
        <i class="bi bi-hourglass-split me-2 text-primary"></i>Sesi Latihan Tersisa
      </div>
      <div class="card-body p-3" style="max-height: 400px; overflow-y: auto;">
        @if($siswas->isEmpty())
          <div class="text-center text-muted py-4">Belum ada data siswa.</div>
        @else
          @foreach($siswas as $siswa)
            @php
              $sisaSesi = max(0, $siswa->total_sesi - $siswa->sesi_terpakai);
              $progressPercent = $siswa->total_sesi > 0 ? ($sisaSesi / $siswa->total_sesi) * 100 : 0;
              $fillClass = 'fill-ok';
              $badgeClass = 'badge-sisa-ok';
              if ($sisaSesi <= 2) {
                  $fillClass = 'fill-low';
                  $badgeClass = 'badge-sisa-low';
              } elseif ($sisaSesi <= 5) {
                  $fillClass = 'fill-warn';
                  $badgeClass = 'badge-sisa-warn';
              }
            @endphp
            <div class="mb-3">
              <div class="d-flex justify-content-between mb-1">
                <span class="fw-600" style="font-size:.87rem;">{{ $siswa->nama }}</span>
                <span class="badge {{ $badgeClass }} px-2">{{ $sisaSesi }} sesi</span>
              </div>
              <div class="sesi-bar"><div class="fill {{ $fillClass }}" style="width:{{ $progressPercent }}%"></div></div>
            </div>
          @endforeach
        @endif
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
                <th>Tidak Aktif</th>
              </tr>
            </thead>
            <tbody>
              @if($rekapHari->isEmpty())
                <tr><td colspan="4" class="text-muted text-center py-3">Belum ada jadwal mengajar minggu ini.</td></tr>
              @else
                @foreach($rekapHari as $rekap)
                  <tr>
                    <td><strong>{{ $rekap->hari }}</strong></td>
                    <td>{{ $rekap->total }}</td>
                    <td><span class="badge badge-aktif px-2">{{ $rekap->aktif }}</span></td>
                    <td><span class="badge badge-penuh px-2">{{ $rekap->tidak_aktif }}</span></td>
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </div>
        <div class="mt-3 d-flex justify-content-end">
          <button class="btn btn-export" onclick="location.reload()">
            <i class="bi bi-arrow-clockwise me-1"></i>Refresh
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
