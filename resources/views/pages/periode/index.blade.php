@extends('layouts.app')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Periode</h1>
    <a href="{{ route('admin.periode.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> 
        Tambah Periode
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center">
        <h6 class="m-0 font-weight-bold">Tabel Periode</h6>

        <form action="{{ route('admin.periode.index') }}" method="GET" class="form-inline ml-auto mw-100 navbar-search">
            <div class="input-group">
                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control bg-light border-0 small"
                    placeholder="Cari Nama Periode ..."
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
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Periode</th>
                        <th>Tahun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($periode as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->nama_periode }}</td>
                        <td>{{ $p->tahun }}</td>
                        <td>
                            <a href="{{ route('admin.periode.edit', $p->id) }}"
                            class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.periode.destroy', $p->id) }}"
                                method="POST"
                                class="d-inline form-delete">
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
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $periode->links() }}
        </div>
    </div>
</div>
@endsection