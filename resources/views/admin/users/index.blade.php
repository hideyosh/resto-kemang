@extends('layouts.admin')

@section('title', 'Kelola User')
@section('header', 'Kelola User')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Users</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah User
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Filter -->
                    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-3">
                        <div class="form-row align-items-center">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Role</label>
                                <select name="role" class="form-control mb-2" onchange="this.form.submit()">
                                    <option value="">Semua Role</option>
                                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                                </select>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Dibuat</th>
                                    <th style="width: 150px" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->role === 'admin')
                                                <span class="badge badge-success">Admin</span>
                                            @else
                                                <span class="badge badge-secondary">Customer</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-pencil-alt"></i> Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada user ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
