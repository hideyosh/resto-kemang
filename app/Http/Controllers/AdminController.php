<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\TableReservation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ============================================
    // DASHBOARD - Halaman utama admin
    // ============================================
    public function dashboard()
    {
        // Hitung total user
        $totalUsers = User::where('role', 'customer')->count();

        // Hitung total order
        $totalOrders = Order::count();

        // Hitung total reservasi
        $totalReservations = TableReservation::count();

        // Hitung total menu items
        $totalMenuItems = MenuItem::count();

        // Ambil semua data untuk ditampilkan di dashboard
        return view('admin.dashboard', [
            'totalUsers'        => $totalUsers,
            'totalOrders'       => $totalOrders,
            'totalReservations' => $totalReservations,
            'totalMenuItems'    => $totalMenuItems,
        ]);
    }

    // ============================================
    // USER MANAGEMENT - Kelola akun user
    // ============================================

    // Tampilkan daftar semua user
    public function userIndex()
    {
        // Ambil semua user dengan role 'user'
        $users = User::where('role', 'customer')->paginate(10);

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    // Tampilkan form untuk membuat user baru
    public function userCreate()
    {
        return view('admin.users.create');
    }

    // Simpan user baru ke database
    public function userStore(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        // Buat user baru dengan role 'user'
        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role'     => 'user',
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    // Tampilkan form untuk edit user
    public function userEdit($id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    // Update data user
    public function userUpdate(Request $request, $id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Update nama dan email
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Update password jika diisi
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        // Simpan perubahan ke database
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate!');
    }

    // Hapus user
    public function userDestroy($id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Jangan biarkan admin menghapus user admin
        if ($user->role === 'admin') {
            return redirect()->back()
                ->with('error', 'Tidak boleh menghapus akun admin!');
        }

        // Hapus user dari database
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    // ============================================
    // ORDERS - Kelola order
    // ============================================

    // Tampilkan daftar semua order
    public function orderIndex()
    {
        // Ambil semua order dengan info user yang membuat order
        $orders = Order::with('user')->paginate(10);

        return view('admin.orders.index', [
            'orders' => $orders,
        ]);
    }

    // Tampilkan detail order
    public function orderShow($id)
    {
        // Cari order berdasarkan ID
        $order = Order::with(['user', 'orderItems', 'orderItems.menuItem'])->findOrFail($id);

        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }

    // Update status order
    public function orderUpdateStatus(Request $request, $id)
    {
        // Cari order berdasarkan ID
        $order = Order::findOrFail($id);

        // Validasi status
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,completed,cancelled',
        ]);

        // Update status order
        $order->status = $validated['status'];
        $order->save();

        return redirect()->back()
            ->with('success', 'Status order berhasil diupdate!');
    }

    // ============================================
    // RESERVATIONS - Kelola reservasi
    // ============================================

    // Tampilkan daftar semua reservasi
    public function reservationIndex()
    {
        // Ambil semua reservasi dengan info user yang membuat reservasi
        $reservations = TableReservation::with('user')->paginate(10);

        return view('admin.reservations.index', [
            'reservations' => $reservations,
        ]);
    }

    // Tampilkan detail reservasi
    public function reservationShow($id)
    {
        // Cari reservasi berdasarkan ID
        $reservation = TableReservation::with('user')->findOrFail($id);

        return view('admin.reservations.show', [
            'reservation' => $reservation,
        ]);
    }

    // Update status reservasi
    public function reservationUpdateStatus(Request $request, $id)
    {
        // Cari reservasi berdasarkan ID
        $reservation = TableReservation::findOrFail($id);

        // Validasi status
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        // Update status reservasi
        $reservation->status = $validated['status'];
        $reservation->save();

        return redirect()->back()
            ->with('success', 'Status reservasi berhasil diupdate!');
    }
}

