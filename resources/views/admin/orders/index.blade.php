@extends('layouts.admin')

@section('title', 'Kelola Order')
@section('header', 'Kelola Order')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Order</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No</th>
                                    <th>Customer</th>
                                    <th>Phone</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th style="width: 100px" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
                                        <td>
                                            <div class="font-weight-bold">
                                                {{ $order->user?->name ?? 'N/A' }}
                                            </div>
                                            <div class="small text-muted">
                                                {{ $order->user?->email ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td>{{ $order->user?->customer?->phone ?? '-' }}</td>
                                        <td class="font-weight-bold">
                                            Rp {{ number_format($order->total_price) }}
                                        </td>
                                        <td>
                                            @if ($order->status === 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($order->status === 'confirmed')
                                                <span class="badge badge-primary">Confirmed</span>
                                            @elseif($order->status === 'completed')
                                                <span class="badge badge-success">Completed</span>
                                            @else
                                                <span class="badge badge-danger">{{ ucfirst($order->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada order ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $orders->links('pagination::bootstrap-4') }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
