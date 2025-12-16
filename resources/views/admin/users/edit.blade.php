@extends('layouts.admin')

@section('title', 'Edit User')
@section('header', 'Edit User')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Edit User: {{ $user->name }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Masukkan nama lengkap" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Masukkan email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Masukkan password baru (minimal 8 karakter)">
                            @error('password')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Konfirmasi password baru">
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Update User</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-default float-right">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
