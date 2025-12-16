@extends('layouts.admin')

@section('title', 'Kelola Menu')
@section('header', 'Kelola Menu')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Menu</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <a href="{{ route('admin.menu.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah Menu
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th style="width: 150px" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($menus as $menu)
                                    <tr>
                                        <td>{{ ($menus->currentPage() - 1) * $menus->perPage() + $loop->iteration }}</td>
                                        <td>{{ $menu->name }}</td>
                                        <td>{{ ucfirst($menu->category) }}</td>
                                        <td class="font-weight-bold">
                                            Rp {{ number_format($menu->price) }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-pencil-alt"></i> Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.menu.destroy', $menu->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus menu ini?');">
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
                                        <td colspan="5" class="text-center">Tidak ada menu ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $menus->links('pagination::bootstrap-4') }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
