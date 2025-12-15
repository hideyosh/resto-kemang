@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 text-black">
        <!-- Admin Navbar -->
        <nav class="bg-black text-white px-6 py-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">Detail Reservasi</h1>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded transition">
                        Logout
                    </button>
                </form>
            </div>
        </nav>

        <div class="max-w-2xl mx-auto px-4 py-8">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('admin.reservations.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    ← Kembali ke Daftar Reservasi
                </a>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Reservation Information -->
            <div class="bg-white rounded-lg shadow p-8 text-black">
                <h2 class="text-2xl font-bold mb-6">
                    Reservasi #{{ $reservation->id }}
                </h2>

                <!-- Customer Info -->
                <div class="grid grid-cols-1 gap-6 mb-6">
                    <div>
                        <p class="text-gray-600 text-sm">Nama Customer</p>
                        <p class="text-lg font-bold text-black">
                            {{ $reservation->user?->name ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-600 text-sm">User Account</p>
                        <p class="text-lg font-bold text-black">
                            {{ $reservation->user?->name ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-600 text-sm">Email</p>
                        <p class="text-lg text-black">
                            {{ $reservation->user?->email ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-600 text-sm">Telepon</p>
                        <p class="text-lg text-black">
                            {{ $reservation->user?->customer?->phone ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-600 text-sm">Tanggal & Waktu Reservasi</p>
                        <p class="text-lg font-bold text-black">
                            {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d-m-Y H:i') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-600 text-sm">Jumlah Tamu</p>
                        <p class="text-lg font-bold text-black">
                            {{ $reservation->number_of_guests }} orang
                        </p>
                    </div>
                </div>

                <!-- Notes -->
                @if ($reservation->notes)
                    <div class="mb-6">
                        <p class="text-gray-600 text-sm mb-1">Catatan</p>
                        <p class="p-3 bg-gray-50 rounded text-black">
                            {{ $reservation->notes }}
                        </p>
                    </div>
                @endif

                <!-- Status Update -->
                <div class="mb-6">
                    <h3 class="text-lg font-bold mb-3 text-black">
                        Ubah Status Reservasi
                    </h3>

                    <form method="POST" action="{{ route('admin.reservations.update-status', $reservation->id) }}"
                        class="flex gap-2">
                        @csrf
                        @method('PUT')

                        <select name="status"
                            class="flex-1 px-4 py-2 border-2 border-gray-300 rounded
                               focus:outline-none focus:border-blue-500 text-black">
                            <option value="pending" @selected($reservation->status === 'pending')>Pending</option>
                            <option value="confirmed" @selected($reservation->status === 'confirmed')>Confirmed</option>
                            <option value="completed" @selected($reservation->status === 'completed')>Completed</option>
                            <option value="cancelled" @selected($reservation->status === 'cancelled')>Cancelled</option>
                        </select>

                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded font-bold transition">
                            Update Status
                        </button>
                    </form>
                </div>

                <!-- Reservation Metadata -->
                <div class="border-t pt-6">
                    <p class="text-sm text-gray-600">
                        Dibuat: {{ $reservation->created_at->format('d-m-Y H:i') }}
                    </p>
                    <p class="text-sm text-gray-600">
                        Diupdate: {{ $reservation->updated_at->format('d-m-Y H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
