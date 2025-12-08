@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Admin Navbar -->
    <nav class="bg-black text-white px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Kelola Menu</h1>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded transition">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-4">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:text-blue-700">← Kembali ke Dashboard</a>
        </div>

        <div class="mb-6 flex gap-2">
            <a href="{{ route('admin.menu.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded font-bold transition">➕ Tambah Menu Baru</a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-bold">No</th>
                        <th class="px-6 py-3 text-left text-sm font-bold">Nama</th>
                        <th class="px-6 py-3 text-left text-sm font-bold">Kategori</th>
                        <th class="px-6 py-3 text-left text-sm font-bold">Harga</th>
                        <th class="px-6 py-3 text-center text-sm font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menus as $menu)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3">{{ ($menus->currentPage() - 1) * $menus->perPage() + $loop->iteration }}</td>
                            <td class="px-6 py-3">{{ $menu->name }}</td>
                            <td class="px-6 py-3">{{ ucfirst($menu->category) }}</td>
                            <td class="px-6 py-3 font-bold">Rp {{ number_format($menu->price) }}</td>
                            <td class="px-6 py-3 text-center">
                                <a href="{{ route('admin.menu.edit', $menu->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition">Edit</a>

                                <form method="POST" action="{{ route('admin.menu.destroy', $menu->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus menu ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-3 text-center text-gray-500">Tidak ada menu ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $menus->links() }}
        </div>
    </div>
</div>
@endsection
