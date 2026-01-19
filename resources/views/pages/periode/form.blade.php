@extends('layouts.app')
@section('content')
<h1 class="h3 mb-4 text-gray-800">{{ $title }}</h1>

<div class="card shadow">
    <div class="card-body">

        <form method="POST"
              action="{{ $periode ? route('admin.periode.update', $periode->id) : route('admin.periode.store') }}">

            @csrf
            @if($periode)
                @method('PUT')
            @endif

            <div class="form-group">
                <label>Nama Periode</label>
                <input type="text"
                       name="nama_periode"
                       class="form-control"
                       value="{{ old('nama_periode', $periode->nama_periode ?? '') }}">
                @error('nama_periode')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Tahun</label>
                <select name="tahun" class="form-control" required>
                    <option value="">-- Pilih Tahun --</option>
                    @for ($y = date('Y'); $y >= 2000; $y--)
                        <option value="{{ $y }}"
                            {{ old('tahun', $periode->tahun ?? '') == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
                @error('tahun')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>

            <a href="{{ route('admin.periode.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </form>
    </div>
</div>
@endsection