<?php

namespace App\Http\Controllers;

use App\Models\TableReservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // ============================================
    // Tampilkan semua reservasi (untuk API)
    // ============================================
    public function index()
    {
        // Ambil semua reservasi, urutkan dari terbaru
        $reservations = TableReservation::latest()->paginate(15);
        return response()->json($reservations);
    }

    // ============================================
    // Tampilkan reservasi milik user yang sedang login
    // ============================================
    public function userIndex()
    {
        $reservations = TableReservation::where('user_id', auth()->id())->latest()->paginate(15);
        return view('reservation.index', compact('reservations'));
    }

    // ============================================
    // Buat reservasi baru
    // ============================================
    public function store(Request $request)
    {
        // Validasi data yang dikirim dari frontend (user harus login)
        $validated = $request->validate([
            'number_of_guests'   => 'required|integer|min:1|max:20',
            'reservation_date'   => 'required|date_format:Y-m-d\TH:i',
            'notes'              => 'nullable|string',
        ]);

        // Konversi format datetime dari "Y-m-dTH:i" ke "Y-m-d H:i"
        $datetime = str_replace('T', ' ', $validated['reservation_date']);

        // Buat reservasi baru di database (gunakan relasi user)
        $reservation = TableReservation::create([
            'number_of_guests'   => $validated['number_of_guests'],
            'reservation_date'   => $datetime,
            'notes'              => $validated['notes'] ?? null,
            'status'             => 'pending',
            'user_id'            => auth()->id(),
        ]);

        // Return response sukses
        return response()->json([
            'message'     => 'Reservation created successfully',
            'reservation' => $reservation
        ], 201);
    }

    // ============================================
    // Tampilkan detail reservasi berdasarkan ID
    // ============================================
    public function show($id)
    {
        // Cari reservasi berdasarkan ID
        $reservation = TableReservation::findOrFail($id);

        // Jika bukan admin, pastikan hanya pemilik yang dapat melihat
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            if ($reservation->user_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses untuk melihat reservasi ini');
            }
        }

        return response()->json($reservation);
    }

    // ============================================
    // Tampilkan detail reservasi milik user (user flow)
    // ============================================
    public function userShow($id)
    {
        $reservation = TableReservation::find($id);
        if (!$reservation) {
            abort(404);
        }
        if ($reservation->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat reservasi ini');
        }
        return view('reservation.show', compact('reservation'));
    }

    // ============================================
    // Update reservasi (untuk admin)
    // ============================================
    public function update(Request $request, $id)
    {
        // Cari reservasi berdasarkan ID
        $reservation = TableReservation::findOrFail($id);

        // Validasi data yang dikirim
        $validated = $request->validate([
            'status'            => 'sometimes|string|in:pending,confirmed,cancelled,completed',
            'number_of_guests'  => 'sometimes|integer|min:1|max:20',
            'reservation_date'  => 'sometimes|date_format:Y-m-d H:i:s',
            'notes'             => 'nullable|string',
        ]);

        // Update reservasi dengan data yang sudah divalidasi
        $reservation->update($validated);

        return response()->json([
            'message'     => 'Reservation updated successfully',
            'reservation' => $reservation
        ]);
    }

    // ============================================
    // Hapus reservasi
    // ============================================
    public function destroy($id)
    {
        // Cari reservasi berdasarkan ID
        $reservation = TableReservation::findOrFail($id);

        // Hapus reservasi dari database
        $reservation->delete();

        return response()->json([
            'message' => 'Reservation deleted successfully'
        ]);
    }
}

