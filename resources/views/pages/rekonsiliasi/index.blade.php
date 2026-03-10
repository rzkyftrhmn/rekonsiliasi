@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="h3 mb-4 text-gray-800">Data Rekonsiliasi</h1>
    @if(auth()->user()->role === 'operator' || auth()->user()->role === 'admin')
        <a href="{{ route('rekonsiliasi.create') }}"
            class="btn btn-primary mb-3">
            + Tambah Rekonsiliasi
        </a>
    @endif
</div>

<div class="card shadow mb-2">
    <div class="card-body">

        <div class="row">

            <div class="col-lg-5 col-12 mb-3 mb-lg-0">
                <div class="d-flex flex-wrap gap-2">

                    <div class="card border-left-warning shadow-sm flex-fill">
                        <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                            <span class="badge badge-warning">Dalam Proses</span>
                            <span class="font-weight-bold">{{ $countDalamProses }}</span>
                        </div>
                    </div>

                    <div class="card border-left-danger shadow-sm flex-fill">
                        <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                            <span class="badge badge-danger">Selisih</span>
                            <span class="font-weight-bold">{{ $countSelisih }}</span>
                        </div>
                    </div>

                    <div class="card border-left-success shadow-sm flex-fill">
                        <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                            <span class="badge badge-success">Valid</span>
                            <span class="font-weight-bold">{{ $countValid }}</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-7 col-12">
                <form method="GET" action="{{ route('rekonsiliasi.index') }}">
                    <div class="row g-2 justify-content-lg-end">

                        <div class="col-md-3 col-12">
                            <select name="periode_id" class="form-control form-control-sm">
                                <option value="">Periode</option>
                                @foreach($periodes as $periode)
                                    <option value="{{ $periode->id }}"
                                        {{ request('periode_id') == $periode->id ? 'selected' : '' }}>
                                        {{ $periode->nama_periode }} - {{ $periode->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 col-12">
                            <select name="status" class="form-control form-control-sm">
                                <option value="">Status</option>
                                <option value="dalam_proses" {{ request('status')=='dalam_proses'?'selected':'' }}>
                                    Dalam Proses
                                </option>
                                <option value="valid" {{ request('status')=='valid'?'selected':'' }}>
                                    Valid
                                </option>
                                <option value="selisih" {{ request('status')=='selisih'?'selected':'' }}>
                                    Selisih
                                </option>
                            </select>
                        </div>

                        <div class="col-md-4 col-12">
                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control form-control-sm"
                                placeholder="Cari SKPD / Rekening">
                        </div>

                        <div class="col-md-2 col-6">
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>

                        <div class="col-md-2 col-6 mt-2">
                            <a href="{{ route('rekonsiliasi.index') }}"
                               class="btn btn-secondary btn-sm w-100">
                                <i class="fas fa-sync-alt"></i> Reset
                            </a>
                        </div>

                    </div>
                </form>
            </div>

        </div>

    </div>
</div>

<div class="card shadow">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>No</th>
                        <th>SKPD</th>
                        <th>Rekening</th>
                        <th>Periode</th>
                        <th>Nilai SKPD</th>
                        <th>Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($rekonsiliasis as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->skpd->nama_skpd }}</td>
                        <td>{{ $item->rekening->nama_rekening }}</td>
                        <td>{{ $item->periode->nama_periode }} - {{ $item->periode->tahun }}</td>
                        <td>Rp {{ number_format($item->nilai_skpd, 2, ',', '.') }}</td>
                        <td>
                            <span class="badge 
                                @if($item->status=='valid') badge-success
                                @elseif($item->status=='selisih') badge-danger
                                @else badge-warning
                                @endif">
                                {{ strtoupper(str_replace('_',' ', $item->status)) }}
                            </span>
                        </td>
                        <td class="d-flex gap-2 align-items-center">
                            @php
                                $showAction = false;
                            @endphp

                            @if($item->status !== 'dalam_proses')
                                @php $showAction = true; @endphp
                                <a href="{{ route('rekonsiliasi.show', $item->id) }}"
                                class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @endif

                            @if(auth()->user()->role === 'operator' || auth()->user()->role === 'admin' && $item->status === 'dalam_proses')
                                @php $showAction = true; @endphp

                                <a href="{{ route('rekonsiliasi.edit', $item->id) }}"
                                class="btn btn-warning btn-sm mr-1">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('rekonsiliasi.destroy', $item->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="button">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif

                            @if(auth()->user()->role === 'validator' && $item->status === 'dalam_proses')
                                @php $showAction = true; @endphp

                                <a href="{{ route('rekonsiliasi.validasi.form', $item->id) }}"
                                class="btn btn-success btn-sm">
                                    Validasi
                                </a>
                            @endif

                            @if(!$showAction)
                                <span>-</span>
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Data belum tersedia
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $rekonsiliasis->links() }}

    </div>
</div>
@endsection
