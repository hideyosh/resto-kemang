<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // ============================================
    // Tampilkan semua order (untuk API)
    // ============================================
    public function index()
    {
        // Ambil semua order, urutkan dari terbaru
        $orders = Order::latest()->paginate(15);
        return response()->json($orders);
    }

    // ============================================
    // Tampilkan order milik user yang sedang login
    // ============================================
    public function userIndex()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(15);
        return view('order.index', compact('orders'));
    }

    // ============================================
    // Buat order baru
    // ============================================
    public function store(Request $request)
    {
        // Gunakan try-catch untuk menangkap error
        try {
            // Validasi data yang dikirim dari frontend (user harus login)
            $validated = $request->validate([
                'items'            => 'required|array',
                'items.*.name'     => 'required|string',
                'items.*.price'    => 'required|integer|min:0',
                'items.*.quantity' => 'required|integer|min:1',
                'total_amount'     => 'required|integer|min:0',
                'notes'            => 'nullable|string',
            ]);

            // Buat order baru di database (gunakan relasi user)
            $order = Order::create([
                'items'          => json_encode($validated['items']),
                'total_price'    => $validated['total_amount'],
                'notes'          => $validated['notes'] ?? null,
                'status'         => 'pending',
                'payment_status' => 'unpaid',
                'user_id'        => auth()->id(),
            ]);

            // Loop setiap item untuk membuat order_items
            foreach ($validated['items'] as $item) {
                // Cari menu item berdasarkan nama
                $menuItem = MenuItem::where('name', $item['name'])->first();

                // Jika menu item ditemukan, buat order item
                if ($menuItem) {
                    $order->orderItems()->create([
                        'menu_item_id' => $menuItem->id,
                        'quantity'     => $item['quantity'],
                        'price'        => $item['price'],
                    ]);
                }
            }

            // Return response sukses dengan data order
            return response()->json([
                'message' => 'Order created successfully',
                'order'   => $order->load('orderItems.menuItem')
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangkap error validasi
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            // Tangkap error lainnya
            \Log::error('Order creation error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to create order',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // Tampilkan detail order berdasarkan ID
    // ============================================
    public function show($id)
    {
        // Cari order berdasarkan ID
        $order = Order::findOrFail($id);

        // Jika bukan admin, pastikan hanya pemilik yang dapat melihat
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            if ($order->user_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses untuk melihat order ini');
            }
        }

        return response()->json($order);
    }

    // ============================================
    // Tampilkan detail order milik user (user flow)
    // ============================================
    public function userShow($id)
    {
        $order = Order::find($id);
        if (!$order) {
            abort(404);
        }
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat order ini');
        }
        return view('order.show', compact('order'));
    }

    // ============================================
    // Update order (untuk admin)
    // ============================================
    public function update(Request $request, $id)
    {
        // Cari order berdasarkan ID
        $order = Order::findOrFail($id);

        // Validasi data yang dikirim
        $validated = $request->validate([
            'status'         => 'sometimes|string|in:pending,processing,completed,cancelled',
            'payment_status' => 'sometimes|string|in:unpaid,paid,refunded',
            'notes'          => 'nullable|string',
        ]);

        // Update order dengan data yang sudah divalidasi
        $order->update($validated);

        return response()->json([
            'message' => 'Order updated successfully',
            'order'   => $order
        ]);
    }
}
