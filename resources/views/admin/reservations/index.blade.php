@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 text-black">
    <!-- Admin Navbar -->
    <nav class="bg-black text-white px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Kelola Reservasi</h1>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded transition text-white font-bold">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8 text-black">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:text-blue-700 font-bold">
                ← Kembali ke Dashboard
            </a>
        </div>

        <!-- Reservations Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden text-black">
            <table class="w-full text-black">
                <thead class="bg-gray-200 text-black">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-bold text-black">No</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-black">Customer</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-black">Tanggal</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-black">Guests</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-black">Status</th>
                        <th class="px-6 py-3 text-center text-sm font-bold text-black">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-black">
                    @forelse ($reservations as $reservation)
                        <tr class="border-b hover:bg-gray-50 text-black">
                            <td class="px-6 py-3 text-black">
                                {{ ($reservations->currentPage() - 1) * $reservations->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-6 py-3 text-black">
                                <div class="font-medium text-black">
                                    {{ $reservation->user?->name ?? 'N/A' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $reservation->user?->email ?? 'N/A' }}
                                </div>
                            </td>

                            <td class="px-6 py-3 text-black">
                                {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d-m-Y H:i') }}
                            </td>

                            <td class="px-6 py-3 text-black">
                                {{ $reservation->number_of_guests }} orang
                            </td>

                            <td class="px-6 py-3 text-black">
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
                                <a href="{{ route('admin.reservations.show', $reservation->id) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition font-bold">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-3 text-center text-black font-bold">
                                Tidak ada reservasi ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 text-black font-bold">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
@endsection
