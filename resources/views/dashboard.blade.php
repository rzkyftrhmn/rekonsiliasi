@extends('layouts.app')
@include('dashboard.style')
@section('content')

{{-- ─── PAGE HEADER ─── --}}
<div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="page-title mb-0">Dashboard</h1>
</div>

<!-- FILTER BAR — auto submit saat berubah -->
<form method="GET" action="{{ route('dashboard') }}" id="filterForm">
<div class="filter-bar mb-4">

    <div class="filter-icon-wrap">
        <svg viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
    </div>
    <span class="filter-title">Filter</span>
    <div class="filter-divider"></div>

    {{-- Dropdown Periode --}}
    <select name="periode_id" class="filter-select {{ $selectedPeriode ? 'active' : '' }}"
            onchange="document.getElementById('filterForm').submit()">
        <option value="">-- Semua Periode --</option>
        @foreach($allPeriode as $p)
            <option value="{{ $p->id }}"
                {{ $selectedPeriode == $p->id ? 'selected' : '' }}>
                {{ $p->nama_periode }} {{ $p->tahun }}
            </option>
        @endforeach
    </select>

    {{-- Badge label aktif --}}
    @if($selectedPeriode || $selectedTahun)
    <div class="filter-badge">
        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        {{ $labelFilter }}
    </div>
    @endif

    <div class="ms-auto">
        <a href="{{ route('dashboard') }}" class="filter-reset">
            <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            Reset
        </a>
    </div>

</div>
</form>

<!-- STAT CARDS -->
<div class="row g-3 mb-4">

    <div class="col-xl-3 col-md-6">
        <div class="stat-card card-blue a1">
            <div class="card-icon">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <div class="card-label">Total Rekonsiliasi</div>
            <div class="card-value">{{ $totalRekonsiliasi }}</div>
            <div class="card-divider"></div>
            <div class="card-sub">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                {{ $labelFilter }}
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card card-teal a2">
            <div class="card-icon">
                <svg viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/></svg>
            </div>
            <div class="card-label">Dalam Proses</div>
            <div class="card-value">{{ $dalamProses }}</div>
            <div class="card-divider"></div>
            <div class="card-sub">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Menunggu validasi
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card card-green a3">
            <div class="card-icon">
                <svg viewBox="0 0 24 24"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
            </div>
            <div class="card-label">Total Nilai SKPD</div>
            <div class="card-value">
                <span class="prefix">Rp</span>{{ number_format($totalNilaiSkpd, 0, ',', '.') }}
            </div>
            <div class="card-divider"></div>
            <div class="card-sub">
                <svg viewBox="0 0 24 24"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                {{ $labelFilter }}
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card card-red a4">
            <div class="card-icon">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
            </div>
            <div class="card-label">Total Nilai BPKAD</div>
            <div class="card-value">
                <span class="prefix">Rp</span>{{ number_format($totalNilaiBpkad, 0, ',', '.') }}
            </div>
            <div class="card-divider"></div>
            <div class="card-sub">
                <svg viewBox="0 0 24 24"><polyline points="22 17 13.5 8.5 8.5 13.5 2 7"/><polyline points="16 17 22 17 22 11"/></svg>
                {{ $labelFilter }}
            </div>
        </div>
    </div>

</div>

<!-- TABEL ADMIN -->
@if(auth()->user()->role === 'admin')
<div class="row mb-4">
    <div class="col-12">
        <div class="card section-card">
            <div class="card-header"><span class="dot"></span> Rekonsiliasi Terbaru</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>No</th><th>SKPD</th><th>Periode</th><th>Status</th></tr></thead>
                        <tbody>
                            @forelse($rekonsiliasiTerbaru as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->skpd->nama_skpd }}</td>
                                <td>{{ $item->periode->nama_periode }}</td>
                                <td>
                                    <span class="bs @if($item->status=='valid') bs-valid @elseif($item->status=='selisih') bs-selisih @else bs-proses @endif">
                                        {{ strtoupper(str_replace('_',' ',$item->status)) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card section-card">
            <div class="card-header"><span class="dot"></span> Status Rekonsiliasi</div>
            <div class="card-body"><div style="height:320px;"><canvas id="statusChart"></canvas></div></div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card section-card">
            <div class="card-header"><span class="dot"></span> Rekonsiliasi per SKPD</div>
            <div class="card-body"><div style="height:320px;"><canvas id="skpdChart"></canvas></div></div>
        </div>
    </div>
</div>
@endif

<!-- TABEL OPERATOR -->
@if(auth()->user()->role === 'operator')
<div class="row mb-4">
    <div class="col-12">
        <div class="card section-card">
            <div class="card-header"><span class="dot"></span> Rekonsiliasi Terakhir Saya</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>No</th><th>Rekening</th><th>Nilai SKPD</th><th>Status</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse($rekonsiliasiSaya as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->rekening->nama_rekening }}</td>
                                <td>Rp {{ number_format($item->nilai_skpd,0,',','.') }}</td>
                                <td>
                                    <span class="bs @if($item->status=='valid') bs-valid @elseif($item->status=='selisih') bs-selisih @else bs-proses @endif">
                                        {{ strtoupper(str_replace('_',' ',$item->status)) }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->status !== 'dalam_proses')
                                        <a href="{{ route('rekonsiliasi.show', $item->id) }}" class="btn btn-sm btn-primary" style="border-radius:8px;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada rekonsiliasi</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card section-card">
            <div class="card-header"><span class="dot"></span> Status Rekonsiliasi Saya</div>
            <div class="card-body"><div style="height:320px;"><canvas id="statusOperatorChart"></canvas></div></div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card section-card">
            <div class="card-header"><span class="dot"></span> Rekonsiliasi per Rekening</div>
            <div class="card-body"><div style="height:320px;"><canvas id="rekeningChart"></canvas></div></div>
        </div>
    </div>
</div>
@endif

<!-- TABEL VALIDATOR -->
@if(auth()->user()->role === 'validator')
<div class="row mb-4">
    <div class="col-12">
        <div class="card section-card">
            <div class="card-header"><span class="dot" style="background:#16a34a;"></span> Perlu Validasi</div>
            <div class="card-body p-0">
                <div class="table-responsive p-3">
                    <table class="table mb-0">
                        <thead><tr><th>No</th><th>SKPD</th><th>Periode</th><th>Nilai SKPD</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse($perluValidasi as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->skpd->nama_skpd }}</td>
                                <td>{{ $item->periode->nama_periode }}</td>
                                <td>Rp {{ number_format($item->nilai_skpd,0,',','.') }}</td>
                                <td>
                                    <a href="{{ route('rekonsiliasi.validasi.form', $item->id) }}" class="btn btn-sm btn-success" style="border-radius:8px;">
                                        <i class="fas fa-check"></i> Validasi
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada antrian validasi</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card section-card">
            <div class="card-header"><span class="dot"></span> Status Rekonsiliasi</div>
            <div class="card-body"><div style="height:320px;"><canvas id="validatorStatusChart"></canvas></div></div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card section-card">
            <div class="card-header"><span class="dot"></span> Rekonsiliasi per SKPD</div>
            <div class="card-body"><div style="height:320px;"><canvas id="validatorSkpdChart"></canvas></div></div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const chartDefaults = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { labels: { font: { family: 'Plus Jakarta Sans', size: 12 }, color: '#374151' } }
    }
};

