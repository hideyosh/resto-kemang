@extends('layouts.admin')

@section('title', 'Edit Menu')
@section('header', 'Edit Menu')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Menu: {{ $menu->name }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('admin.menu.update', $menu->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Menu</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $menu->name) }}" required>
                            @error('name')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3">{{ old('description', $menu->description) }}</textarea>
                            @error('description')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="category" class="form-control @error('category') is-invalid @enderror" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="sushi" {{ old('category', $menu->category) == 'sushi' ? 'selected' : '' }}>Sushi</option>
                                        <option value="ramen" {{ old('category', $menu->category) == 'ramen' ? 'selected' : '' }}>Ramen</option>
                                        <option value="wagyu" {{ old('category', $menu->category) == 'wagyu' ? 'selected' : '' }}>Wagyu</option>
                                        <option value="drinks" {{ old('category', $menu->category) == 'drinks' ? 'selected' : '' }}>Minuman</option>
                                    </select>
                                    @error('category')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="price">Harga (Rp)</label>
                                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" id="price" value="{{ old('price', $menu->price) }}" required>
                                    @error('price')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image">Gambar Menu</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="image">
                                    <label class="custom-file-label" for="image">Choose file</label>
                                </div>
                            </div>
                            @if ($menu->image)
                                <div class="mt-2">
                                    <img src="{{ asset('img/' . $menu->image) }}" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                            @endif
                            @error('image')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_available" class="form-check-input" id="is_available" value="1" {{ old('is_available', $menu->is_available) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_available">Tersedia untuk dipesan</label>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Menu</button>
                        <a href="{{ route('admin.menu.index') }}" class="btn btn-default float-right">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Custom file input label
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
@endsection
