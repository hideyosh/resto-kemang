@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 text-black">
        <!-- Admin Navbar -->
        <nav class="bg-black text-white px-6 py-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">Edit Menu</h1>
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
                <a href="{{ route('admin.menu.index') }}" class="text-blue-500 hover:text-blue-700">
                    ← Kembali ke Daftar Menu
                </a>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow p-8 text-black">
                <h2 class="text-2xl font-bold mb-6 text-black">
                    Edit Menu: {{ $menu->name }}
                </h2>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul class="list-disc pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.menu.update', $menu->id) }}" enctype="multipart/form-data"
                    class="space-y-6 text-black">
                    @csrf
                    @method('PUT')

                    <!-- Nama Menu -->
                    <div>
                        <label class="block text-sm font-bold mb-2 text-black">Nama Menu</label>
                        <input type="text" name="name" value="{{ old('name', $menu->name) }}"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded
                               text-black
                               focus:outline-none focus:border-blue-500
                               @error('name') border-red-500 @enderror"
                            required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-bold mb-2 text-black">Deskripsi</label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded
                               text-black
                               focus:outline-none focus:border-blue-500
                               @error('description') border-red-500 @enderror">{{ old('description', $menu->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori & Harga -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kategori -->
                        <div>
                            <label class="block text-sm font-bold mb-2 text-black">Kategori</label>
                            <select name="category"
                                class="w-full px-4 py-2 border-2 border-gray-300 rounded
                                   text-black
                                   focus:outline-none focus:border-blue-500
                                   @error('category') border-red-500 @enderror"
                                required>
                                <option value="">Pilih Kategori</option>
                                <option value="sushi" {{ old('category', $menu->category) == 'sushi' ? 'selected' : '' }}>
                                    Sushi</option>
                                <option value="ramen" {{ old('category', $menu->category) == 'ramen' ? 'selected' : '' }}>
                                    Ramen</option>
                                <option value="wagyu" {{ old('category', $menu->category) == 'wagyu' ? 'selected' : '' }}>
                                    Wagyu</option>
                                <option value="drinks"
                                    {{ old('category', $menu->category) == 'drinks' ? 'selected' : '' }}>Minuman</option>
                            </select>
                            @error('category')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div>
                            <label class="block text-sm font-bold mb-2 text-black">Harga (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $menu->price) }}"
                                class="w-full px-4 py-2 border-2 border-gray-300 rounded
                                   text-black
                                   focus:outline-none focus:border-blue-500
                                   @error('price') border-red-500 @enderror"
                                required>
                            @error('price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Gambar -->
                    <div>
                        <label class="block text-sm font-bold mb-2 text-black">Gambar Menu</label>
                        <input type="file" name="image"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded text-black">

                        @if ($menu->image)
                            <img src="{{ asset('img/' . $menu->image) }}" class="mt-4 max-h-40 rounded">
                        @endif

                        @error('image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Available -->
                    <div class="flex items-center text-black">
                        <input type="checkbox" name="is_available" value="1"
                            {{ old('is_available', $menu->is_available) ? 'checked' : '' }} class="w-4 h-4">
                        <label class="ml-2 text-sm font-semibold text-black">
                            Tersedia untuk dipesan
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded font-bold transition">
                            Update Menu
                        </button>
                        <a href="{{ route('admin.menu.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded font-bold transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
