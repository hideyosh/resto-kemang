@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    <div class="row">
        <!-- Total Users -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalOrders }}</h3>
                    <p>Total Orders</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Total Reservations -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalReservations }}</h3>
                    <p>Total Reservations</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <a href="{{ route('admin.reservations.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Total Menu Items -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalMenuItems }}</h3>
                    <p>Total Menu Items</p>
                </div>
                <div class="icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <a href="{{ route('admin.menu.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-app">
                        <i class="fas fa-user-plus"></i> Tambah User
                    </a>
                    <a href="{{ route('admin.menu.create') }}" class="btn btn-app">
                        <i class="fas fa-plus"></i> Tambah Menu
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-app">
                        <i class="fas fa-list"></i> Lihat Order
                    </a>
                    <a href="{{ route('admin.reservations.index') }}" class="btn btn-app">
                        <i class="fas fa-calendar-alt"></i> Lihat Reservasi
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
