@extends('layouts.admin')

@section('title', 'Kelola Reservasi')
@section('header', 'Kelola Reservasi')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Reservasi</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No</th>
                                    <th>Customer</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Guests</th>
                                    <th>Status</th>
                                    <th style="width: 100px" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reservations as $reservation)
                                    <tr>
                                        <td>{{ ($reservations->currentPage() - 1) * $reservations->perPage() + $loop->iteration }}</td>
                                        <td>
                                            <div class="font-weight-bold">
                                                {{ $reservation->user?->name ?? 'N/A' }}
                                            </div>
                                            <div class="small text-muted">
                                                {{ $reservation->user?->email ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d-m-Y H:i') }}
                                        </td>
                                        <td>{{ $reservation->number_of_guests }} orang</td>
                                        <td>
                                            @if($reservation->status === 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($reservation->status === 'confirmed')
                                                <span class="badge badge-success">Confirmed</span>
                                            @elseif($reservation->status === 'completed')
                                                <span class="badge badge-primary">Completed</span>
                                            @else
                                                <span class="badge badge-danger">{{ ucfirst($reservation->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada reservasi ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $reservations->links('pagination::bootstrap-4') }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
