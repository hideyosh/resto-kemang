@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 text-black">
        <!-- Admin Navbar -->
        <nav class="bg-black text-white px-6 py-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">Kelola User</h1>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded transition text-white font-bold">
                        Logout
                    </button>
                </form>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto px-4 py-8 text-black">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:text-blue-700 font-bold">
                    ← Kembali ke Dashboard
                </a>
            </div>

            <!-- Buttons -->
            <div class="mb-6 flex gap-2">
                <a href="{{ route('admin.users.create') }}"
                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded font-bold transition">
                    Tambah User Baru
                </a>
            </div>

            <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4">
                <select name="role"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-black
               focus:outline-none focus:ring-2 focus:ring-blue-500"
                    onchange="this.form.submit()">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                    <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>
                        Customer
                    </option>
                </select>
            </form>


            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-black px-4 py-3 rounded mb-4 font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Message -->
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-black px-4 py-3 rounded mb-4 font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Users Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden text-black">
                <table class="w-full text-black">
                    <thead class="bg-gray-200 text-black">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-bold text-black">No</th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-black">Nama</th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-black">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-black">Role</th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-black">Dibuat</th>
                            <th class="px-6 py-3 text-center text-sm font-bold text-black">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-black">
                        @forelse ($users as $user)
                            <tr class="border-b hover:bg-gray-50 text-black">
                                <td class="px-6 py-3 text-black">
                                    {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-6 py-3 text-black font-medium">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-3 text-black">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-3 text-black">
                                    {{ $user->role }}
                                </td>
                                <td class="px-6 py-3 text-sm text-black">
                                    {{ $user->created_at->format('d-m-Y') }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded text-sm transition font-bold mr-2">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                                        class="inline" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition font-bold">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-3 text-center text-black font-bold">
                                    Tidak ada user ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 text-black font-bold">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
