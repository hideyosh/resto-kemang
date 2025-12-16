@extends('layouts.admin')

@section('title', 'Create Menu Item')
@section('header', 'Create Menu Item')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Create New Menu Item</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Menu Name *</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" placeholder="Enter menu name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="3" placeholder="Enter description">{{ old('description') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Category *</label>
                                    <select name="category" class="form-control" required>
                                        <option value="">Select Category</option>
                                        <option value="sushi">Sushi</option>
                                        <option value="ramen">Ramen</option>
                                        <option value="wagyu">Wagyu</option>
                                        <option value="drinks">Drinks</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="price">Price (Rp) *</label>
                                    <input type="number" name="price" class="form-control" id="price" value="{{ old('price') }}" min="0" placeholder="Enter price" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="image">
                                    <label class="custom-file-label" for="image">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_available" class="form-check-input" id="is_available" value="1" checked>
                            <label class="form-check-label" for="is_available">Available for order</label>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">Create Menu</button>
                        <a href="{{ route('admin.menu.index') }}" class="btn btn-default float-right">Cancel</a>
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
