@extends('layouts.app')

@section('content')

<h1 class="h3 mb-4 text-gray-800">{{ $title }}</h1>

<div class="card shadow">
    <div class="card-body">

        <form method="POST"
              action="{{ $user ? route('admin.users.update', $user->id) : route('admin.users.store') }}">

            @csrf
            @if($user)
                @method('PUT')
            @endif

            <div class="form-group">
                <label>Nama</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name', $user->name ?? '') }}">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text"
                       name="username"
                       class="form-control"
                       value="{{ old('username', $user->username ?? '') }}">
                @error('username')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role" id="role" class="form-control">
                    <option value="">-- Pilih Role --</option>
                    <option value="admin"
                        {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                    <option value="operator"
                        {{ old('role', $user->role ?? '') == 'operator' ? 'selected' : '' }}>   
                        Operator
                    </option>
                    <option value="validator"
                        {{ old('role', $user->role ?? '') == 'validator' ? 'selected' : '' }}>
                        Validator
                    </option>
                </select>
                @error('role')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>



            <div class="form-group" id="instansi-wrapper" style="display: none;">
                <label>Instansi</label>
                <select name="skpd_id" class="form-control">
                    <option value="">-- Pilih Instansi --</option>
                    @foreach($skpds as $item)
                        <option value="{{ $item->id }}"
                            {{ old('skpd_id', $user->skpd_id ?? '') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_skpd }} ({{ strtoupper($item->jenis) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Password {{ $user ? '(Kosongkan jika tidak diubah)' : '' }}</label>
                <input type="password" name="password" class="form-control">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Konfirmasi Password {{ $user ? '(Kosongkan jika tidak diubah)' : '' }}</label>
                <input type="password"
                    name="password_confirmation"
                    class="form-control">
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            <button class="btn btn-primary">
                {{ $user ? 'Update' : 'Simpan' }}
            </button>

            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection
@push('scripts')
<script>
    function toggleInstansi() {
        const role = document.getElementById('role').value;
        const instansi = document.getElementById('instansi-wrapper');

        if (role && role !== 'admin') {
            instansi.style.display = 'block';
        } else {
            instansi.style.display = 'none';
        }
    }

    document.getElementById('role').addEventListener('change', toggleInstansi);

    document.addEventListener('DOMContentLoaded', toggleInstansi);
</script>
@endpush
