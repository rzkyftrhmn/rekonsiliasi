@extends('layouts.app')
@section('content')
<h1 class="h3 mb-4 text-gray-800">{{ $title }}</h1>

<div class="card shadow">
    <div class="card-body">

        <form method="POST"
              action="{{ $skpd ? route('admin.skpd.update', $skpd->id) : route('admin.skpd.store') }}">

            @csrf
            @if($skpd)
                @method('PUT')
            @endif

            <div class="form-group">
                <label>Nama SKPD</label>
                <input type="text"
                       name="nama_skpd"
                       class="form-control"
                       value="{{ old('nama_skpd', $skpd->nama_skpd ?? '') }}">
            </div>

            <div class="form-group">
                <label>Jenis Instansi</label>
                <select name="jenis" class="form-control" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="skpd"
                        {{ old('jenis', $skpd->jenis ?? '') == 'skpd' ? 'selected' : '' }}>
                        SKPD
                    </option>
                    <option value="bpkad"
                        {{ old('jenis', $skpd->jenis ?? '') == 'bpkad' ? 'selected' : '' }}>
                        BPKAD
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection