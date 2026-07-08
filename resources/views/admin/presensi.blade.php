@extends('layouts.app')

@section('content')
{{-- Halaman ini menampilkan daftar presensi admin untuk rekap kehadiran. --}}
{{-- Toolbar pencarian dan tombol input presensi untuk mempermudah pencatatan. --}}
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
          @if($presensis->isEmpty())
            <tr>
              <td colspan="5" class="text-center text-muted py-5">
                <i class="bi bi-clipboard-x fs-2 d-block opacity-40 mb-2"></i>
                Belum ada data presensi yang dicatat.
              </td>
            </tr>
          @else
            @foreach($presensis as $presensi)
              @php
                $statusClass = 'badge-hadir';
                if ($presensi->status === 'izin') {
                    $statusClass = 'badge-izin';
                } elseif ($presensi->status === 'alpha') {
                    $statusClass = 'badge-alpha';
                }
              @endphp
              <tr class="presensi-row">
                <td><strong>{{ $presensi->siswa?->nama ?? '-' }}</strong></td>
                <td>
                  <span class="text-primary fw-600">
                    {{ \Carbon\Carbon::parse($presensi->jadwal?->jam)->format('H:i') }}
                  </span>
                  <small class="text-secondary">({{ $presensi->jadwal?->hari ?? $presensi->tanggal->translatedFormat('l') }})</small>
                </td>
                <td><span class="badge {{ $statusClass }} px-2">{{ ucfirst($presensi->status) }}</span></td>
                <td><span class="text-secondary small">{{ $presensi->catatan ?? '—' }}</span></td>
                <td>
                  <button class="btn btn-sm btn-outline-danger" data-action="confirm-hapus" data-type="presensi" data-id="{{ $presensi->id }}"><i class="bi bi-trash"></i></button>
                </td>
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('presensi-search');
        if (input) {
            input.addEventListener('input', function() {
                const term = this.value.toLowerCase().trim();
                const rows = document.querySelectorAll('.presensi-row');
                
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
