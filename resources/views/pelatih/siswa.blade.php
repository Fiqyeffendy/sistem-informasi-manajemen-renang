@extends('layouts.app')

@section('content')
{{-- Halaman ini menampilkan daftar siswa yang terhubung dengan jadwal pelatih. --}}

{{-- Header halaman dengan pencarian siswa. --}}
<div class="page-header fade-in d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
        <h1 class="fw-800 mb-1" style="font-size: 1.5rem; letter-spacing: -0.5px;">Daftar Siswa Saya</h1>
        <p class="text-secondary small mb-0">Daftar murid renang yang berada di kelas Anda.</p>
    </div>
    <div class="d-flex gap-2">
        <div class="input-group input-group-sm" style="max-width: 240px;">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input id="siswa-search-input" type="text" class="form-control border-start-0 ps-0" placeholder="Cari siswa..." />
        </div>
    </div>
</div>

{{-- Tabel daftar siswa yang terhubung dengan pelatih. --}}
<div class="card-custom border shadow-sm rounded-4 bg-white overflow-hidden fade-in">
    <div class="table-responsive">
        <table class="table table-custom table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;">NO</th>
                    <th>NAMA SISWA</th>
                    <th>PROGRAM</th>
                    <th>JENIS PROGRAM</th>
                    <th>SISA SESI</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody id="siswa-table-body">
                @if($siswas->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-people fs-1 opacity-40 mb-3 d-block"></i>
                            Belum ada siswa yang terjadwal dengan Anda.
                        </td>
                    </tr>
                @else
                    @foreach($siswas as $idx => $siswa)
                        @php
                            $sisaSesi = max($siswa->total_sesi - $siswa->sesi_terpakai, 0);
                            $progressPercent = $siswa->total_sesi > 0 ? ($sisaSesi / $siswa->total_sesi) * 100 : 0;
                            
                            $programVal = $siswa->program instanceof \App\Enums\Program ? $siswa->program->value : (string) $siswa->program;
                            $badgeClass = 'bg-primary-light text-primary border-primary-subtle';
                            if (str_contains($programVal, 'WaterBabies')) {
                                $badgeClass = 'bg-success-light text-success border-success-subtle';
                            } elseif (str_contains($programVal, 'Elite')) {
                                $badgeClass = 'bg-danger-light text-danger border-danger-subtle';
                            }
                            
                            $sesiClass = 'bg-success';
                            if ($sisaSesi <= 2) {
                                $sesiClass = 'bg-danger';
                            } elseif ($sisaSesi <= 5) {
                                $sesiClass = 'bg-warning';
                            }
                        @endphp
                        <tr class="siswa-row">
                            <td><span class="text-secondary small fw-600">{{ $idx + 1 }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-800 text-white me-3" 
                                         style="width: 38px; height: 38px; background: linear-gradient(135deg, #1e3a8a, #3b82f6); font-size: 0.9rem;">
                                        {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-800 text-main" style="font-size: 0.9rem;">{{ $siswa->nama }}</div>
                                        <div class="text-secondary small">{{ $siswa->no_hp_ortu ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge border px-2.5 py-1.5 fw-600 rounded-3 {{ $badgeClass }}">
                                    {{ explode(' (', $programVal)[0] }}
                                </span>
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-light text-secondary border px-2.5 py-1.5 fw-600">
                                    {{ $siswa->jenis_program }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress" style="width: 60px; height: 6px; border-radius: 3px;">
                                        <div class="progress-bar {{ $sesiClass }}" role="progressbar" style="width: {{ $progressPercent }}%;"></div>
                                    </div>
                                    <span class="fw-800 text-main small">{{ $sisaSesi }} Sesi</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge px-2.5 py-1.5 rounded-pill border {{ $siswa->status === 'aktif' ? 'bg-success-light text-success border-success-subtle' : 'bg-secondary-light text-secondary border-secondary-subtle' }} fw-600">
                                    {{ ucfirst($siswa->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

{{-- Script pencarian sederhana untuk menyaring siswa berdasarkan kata kunci. --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('siswa-search-input');
        if (input) {
            input.addEventListener('input', function() {
                const term = this.value.toLowerCase().trim();
                const rows = document.querySelectorAll('.siswa-row');
                
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
