@extends('layouts.app')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">User</h1>
    <a href="{{ route('admin.users.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> 
        Tambah User
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center">
        <h6 class="m-0 font-weight-bold">Tabel User</h6>

        <form action="{{ route('admin.users.index') }}" method="GET" class="form-inline ml-auto mw-100 navbar-search">
            <div class="input-group">
                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control bg-light border-0 small"
                    placeholder="Cari Nama / Username ..."
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
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->username }}</td>
                        <td>{{ $u->role }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $u->id) }}"
                            class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.users.destroy', $u->id) }}"
                                method="POST"
                                class="d-inline delete-form">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger btn-delete" type="button">
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
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection