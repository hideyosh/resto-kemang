@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 text-black">
        <!-- Admin Navbar -->
        <nav class="bg-black text-white px-6 py-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">Edit User</h1>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded transition">
                        Logout
                    </button>
                </form>
            </div>
        </nav>

        <div class="max-w-2xl mx-auto px-4 py-8 text-black">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    ← Kembali ke Daftar User
                </a>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow p-8 text-black">
                <h2 class="text-2xl font-bold mb-6 text-black">
                    Edit User: {{ $user->name }}
                </h2>

                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-bold mb-2 text-black">
                            Nama Lengkap
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded text-black
                               focus:outline-none focus:border-blue-500
                               @error('name') border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap" required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-bold mb-2 text-black">
                            Email
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded text-black
                               focus:outline-none focus:border-blue-500
                               @error('email') border-red-500 @enderror"
                            placeholder="Masukkan email" required>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-bold mb-2 text-black">
                            Password Baru (Kosongkan jika tidak ingin mengubah)
                        </label>
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded text-black
                               focus:outline-none focus:border-blue-500
                               @error('password') border-red-500 @enderror"
                            placeholder="Masukkan password baru (minimal 8 karakter)">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold mb-2 text-black">
                            Konfirmasi Password
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded text-black
                               focus:outline-none focus:border-blue-500"
                            placeholder="Konfirmasi password baru">
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium mb-2 text-black">
                            Role
                        </label>

                        <select name="role" id="role"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg
               bg-white text-black
               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
               hover:border-gray-400 transition">
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>
                            <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>
                                Customer
                            </option>
                        </select>
                    </div>


                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-bold transition">
                            Update User
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded font-bold transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
