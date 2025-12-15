<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\TableReservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DuplicateSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_duplicate_order_submission_is_blocked()
    {
        $user = User::factory()->create(['role' => 'customer']);

        $payload = [
            'items' => [[
                'name' => 'Test Item',
                'price' => 100,
                'quantity' => 1,
            ]],
            'total_amount' => 100,
            'notes' => 'Please deliver',
        ];

        $this->actingAs($user)
            ->postJson('/api/orders', $payload)
            ->assertStatus(201)
            ->assertJson(['message' => 'Order created successfully']);

        // Immediate second submission should be rejected as duplicate
        $this->actingAs($user)
            ->postJson('/api/orders', $payload)
            ->assertStatus(409)
            ->assertJson(['message' => 'Duplicate order detected']);

        $this->assertDatabaseCount('orders', 1);
    }

    public function test_duplicate_reservation_submission_is_blocked()
    {
        $user = User::factory()->create(['role' => 'customer']);

        $payload = [
            'number_of_guests' => 2,
            'reservation_date' => now()->addDay()->format('Y-m-d\TH:i'),
            'notes' => 'Please near window',
        ];

        $this->actingAs($user)
            ->postJson('/api/reservations', $payload)
            ->assertStatus(201)
            ->assertJson(['message' => 'Reservation created successfully']);

        // Immediate second submission should be rejected
        $this->actingAs($user)
            ->postJson('/api/reservations', $payload)
            ->assertStatus(409)
            ->assertJson(['message' => 'You already have a pending reservation']);

        $this->assertDatabaseCount('table_reservations', 1);
    }
}
