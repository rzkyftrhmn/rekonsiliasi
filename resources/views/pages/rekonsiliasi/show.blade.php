@extends('layouts.app')

@section('content')
<div class="card shadow">
    <div class="card-header d-flex justify-content-between">
        <h5>Detail Rekonsiliasi</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Instansi</th>
                <td>{{ $rekonsiliasi->skpd->nama_skpd }}</td>
            </tr>
            <tr>
                <th>Rekening</th>
                <td>{{ $rekonsiliasi->rekening->nama_rekening }}</td>
            </tr>
            <tr>
                <th>Periode</th>
                <td>{{ $rekonsiliasi->periode->nama_periode }}</td>
            </tr>
            <tr>
                <th>Nilai SKPD</th>
                <td>Rp {{ number_format($rekonsiliasi->nilai_skpd, 2) }}</td>
            </tr>
            <tr>
                <th>Nilai BPKAD</th>
                <td>
                    {{ $rekonsiliasi->nilai_bpkad
                        ? 'Rp '.number_format($rekonsiliasi->nilai_bpkad, 2)
                        : '-' }}
                </td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <span class="badge badge-info">
                        {{ strtoupper(str_replace('_', ' ', $rekonsiliasi->status)) }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>Validator</th>
                <td>{{ $rekonsiliasi->validator->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Catatan</th>
                <td>{{ $rekonsiliasi->catatan ?? '-' }}</td>
            </tr>
        </table>

        <hr>

        <h6>Dokumen Rekonsiliasi</h6>

        @if($rekonsiliasi->dokumen->count())
            <ul class="list-group">
                @foreach($rekonsiliasi->dokumen as $doc)
                    <li class="list-group-item d-flex justify-content-between">
                        {{ $doc->nama_file }}
                        <button class="btn btn-sm btn-primary"
                                data-toggle="modal"
                                data-target="#modalDokumen{{ $doc->id }}">
                            Lihat
                        </button>
                    </li>

                    {{-- MODAL --}}
                    <div class="modal fade" id="modalDokumen{{ $doc->id }}" tabindex="-1">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ $doc->nama_file }}</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        &times;
                                    </button>
                                </div>
                                <div class="modal-body" style="height: 80vh;">
                                    @php
                                        $ext = pathinfo($doc->path_file, PATHINFO_EXTENSION);
                                    @endphp

                                    @if(in_array($ext, ['jpg','jpeg','png']))
                                        <img src="{{ asset('storage/'.$doc->path_file) }}"
                                             class="img-fluid mx-auto d-block">
                                    @elseif($ext === 'pdf')
                                        <iframe src="{{ asset('storage/'.$doc->path_file) }}"
                                                width="100%"
                                                height="100%">
                                        </iframe>
                                    @else
                                        <p class="text-center">
                                            File tidak dapat ditampilkan
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </ul>
            <a href="{{ route('rekonsiliasi.index') }}" class="btn btn-secondary btn-sm mt-3">
                Kembali
            </a>
        @else
            <p class="text-muted">Tidak ada dokumen</p>
        @endif
    </div>
</div>
@endsection
