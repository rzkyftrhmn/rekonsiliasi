@extends('layouts.app')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Instansi</h1>
    <a href="{{ route('admin.skpd.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> 
        Tambah Instansi
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center">
        <h6 class="m-0 font-weight-bold">Tabel Instansi</h6>

        <form action="{{ route('admin.skpd.index') }}" method="GET" class="form-inline ml-auto mw-100 navbar-search">
            <div class="input-group">
                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control bg-light border-0 small"
                    placeholder="Cari Nama Instansi ..."
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>No</th>
                        <th>Nama Instansi</th>
                        <th>Jenis</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($skpd as $s)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $s->nama_skpd }}</td>
                        <td>{{ $s->jenis }}</td>
                        <td>{{ $s->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.skpd.edit', $s->id) }}"
                            class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.skpd.destroy', $s->id) }}"
                                method="POST"
                                class="d-inline delete-form">
                                @csrf
                                @method('DELETE')

                                <button type="button" class="btn btn-sm btn-danger btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $skpd->links() }}
        </div>
    </div>
</div>
@endsection