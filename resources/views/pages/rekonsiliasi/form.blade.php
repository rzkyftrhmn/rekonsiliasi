@extends('layouts.app')

@section('content')
<h1 class="h3 mb-4 text-gray-800">{{ $title }}</h1>

<div class="card shadow">
    <div class="card-body">

        <form method="POST"
              action="{{ $rekonsiliasi
                ? route('rekonsiliasi.update', $rekonsiliasi->id)
                : route('rekonsiliasi.store') }}"
              enctype="multipart/form-data">

            @csrf
            @if($rekonsiliasi)
                @method('PUT')
            @endif

            <div class="form-group">
                <label>SKPD</label>
                <select name="skpd_id" class="form-control" required>
                    <option value="">-- Pilih SKPD --</option>
                    @foreach($skpds as $skpd)
                        <option value="{{ $skpd->id }}"
                            {{ old('skpd_id', $rekonsiliasi->skpd_id ?? '') == $skpd->id ? 'selected' : '' }}>
                            {{ $skpd->nama_skpd }}
                        </option>
                    @endforeach
                </select>
                @error('skpd_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Rekening</label>
                <select name="rekening_id" class="form-control" required>
                    <option value="">-- Pilih Rekening --</option>
                    @foreach($rekenings as $rekening)
                        <option value="{{ $rekening->id }}"
                            {{ old('rekening_id', $rekonsiliasi->rekening_id ?? '') == $rekening->id ? 'selected' : '' }}>
                            {{ $rekening->nama_rekening }}
                        </option>
                    @endforeach
                </select>
                @error('rekening_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Periode</label>
                <select name="periode_id" class="form-control" required>
                    <option value="">-- Pilih Periode --</option>
                    @foreach($periodes as $periode)
                        <option value="{{ $periode->id }}"
                            {{ old('periode_id', $rekonsiliasi->periode_id ?? '') == $periode->id ? 'selected' : '' }}>
                            {{ $periode->nama_periode }} - {{ $periode->tahun }}
                        </option>
                    @endforeach
                </select>
                @error('periode_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Nilai SKPD</label>
                <input type="number"
                       name="nilai_skpd"
                       class="form-control"
                       value="{{ old('nilai_skpd', $rekonsiliasi->nilai_skpd ?? '') }}"
                       required>
                @error('nilai_skpd')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Upload Dokumen</label>
                <input type="file"
                       name="dokumen[]"
                       class="form-control"
                       multiple>
                <small class="text-muted">
                    PDF / JPG / PNG (maks 2MB)
                </small>
                @error('dokumen.*')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            @if($rekonsiliasi && $rekonsiliasi->dokumen->count())
                <hr>
                <label>Dokumen Tersimpan</label>
                <ul>
                    @foreach($rekonsiliasi->dokumen as $doc)
                        <li>
                            <a href="{{ asset('storage/'.$doc->path_file) }}"
                               target="_blank">
                                {{ $doc->nama_file }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif

            <button class="btn btn-primary">
                {{ $rekonsiliasi ? 'Update' : 'Simpan' }}
            </button>

            <a href="{{ route('rekonsiliasi.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>
@endsection
