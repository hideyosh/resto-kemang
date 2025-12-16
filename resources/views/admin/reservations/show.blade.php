@extends('layouts.admin')

@section('title', 'Detail Reservasi')
@section('header')
    Detail Reservasi #{{ $reservation->id }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <!-- Reservation Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Reservasi</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong>Nama Customer</strong>
                    <p class="text-muted">{{ $reservation->user?->name ?? 'N/A' }}</p>
                    <hr>
                    
                    <strong>User Account</strong>
                    <p class="text-muted">{{ $reservation->user?->name ?? 'N/A' }}</p>
                    <hr>

                    <strong>Email</strong>
                    <p class="text-muted">{{ $reservation->user?->email ?? 'N/A' }}</p>
                    <hr>

                    <strong>Telepon</strong>
                    <p class="text-muted">{{ $reservation->user?->customer?->phone ?? '-' }}</p>
                    <hr>

                    <strong>Tanggal & Waktu Reservasi</strong>
                    <p class="text-muted">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d-m-Y H:i') }}</p>
                    <hr>

                    <strong>Jumlah Tamu</strong>
                    <p class="text-muted">{{ $reservation->number_of_guests }} orang</p>

                    @if ($reservation->notes)
                        <hr>
                        <strong>Catatan</strong>
                        <p class="text-muted">{{ $reservation->notes }}</p>
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

        <div class="col-md-6">
             <!-- Status Update -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Ubah Status Reservasi</h3>
                </div>
                <!-- /.card-header -->
                <form method="POST" action="{{ route('admin.reservations.update-status', $reservation->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="pending" @selected($reservation->status === 'pending')>Pending</option>
                                <option value="confirmed" @selected($reservation->status === 'confirmed')>Confirmed</option>
                                <option value="completed" @selected($reservation->status === 'completed')>Completed</option>
                                <option value="cancelled" @selected($reservation->status === 'cancelled')>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">Update Status</button>
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-default float-right">Kembali</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->

             <!-- Metadata -->
             <div class="card collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Metadata</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <p class="text-muted">
                        Dibuat: {{ $reservation->created_at->format('d-m-Y H:i') }} <br>
                        Diupdate: {{ $reservation->updated_at->format('d-m-Y H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
