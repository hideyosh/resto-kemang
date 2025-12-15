@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 text-black">
        <!-- Admin Navbar -->
        <nav class="bg-black text-white px-6 py-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">Detail Order</h1>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded transition">
                        Logout
                    </button>
                </form>
            </div>
        </nav>

        <div class="max-w-4xl mx-auto px-4 py-8">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800">
                    ← Kembali ke Daftar Order
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Order Information -->
            <div class="bg-white rounded-lg shadow p-8 mb-6 text-black">
                <h2 class="text-2xl font-bold mb-6 text-black">
                    Order #{{ $order->id }}
                </h2>

                <!-- Customer Info -->
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-gray-500 text-sm">User Account</p>
                        <p class="text-lg font-bold text-black">{{ $order->user?->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Email</p>
                        <p class="text-lg text-black">{{ $order->user?->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Phone</p>
                        <p class="text-lg text-black">{{ $order->user?->customer?->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Notes</p>
                        <p class="text-lg text-black">{{ $order->notes ?? '-' }}</p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-6">
                    <h3 class="text-lg font-bold mb-3 text-black">Item Order</h3>
                    <div class="bg-gray-50 rounded p-4">
                        @foreach ($order->orderItems as $item)
                            <div class="flex justify-between items-center mb-3 pb-3 border-b last:border-b-0">
                                <div>
                                    <p class="font-bold text-black">{{ $item->menuItem->name }}</p>
                                    <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                                </div>
                                <p class="font-bold text-black">
                                    Rp {{ number_format($item->price * $item->quantity) }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Total -->
                <div class="mb-6 p-4 bg-blue-50 rounded text-black">
                    <p class="text-gray-600 mb-2">Total Harga</p>
                    <p class="text-3xl font-bold text-black">
                        Rp {{ number_format($order->total_price) }}
                    </p>
                </div>

                <!-- Status Update -->
                <div class="mb-6">
                    <h3 class="text-lg font-bold mb-3 text-black">Ubah Status Order</h3>
                    <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}" class="flex gap-2">
                        @csrf
                        @method('PUT')
                        <select name="status"
                            class="flex-1 px-4 py-2 border-2 border-gray-300 rounded focus:outline-none focus:border-blue-500 text-black">
                            <option value="pending" @selected($order->status === 'pending')>Pending</option>
                            <option value="confirmed" @selected($order->status === 'confirmed')>Confirmed</option>
                            <option value="preparing" @selected($order->status === 'preparing')>Preparing</option>
                            <option value="ready" @selected($order->status === 'ready')>Ready</option>
                            <option value="completed" @selected($order->status === 'completed')>Completed</option>
                            <option value="cancelled" @selected($order->status === 'cancelled')>Cancelled</option>
                        </select>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded font-bold transition">
                            Update Status
                        </button>
                    </form>
                </div>

                <!-- Metadata -->
                <div class="border-t pt-6">
                    <p class="text-sm text-gray-500">
                        Dibuat: {{ $order->created_at->format('d-m-Y H:i') }}
                    </p>
                    <p class="text-sm text-gray-500">
                        Diupdate: {{ $order->updated_at->format('d-m-Y H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
