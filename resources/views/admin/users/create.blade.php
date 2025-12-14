@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100">
        <!-- Admin Navbar -->
        <nav class="bg-black text-white px-6 py-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">Tambah User</h1>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded transition text-black">
                        Logout
                    </button>
                </form>
            </div>
        </nav>

        <div class="max-w-2xl mx-auto px-4 py-8">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('admin.users.index') }}" class="text-blue-500 hover:text-blue-700 text-black">
                    ← Kembali ke Daftar User
                </a>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow p-8">
                <h2 class="text-2xl font-bold mb-6 text-black">Tambah User Baru</h2>

                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                    @csrf

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm mb-2 text-black">
                            Nama Lengkap
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded text-black focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap" required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 text-black">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm mb-2 text-black">
                            Email
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded text-black focus:outline-none focus:border-blue-500 @error('email') border-red-500 @enderror"
                            placeholder="Masukkan email" required>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 text-black">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm mb-2 text-black">
                            Password
                        </label>
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded text-black focus:outline-none focus:border-blue-500 @error('password') border-red-500 @enderror"
                            placeholder="Masukkan password (minimal 8 karakter)" required>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 text-black">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm mb-2 text-black">
                            Konfirmasi Password
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded text-black focus:outline-none focus:border-blue-500"
                            placeholder="Konfirmasi password" required>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded text-black transition">
                            Simpan User
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded text-black transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
