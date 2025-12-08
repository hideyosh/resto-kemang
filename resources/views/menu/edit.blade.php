@extends('layouts.app')

@section('title', 'Edit Menu Item - Resto Kemang')

@section('content')
<section class="py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold mb-4">Edit Menu Item</h1>
            <p class="text-gray-400">Update details for the menu item</p>
        </div>

        @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
            <h3 class="font-bold mb-2">Validation Errors:</h3>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-gray-800 p-8 rounded-lg">
            <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Menu Name -->
                <div>
                    <label class="block text-sm font-medium mb-2">Menu Name *</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $menu->name) }}"
                        required
                        class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 {{ $errors->has('name') ? 'ring-2 ring-red-500' : '' }}"
                        placeholder="e.g., Spicy Tuna Roll">
                    @error('name')
                    <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium mb-2">Description</label>
                    <textarea
                        name="description"
                        rows="4"
                        class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 {{ $errors->has('description') ? 'ring-2 ring-red-500' : '' }}"
                        placeholder="Describe the menu item...">{{ old('description', $menu->description) }}</textarea>
                    @error('description')
                    <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Category and Price Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium mb-2">Category *</label>
                        <select
                            name="category"
                            required
                            class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 {{ $errors->has('category') ? 'ring-2 ring-red-500' : '' }}">
                            <option value="">Select Category</option>
                            <option value="sushi" {{ old('category', $menu->category) === 'sushi' ? 'selected' : '' }}>Sushi</option>
                            <option value="ramen" {{ old('category', $menu->category) === 'ramen' ? 'selected' : '' }}>Ramen</option>
                            <option value="wagyu" {{ old('category', $menu->category) === 'wagyu' ? 'selected' : '' }}>Wagyu</option>
                            <option value="drinks" {{ old('category', $menu->category) === 'drinks' ? 'selected' : '' }}>Drinks</option>
                        </select>
                        @error('category')
                        <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-medium mb-2">Price (Rp) *</label>
                        <input
                            type="number"
                            name="price"
                            value="{{ old('price', $menu->price) }}"
                            required
                            min="0"
                            class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 {{ $errors->has('price') ? 'ring-2 ring-red-500' : '' }}"
                            placeholder="50000">
                        @error('price')
                        <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-medium mb-2">Image</label>
                    <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center hover:border-yellow-400 transition">
                        <input
                            type="file"
                            name="image"
                            accept="image/*"
                            id="imageInput"
                            class="hidden"
                            onchange="previewImage(event)">
                        <label for="imageInput" class="cursor-pointer">
                            <div class="text-gray-400">
                                <p class="text-lg mb-2">📷 Click to upload or drag and drop</p>
                                <p class="text-sm">PNG, JPG, GIF, WEBP (Max 2MB)</p>
                            </div>
                        </label>

                        @if($menu->image)
                            <img id="imagePreview" src="{{ asset('img/' . $menu->image) }}" class="mt-4 max-h-48 mx-auto rounded-lg">
                        @else
                            <img id="imagePreview" class="hidden mt-4 max-h-48 mx-auto rounded-lg">
                        @endif
                    </div>
                    @error('image')
                    <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Available Checkbox -->
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        name="is_available"
                        value="1"
                        id="is_available"
                        {{ old('is_available', $menu->is_available) ? 'checked' : '' }}
                        class="w-4 h-4 rounded">
                    <label for="is_available" class="ml-2 text-sm">Available for order</label>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4">
                    <button
                        type="submit"
                        class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 rounded-lg transition">
                        Update Menu Item
                    </button>
                    <a
                        href="{{ route('admin.menu.index') }}"
                        class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 rounded-lg transition text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('imagePreview');
        preview.src = reader.result;
        preview.classList.remove('hidden');
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
