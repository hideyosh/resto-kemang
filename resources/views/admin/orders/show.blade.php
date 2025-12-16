@extends('layouts.admin')

@section('title', 'Detail Order')
@section('header')
    Detail Order #{{ $order->id }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Order Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Order</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>User Account</strong>
                            <p class="text-muted">{{ $order->user?->name ?? 'N/A' }}</p>
                            <hr>
                            <strong>Email</strong>
                            <p class="text-muted">{{ $order->user?->email ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Phone</strong>
                            <p class="text-muted">{{ $order->user?->customer?->phone ?? '-' }}</p>
                            <hr>
                            <strong>Notes</strong>
                            <p class="text-muted">{{ $order->notes ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- Order Items -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Item Order</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Menu Item</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->menuItem->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp {{ number_format($item->price * $item->quantity) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-right">Total Harga:</th>
                                <th>Rp {{ number_format($order->total_price) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- Status Update -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ubah Status Order</h3>
                </div>
                <!-- /.card-header -->
                <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="pending" @selected($order->status === 'pending')>Pending</option>
                                <option value="processing" @selected($order->status === 'processing')>Confirmed</option>
                                <option value="completed" @selected($order->status === 'completed')>Completed</option>
                                <option value="cancelled" @selected($order->status === 'cancelled')>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Status</button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-default float-right">Kembali</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->
            <!-- Status Update -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ubah Status Payment</h3>
                </div>
                <!-- /.card-header -->
                <form method="POST" action="{{ route('admin.orders.update-payment-status', $order->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="payment_status">Status Payment</label>
                            <select name="payment_status" id="payment_status" class="form-control">
                                <option value="pending" @selected($order->payment_status === 'pending')>Pending</option>
                                <option value="processing" @selected($order->payment_status === 'processing')>Confirmed</option>
                                <option value="completed" @selected($order->payment_status === 'completed')>Completed</option>
                                <option value="cancelled" @selected($order->payment_status === 'cancelled')>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Status</button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-default float-right">Kembali</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->

            <!-- Metadata -->
            <div class="card collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Metadata</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <p class="text-muted">
                        Dibuat: {{ $order->created_at->format('d-m-Y H:i') }} <br>
                        Diupdate: {{ $order->updated_at->format('d-m-Y H:i') }}
                    </p>
                </div>
            </div>

        </div>
    </div>
@endsection
