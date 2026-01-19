@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Validasi Rekonsiliasi</h5>
    </div>

    <div class="card-body">
        <form method="POST"
              action="{{ route('rekonsiliasi.validasi.store', $rekonsiliasi->id) }}">
            @csrf

            <div class="mb-3">
                <label>Nilai SKPD</label>
                <input type="text"
                       class="form-control"
                       value="{{ number_format($rekonsiliasi->nilai_skpd, 2) }}"
                       readonly>
            </div>

            <ul class="list-group mb-3">
                <label>Dokumen</label>
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

            <div class="mb-3">
                <label>Nilai BPKAD</label>
                <input type="number"
                       name="nilai_bpkad"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="valid">Valid</option>
                    <option value="selisih">Selisih</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Catatan</label>
                <textarea name="catatan"
                          class="form-control"
                          rows="3"></textarea>
            </div>

            <button class="btn btn-success">
                Simpan Validasi
            </button>
            <a href="{{ route('rekonsiliasi.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>
        </form>
    </div>
</div>
@endsection
