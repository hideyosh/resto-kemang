@extends('layouts.app')

@section('title', 'Create Menu Item - Admin')

@section('content')
<div class="min-h-screen bg-gray-100">

    <!-- Admin Navbar -->
    <nav class="bg-black text-white px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Admin · Create Menu</h1>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded transition">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <section class="py-12 px-4">
        <div class="max-w-2xl mx-auto">

            <!-- Back -->
            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}"
                   class="text-blue-600 hover:underline">
                    ← Kembali ke Dashboard
                </a>
            </div>

            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold text-black mb-2">
                    Create New Menu Item
                </h1>
                <p class="text-gray-600">
                    Tambahkan menu baru ke restoran
                </p>
            </div>

            {{-- Error --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-6">
                    <h3 class="font-bold mb-2">Validation Errors:</h3>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Success --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-8 rounded-lg shadow">
                <form action="{{ route('admin.menu.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-black mb-2">
                            Menu Name *
                        </label>
                        <input type="text" name="name"
                            value="{{ old('name') }}"
                            required
                            class="w-full border px-4 py-2 rounded focus:ring-2 focus:ring-yellow-500 text-black">
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-black mb-2">
                            Description
                        </label>
                        <textarea name="description" rows="4"
                            class="w-full border px-4 py-2 rounded focus:ring-2 focus:ring-yellow-500 text-black">{{ old('description') }}</textarea>
                    </div>

                    <!-- Category & Price -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-black mb-2">
                                Category *
                            </label>
                            <select name="category" required
                                class="w-full border px-4 py-2 rounded text-black">
                                <option value="">Select Category</option>
                                <option value="sushi">Sushi</option>
                                <option value="ramen">Ramen</option>
                                <option value="wagyu">Wagyu</option>
                                <option value="drinks">Drinks</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-black mb-2">
                                Price (Rp) *
                            </label>
                            <input type="number" name="price"
                                value="{{ old('price') }}"
                                min="0" required
                                class="w-full border px-4 py-2 rounded text-black">
                        </div>
                    </div>

                    <!-- Image -->
                    <div>
                        <label class="block text-sm font-medium text-black mb-2">
                            Image
                        </label>
                        <input type="file" name="image"
                            class="w-full border rounded p-2 text-black">
                    </div>

                    <!-- Available -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_available" value="1"
                            checked
                            class="w-4 h-4">
                        <label class="ml-2 text-sm text-black">
                            Available for order
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <button type="submit"
                            class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 rounded">
                            Create Menu
                        </button>

                        <a href="{{ route('admin.menu.index') }}"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-black font-bold py-3 rounded text-center">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </section>
</div>
@endsection
