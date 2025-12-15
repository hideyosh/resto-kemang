<?php

namespace App\Http\Controllers;

use App\Models\TableReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    // ============================================
    // Tampilkan semua reservasi (ADMIN / API)
    // ============================================
    public function index()
    {
        $reservations = TableReservation::latest()->paginate(15);
        return response()->json($reservations);
    }

    // ============================================
    // Tampilkan reservasi milik user yang login
    // ============================================
    public function userIndex()
    {
        $reservations = TableReservation::where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('reservation.index', compact('reservations'));
    }

    // ============================================
    // Buat reservasi baru (USER)
    // ============================================
    public function store(Request $request)
    {
        try {
            // ===============================
            // Validasi request
            // ===============================
            $validated = $request->validate([
                'number_of_guests' => 'required|integer|min:1|max:20',
                'reservation_date' => 'required|date_format:Y-m-d\TH:i',
                'notes'            => 'nullable|string',
            ]);

            // ===============================
            // BLOCK DUPLICATE RESERVATION
            // ===============================
            // User hanya boleh punya 1 reservasi pending
            $existingReservation = TableReservation::where('user_id', auth()->id())
                ->where('status', 'pending')
                ->first();

            if ($existingReservation) {
                return response()->json([
                    'message'     => 'You already have a pending reservation',
                    'reservation' => $existingReservation,
                ], 409);
            }

            // ===============================
            // Konversi datetime
            // ===============================
            $datetime = str_replace('T', ' ', $validated['reservation_date']);

            // ===============================
            // Simpan reservasi
            // ===============================
            $reservation = TableReservation::create([
                'number_of_guests' => $validated['number_of_guests'],
                'reservation_date' => $datetime,
                'notes'            => $validated['notes'] ?? null,
                'status'           => 'pending',
                'user_id'          => auth()->id(),
            ]);

            return response()->json([
                'message'     => 'Reservation created successfully',
                'reservation' => $reservation,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('Reservation creation error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to create reservation',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // ============================================
    // Tampilkan detail reservasi (ADMIN / API)
    // ============================================
    public function show($id)
    {
        $reservation = TableReservation::findOrFail($id);

        // Jika bukan admin, hanya owner yang boleh lihat
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            if ($reservation->user_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses untuk melihat reservasi ini');
            }
        }

        return response()->json($reservation);
    }

    // ============================================
    // Detail reservasi (USER VIEW)
    // ============================================
    public function userShow($id)
    {
        $reservation = TableReservation::findOrFail($id);

        if ($reservation->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat reservasi ini');
        }

        return view('reservation.show', compact('reservation'));
    }

    // ============================================
    // Update reservasi (ADMIN)
    // ============================================
    public function update(Request $request, $id)
    {
        $reservation = TableReservation::findOrFail($id);

        $validated = $request->validate([
            'status'           => 'sometimes|in:pending,confirmed,cancelled,completed',
            'number_of_guests' => 'sometimes|integer|min:1|max:20',
            'reservation_date' => 'sometimes|date_format:Y-m-d H:i:s',
            'notes'            => 'nullable|string',
        ]);

        $reservation->update($validated);

        return response()->json([
            'message'     => 'Reservation updated successfully',
            'reservation' => $reservation,
        ]);
    }

    // ============================================
    // Hapus reservasi (ADMIN)
    // ============================================
    public function destroy($id)
    {
        $reservation = TableReservation::findOrFail($id);
        $reservation->delete();

        return response()->json([
            'message' => 'Reservation deleted successfully',
        ]);
    }
}
