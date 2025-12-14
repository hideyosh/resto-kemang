@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 text-black">
        <!-- Admin Navbar -->
        <nav class="bg-black text-white px-6 py-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">Kelola Order</h1>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded transition text-white font-bold">
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

            <!-- Orders Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden text-black">
                <table class="w-full text-black">
                    <thead class="bg-gray-200 text-black">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-bold text-black">No</th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-black">Customer</th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-black">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-black">Total</th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-black">Status</th>
                            <th class="px-6 py-3 text-center text-sm font-bold text-black">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-black">
                        @forelse ($orders as $order)
                            <tr class="border-b hover:bg-gray-50 text-black">
                                <td class="px-6 py-3 text-black">
                                    {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
                                </td>

                                <td class="px-6 py-3 text-black">
                                    <div class="font-medium text-black">
                                        {{ $order->user?->name ?? 'N/A' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $order->user?->email ?? 'N/A' }}
                                    </div>
                                </td>

                                <td class="px-6 py-3 text-black">
                                    {{ $order->user?->customer?->phone ?? '-' }}
                                </td>

                                <td class="px-6 py-3 font-bold text-black">
                                    Rp {{ number_format($order->total_price) }}
                                </td>

                                <td class="px-6 py-3 text-black">
                                    <span
                                        class="px-3 py-1 rounded text-white text-sm font-bold
                                    @if ($order->status === 'pending') bg-yellow-500
                                    @elseif($order->status === 'confirmed') bg-blue-500
                                    @elseif($order->status === 'completed') bg-green-500
                                    @else bg-red-500 @endif
                                ">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>

                                <td class="px-6 py-3 text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition font-bold">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-3 text-center text-black font-bold">
                                    Tidak ada order ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 text-black font-bold">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
