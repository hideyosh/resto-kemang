@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">

    <!-- Admin Navbar -->
    <nav class="bg-black text-white px-6 py-4 shadow">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-white">Admin Dashboard</h1>

            <div class="flex items-center gap-4">
                <span class="text-sm opacity-80 text-white">{{ Auth::user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded transition font-semibold text-white">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-10 text-black">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            <!-- Sidebar -->
            <aside class="md:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 text-black">
                    <h2 class="text-lg font-bold mb-4 text-black">Menu Navigasi</h2>

                    <ul class="space-y-2 text-sm font-semibold text-black">
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                               class="block px-4 py-2 rounded hover:bg-blue-500 hover:text-white transition text-black">
                                📊 Dashboard
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.users.index') }}"
                               class="block px-4 py-2 rounded hover:bg-blue-500 hover:text-white transition text-black">
                                👥 Kelola User
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.orders.index') }}"
                               class="block px-4 py-2 rounded hover:bg-blue-500 hover:text-white transition text-black">
                                🛒 Kelola Order
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.reservations.index') }}"
                               class="block px-4 py-2 rounded hover:bg-blue-500 hover:text-white transition text-black">
                                📅 Kelola Reservasi
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.menu.create') }}"
                               class="block px-4 py-2 rounded hover:bg-blue-500 hover:text-white transition text-black">
                                ➕ Tambah Menu
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Content -->
            <main class="md:col-span-3 text-black">

                <!-- Dashboard Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 mb-10">

                    <div class="bg-white rounded-xl shadow p-6 text-black">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-700 text-sm">Total Users</p>
                                <p class="text-3xl font-bold text-black">{{ $totalUsers }}</p>
                            </div>
                            <div class="text-4xl">👥</div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow p-6 text-black">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-700 text-sm">Total Orders</p>
                                <p class="text-3xl font-bold text-black">{{ $totalOrders }}</p>
                            </div>
                            <div class="text-4xl">🛒</div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow p-6 text-black">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-700 text-sm">Total Reservations</p>
                                <p class="text-3xl font-bold text-black">{{ $totalReservations }}</p>
                            </div>
                            <div class="text-4xl">📅</div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow p-6 text-black">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-700 text-sm">Total Menu Items</p>
                                <p class="text-3xl font-bold text-black">{{ $totalMenuItems }}</p>
                            </div>
                            <div class="text-4xl">🍱</div>
                        </div>
                    </div>

                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow p-6 text-black">
                    <h2 class="text-lg font-bold mb-4 text-black">Quick Actions</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <a href="{{ route('admin.users.create') }}"
                           class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded font-bold transition text-center">
                            Tambah User Baru
                        </a>

                        <a href="{{ route('admin.menu.create') }}"
                           class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded font-bold transition text-center">
                            Tambah Menu Item
                        </a>

                        <a href="{{ route('admin.orders.index') }}"
                           class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded font-bold transition text-center">
                            Lihat Semua Order
                        </a>

                        <a href="{{ route('admin.reservations.index') }}"
                           class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded font-bold transition text-center">
                            Lihat Semua Reservasi
                        </a>

                    </div>
                </div>

            </main>

        </div>
    </div>
</div>
@endsection
