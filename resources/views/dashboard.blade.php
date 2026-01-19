@extends('layouts.app')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Rekonsiliasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRekonsiliasi }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Dalam Proses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dalamProses }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @if(auth()->user()->role === 'admin')
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header font-weight-bold">
                    Rekonsiliasi Terbaru
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>No</th>
                                    <th>SKPD</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekonsiliasiTerbaru as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->skpd->nama_skpd }}</td>
                                        <td>{{ $item->periode->nama_periode }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($item->status=='valid') badge-success
                                                @elseif($item->status=='selisih') badge-danger
                                                @else badge-warning
                                                @endif">
                                                {{ strtoupper(str_replace('_',' ', $item->status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            Belum ada data
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

    
        @if(auth()->user()->role === 'operator')
        <div class="col-12">
            <div class="card shadow mt-4">
                <div class="card-header font-weight-bold">
                    Rekonsiliasi Terakhir Saya
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>No</th>
                                    <th>Rekening</th>
                                    <th>Nilai SKPD</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekonsiliasiSaya as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->rekening->nama_rekening }}</td>
                                        <td>Rp {{ number_format($item->nilai_skpd,0,',','.') }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($item->status=='valid') badge-success
                                                @elseif($item->status=='selisih') badge-danger
                                                @else badge-warning
                                                @endif">
                                                {{ strtoupper(str_replace('_',' ', $item->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($item->status !== 'dalam_proses')
                                                <a href="{{ route('rekonsiliasi.show', $item->id) }}"
                                                class="btn btn-info btn-sm" style="margin-right: 5px;">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @else
                                                -
                                            @endif

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            Belum ada rekonsiliasi
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif


        @if(auth()->user()->role === 'validator')
        <div class="col-12">
            <div class="card shadow mt-4">
                <div class="card-header font-weight-bold text-success">
                    Perlu Validasi
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>No</th>
                                    <th>SKPD</th>
                                    <th>Periode</th>
                                    <th>Nilai SKPD</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($perluValidasi as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->skpd->nama_skpd }}</td>
                                        <td>{{ $item->periode->nama_periode }}</td>
                                        <td>Rp {{ number_format($item->nilai_skpd,0,',','.') }}</td>
                                        <td>
                                            <a href="{{ route('rekonsiliasi.validasi.form', $item->id) }}"
                                            class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i> Validasi
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            Tidak ada antrian validasi
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
@endsection