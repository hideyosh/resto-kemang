<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
	// ============================================
	// Tampilkan semua order (untuk API)
	// ============================================
	public function index()
	{
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
		try {
			$validated = $request->validate([
				'items'            => 'required|array',
				'items.*.name'     => 'required|string',
				'items.*.price'    => 'required|integer|min:0',
				'items.*.quantity' => 'required|integer|min:1',
				'total_amount'     => 'required|integer|min:0',
				'notes'            => 'nullable|string',
			]);

			// Normalize a list of items for reliable comparison
			$normalize = function ($items) {
				$out = [];
				foreach ($items as $it) {
					$out[] = [
						'name'     => (string)($it['name'] ?? ''),
						'price'    => (int)($it['price'] ?? 0),
						'quantity' => (int)($it['quantity'] ?? 0),
					];
				}
				return $out;
			};

			$itemsJson = json_encode($validated['items']);

			// Find potential candidates by user and total to keep query cheap
			$potentialDuplicates = Order::where('user_id', auth()->id())
				->where('total_price', $validated['total_amount'])
				->get();

			$recentDuplicate = null;
			$normalizedPayload = $normalize($validated['items']);

			foreach ($potentialDuplicates as $existing) {
				$existingItemsRaw = $existing->items;
				$existingItems = is_string($existingItemsRaw) ? json_decode($existingItemsRaw, true) : $existingItemsRaw;
				$existingNormalized = $normalize($existingItems ?: []);

				// Use loose equality on normalized arrays to tolerate type differences
				if ($existingNormalized == $normalizedPayload) {
					$recentDuplicate = $existing;
					break;
				}
			}

			if ($recentDuplicate) {
				return response()->json([
					'message' => 'Duplicate order detected',
					'order' => $recentDuplicate
				], 409);
			}

			$order = Order::create([
				'items'          => $itemsJson,
				'total_price'    => $validated['total_amount'],
				'notes'          => $validated['notes'] ?? null,
				'status'         => 'pending',
				'payment_status' => 'unpaid',
				'user_id'        => auth()->id(),
			]);

			foreach ($validated['items'] as $item) {
				$menuItem = MenuItem::where('name', $item['name'])->first();
				if ($menuItem) {
					$order->orderItems()->create([
						'menu_item_id' => $menuItem->id,
						'quantity'     => $item['quantity'],
						'price'        => $item['price'],
					]);
				}
			}

			return response()->json([
				'message' => 'Order created successfully',
				'order'   => $order->load('orderItems.menuItem')
			], 201);

		} catch (\Illuminate\Validation\ValidationException $e) {
			return response()->json([
				'message' => 'Validation failed',
				'errors'  => $e->errors()
			], 422);

		} catch (\Exception $e) {
			Log::error('Order creation error: ' . $e->getMessage());
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
		$order = Order::findOrFail($id);

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
		$order = Order::findOrFail($id);

		$validated = $request->validate([
			'status'         => 'sometimes|string|in:pending,processing,completed,cancelled',
			'payment_status' => 'sometimes|string|in:unpaid,paid,refunded',
			'notes'          => 'nullable|string',
		]);

		$order->update($validated);

		return response()->json([
			'message' => 'Order updated successfully',
			'order'   => $order
		]);
	}
}
