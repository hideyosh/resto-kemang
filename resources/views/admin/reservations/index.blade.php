@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Admin Navbar -->
    <nav class="bg-black text-white px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Kelola Reservasi</h1>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded transition">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:text-blue-700">
                ← Kembali ke Dashboard
            </a>
        </div>

        <!-- Reservations Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-bold">No</th>
                        <th class="px-6 py-3 text-left text-sm font-bold">Customer</th>
                        <th class="px-6 py-3 text-left text-sm font-bold">Tanggal</th>
                        <th class="px-6 py-3 text-left text-sm font-bold">Guests</th>
                        <th class="px-6 py-3 text-left text-sm font-bold">Status</th>
                        <th class="px-6 py-3 text-center text-sm font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reservations as $reservation)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3">{{ ($reservations->currentPage() - 1) * $reservations->perPage() + $loop->iteration }}</td>
                            <td class="px-6 py-3">
                                <div>{{ $reservation->user?->name ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $reservation->user?->email ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-3">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d-m-Y H:i') }}</td>
                            <td class="px-6 py-3">{{ $reservation->number_of_guests }} orang</td>
                            <td class="px-6 py-3">
                                <span class="px-3 py-1 rounded text-white text-sm font-bold
                                    @if($reservation->status === 'pending') bg-yellow-500
                                    @elseif($reservation->status === 'confirmed') bg-green-500
                                    @elseif($reservation->status === 'completed') bg-blue-500
                                    @else bg-red-500
                                    @endif
                                ">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-center">
                                <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-3 text-center text-gray-500">
                                Tidak ada reservasi ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
@endsection
