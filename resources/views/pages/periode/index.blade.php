@extends('layouts.app')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Periode</h1>
    <a href="{{ route('admin.periode.create') }}"
       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Periode
    </a>
</div>

{{-- ═══════════════════════════════════════
     CARD GENERATE OTOMATIS
═══════════════════════════════════════ --}}
<div class="card shadow mb-4"
     style="border:none; border-radius:16px; overflow:hidden;">

    {{-- top strip biru --}}
    <div style="height:4px; background:linear-gradient(90deg,#1A3EC7,#5B7FF5);"></div>

    <div class="card-body py-3 px-4">
        <div class="d-flex align-items-center flex-wrap gap-3">

            {{-- icon + teks --}}
            <div class="d-flex align-items-center gap-3 mr-auto">
                <div style="width:42px;height:42px;background:#EEF2FF;border-radius:11px;display:grid;place-items:center;flex-shrink:0;">
                    <svg width="20" height="20" fill="none" stroke="#2952E3" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8"  y1="2" x2="8"  y2="6"/>
                        <line x1="3"  y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <div>
                    <div style="font-size:13px;font-weight:700;color:#1A2340;">Generate Periode Otomatis</div>
                    <div style="font-size:12px;color:#6B7A99;">Buat 12 bulan (Januari–Desember) sekaligus untuk tahun yang dipilih. Bulan yang sudah ada akan dilewati.</div>
                </div>
            </div>

            {{-- form generate --}}
            <form action="{{ route('admin.periode.generate') }}"
                  method="POST"
                  class="d-flex align-items-center gap-2"
                  style="flex-wrap:wrap;">
                @csrf
                <select name="tahun"
                        class="form-control form-control-sm"
                        style="width:120px;border-radius:9px;border:1.5px solid #D0D9F0;font-weight:600;color:#1A2340;"
                        required>
                    @for ($y = date('Y') + 1; $y >= 2020; $y--)
                        <option value="{{ $y }}"
                            {{ $y == $tahunSekarang ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>

                <button type="submit"
                        class="btn btn-sm btn-primary"
                        style="border-radius:9px;font-weight:600;padding:6px 18px;margin-left: 7px;">
                    <i class="fas fa-magic mr-1"></i> Generate
                </button>
            </form>

        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════
     CARD TABEL PERIODE
═══════════════════════════════════════ --}}
<div class="card shadow mb-4" style="border:none; border-radius:16px; overflow:hidden;">
    <div class="card-header py-3 d-flex align-items-center"
         style="background:#fff; border-bottom:1.5px solid #EEF2FF;">
        <h6 class="m-0 font-weight-bold" style="color:#1A2340;">Tabel Periode</h6>

        <form action="{{ route('admin.periode.index') }}" method="GET"
              class="form-inline ml-auto">
            <div class="input-group input-group-sm">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       style="border-radius:9px 0 0 9px; border:1.5px solid #D0D9F0;"
                       placeholder="Cari nama periode...">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"
                            style="border-radius:0 9px 9px 0;">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="background:#1A3EC7;color:#fff;font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;padding:11px 16px;border:none;width:60px;">No</th>
                        <th style="background:#1A3EC7;color:#fff;font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;padding:11px 16px;border:none;">Nama Periode</th>
                        <th style="background:#1A3EC7;color:#fff;font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;padding:11px 16px;border:none;width:120px;">Tahun</th>
                        <th style="background:#1A3EC7;color:#fff;font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;padding:11px 16px;border:none;width:120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($periode as $p)
                    <tr style="transition:background .15s;">
                        <td style="padding:10px 16px;border-color:#F3F6FF;color:#6B7A99;">
                            {{ ($periode->currentPage() - 1) * $periode->perPage() + $loop->iteration }}
                        </td>
                        <td style="padding:10px 16px;border-color:#F3F6FF;font-weight:500;color:#1A2340;">
                            {{ $p->nama_periode }}
                        </td>
                        <td style="padding:10px 16px;border-color:#F3F6FF;">
                            <span style="background:#EEF2FF;color:#2952E3;font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:20px;">
                                {{ $p->tahun }}
                            </span>
                        </td>
                        <td style="padding:10px 16px;border-color:#F3F6FF;">
                            <a href="{{ route('admin.periode.edit', $p->id) }}"
                               class="btn btn-sm btn-warning"
                               style="border-radius:8px;">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.periode.destroy', $p->id) }}"
                                  method="POST" class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="btn btn-sm btn-danger btn-delete"
                                        style="border-radius:8px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2 d-block" style="color:#D0D9F0;"></i>
                            Belum ada data periode
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($periode->hasPages())
        <div class="px-4 py-3" style="border-top:1px solid #F3F6FF;">
            {{ $periode->links() }}
        </div>
        @endif
    </div>
</div>

@endsection