document.addEventListener('DOMContentLoaded', function () {

    // ── Admin: Status pie ──
    const statusCanvas = document.getElementById('statusChart');
    if (statusCanvas) {
        new Chart(statusCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Valid','Selisih','Dalam Proses'],
                datasets: [{ data: [{{ $chartStatus['valid'] }},{{ $chartStatus['selisih'] }},{{ $chartStatus['proses'] }}], backgroundColor: ['#16a34a','#dc2626','#d97706'], borderWidth: 0, hoverOffset: 8 }]
            },
            options: { ...chartDefaults, cutout: '65%' }
        });
    }

    // ── Admin: SKPD bar ──
    const skpdCanvas = document.getElementById('skpdChart');
    if (skpdCanvas) {
        new Chart(skpdCanvas, {
            type: 'bar',
            data: {
                labels: {!! json_encode($skpdLabels) !!},
                datasets: [{ label: 'Total Rekonsiliasi', data: {!! json_encode($skpdData) !!}, backgroundColor: '#2952E3', borderRadius: 6, borderSkipped: false }]
            },
            options: { ...chartDefaults, scales: { y: { beginAtZero: true, ticks: { precision: 0 } }, x: { grid: { display: false } } } }
        });
    }

    // ── Operator: Status pie ──
    const statusOpCanvas = document.getElementById('statusOperatorChart');
    if (statusOpCanvas) {
        new Chart(statusOpCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Valid','Selisih','Dalam Proses'],
                datasets: [{ data: [{{ $chartStatusOperator['valid'] ?? 0 }},{{ $chartStatusOperator['selisih'] ?? 0 }},{{ $chartStatusOperator['dalam_proses'] ?? 0 }}], backgroundColor: ['#16a34a','#dc2626','#d97706'], borderWidth: 0, hoverOffset: 8 }]
            },
            options: { ...chartDefaults, cutout: '65%' }
        });
    }

    // ── Operator: Rekening bar ──
    const rekeningCanvas = document.getElementById('rekeningChart');
    if (rekeningCanvas) {
        new Chart(rekeningCanvas, {
            type: 'bar',
            data: {
                labels: {!! json_encode($rekeningLabels) !!},
                datasets: [{ label: 'Total', data: {!! json_encode($rekeningData) !!}, backgroundColor: '#0f766e', borderRadius: 6, borderSkipped: false }]
            },
            options: { ...chartDefaults, scales: { y: { beginAtZero: true, ticks: { precision: 0 } }, x: { grid: { display: false } } } }
        });
    }

    // ── Validator: Status pie ──
    const valStatusCanvas = document.getElementById('validatorStatusChart');
    if (valStatusCanvas) {
        new Chart(valStatusCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Valid','Selisih','Dalam Proses'],
                datasets: [{ data: [{{ $chartStatusValidator['valid'] ?? 0 }},{{ $chartStatusValidator['selisih'] ?? 0 }},{{ $chartStatusValidator['dalam_proses'] ?? 0 }}], backgroundColor: ['#16a34a','#dc2626','#d97706'], borderWidth: 0, hoverOffset: 8 }]
            },
            options: { ...chartDefaults, cutout: '65%' }
        });
    }

    // ── Validator: SKPD bar ──
    const valSkpdCanvas = document.getElementById('validatorSkpdChart');
    if (valSkpdCanvas) {
        new Chart(valSkpdCanvas, {
            type: 'bar',
            data: {
                labels: {!! json_encode($validatorSkpdLabels) !!},
                datasets: [{ label: 'Total Rekonsiliasi', data: {!! json_encode($validatorSkpdData) !!}, backgroundColor: '#2952E3', borderRadius: 6, borderSkipped: false }]
            },
            options: { ...chartDefaults, scales: { y: { beginAtZero: true, ticks: { precision: 0 } }, x: { grid: { display: false } } } }
        });
    }

});
</script>
@endpush