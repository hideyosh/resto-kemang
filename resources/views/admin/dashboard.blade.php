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
                                    class="flex items-center gap-2 px-4 py-2 rounded hover:bg-blue-500 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M3 3v18h18" />
                                        <path d="M9 17V9" />
                                        <path d="M13 17V5" />
                                        <path d="M17 17v-7" />
                                    </svg>
                                    Dashboard
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.users.index') }}"
                                    class="flex items-center gap-2 px-4 py-2 rounded hover:bg-blue-500 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M17 20h5v-2a4 4 0 00-4-4h-1" />
                                        <path d="M9 20H4v-2a4 4 0 014-4h1" />
                                        <circle cx="9" cy="7" r="4" />
                                        <circle cx="17" cy="7" r="4" />
                                    </svg>
                                    Kelola User
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.orders.index') }}"
                                    class="flex items-center gap-2 px-4 py-2 rounded hover:bg-blue-500 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <circle cx="9" cy="21" r="1" />
                                        <circle cx="20" cy="21" r="1" />
                                        <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6" />
                                    </svg>
                                    Kelola Order
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.reservations.index') }}"
                                    class="flex items-center gap-2 px-4 py-2 rounded hover:bg-blue-500 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <rect x="3" y="4" width="18" height="18" rx="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg>
                                    Kelola Reservasi
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.menu.index') }}"
                                    class="flex items-center gap-2 px-4 py-2 rounded hover:bg-blue-500 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M12 5v14" />
                                        <path d="M5 12h14" />
                                    </svg>
                                    Kelola Menu
                                </a>
                            </li>
                        </ul>

                    </div>
                </aside>

                <!-- Content -->
                <!-- Content -->
                <main class="md:col-span-3 text-black">

                    <!-- Dashboard Stats -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 mb-10">

                        <!-- Total Users -->
                        <div class="bg-white rounded-xl shadow p-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-gray-700 text-sm">Total Users</p>
                                    <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                                </div>
                                <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M17 20h5v-2a4 4 0 00-4-4h-1" />
                                    <path d="M9 20H4v-2a4 4 0 014-4h1" />
                                    <circle cx="9" cy="7" r="4" />
                                    <circle cx="17" cy="7" r="4" />
                                </svg>
                            </div>
                        </div>

                        <!-- Total Orders -->
                        <div class="bg-white rounded-xl shadow p-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-gray-700 text-sm">Total Orders</p>
                                    <p class="text-3xl font-bold">{{ $totalOrders }}</p>
                                </div>
                                <svg class="w-10 h-10 text-purple-500" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <circle cx="9" cy="21" r="1" />
                                    <circle cx="20" cy="21" r="1" />
                                    <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6" />
                                </svg>
                            </div>
                        </div>

                        <!-- Total Reservations -->
                        <div class="bg-white rounded-xl shadow p-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-gray-700 text-sm">Total Reservations</p>
                                    <p class="text-3xl font-bold">{{ $totalReservations }}</p>
                                </div>
                                <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                            </div>
                        </div>

                        <!-- Total Menu Items -->
                        <div class="bg-white rounded-xl shadow p-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-gray-700 text-sm">Total Menu Items</p>
                                    <p class="text-3xl font-bold">{{ $totalMenuItems }}</p>
                                </div>
                                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path
                                        d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" />
                                </svg>
                            </div>
                        </div>

                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-lg font-bold mb-4">Quick Actions</h2>

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
