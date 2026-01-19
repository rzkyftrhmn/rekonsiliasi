@extends('layouts.app')
@section('content')
<h1 class="h3 mb-4 text-gray-800">{{ $title }}</h1>

<div class="card shadow">
    <div class="card-body">

        <form method="POST"
              action="{{ $rekening ? route('admin.rekening.update', $rekening->id) : route('admin.rekening.store') }}">

            @csrf
            @if($rekening)
                @method('PUT')
            @endif

            <div class="form-group">
                <label>Kode Rekening</label>
                <input type="text"
                       name="kode_rekening"
                       class="form-control"
                       value="{{ old('kode_rekening', $rekening->kode_rekening ?? '') }}">
                @error('kode_rekening')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Nama Rekening</label>
                <input type="text"
                       name="nama_rekening"
                       class="form-control"
                       value="{{ old('nama_rekening', $rekening->nama_rekening ?? '') }}">
                @error('nama_rekening')
                    <small class="text-danger">{{ $message }}</small>   
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>

            <a href="{{ route('admin.rekening.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </form>
    </div>
</div>
@endsection