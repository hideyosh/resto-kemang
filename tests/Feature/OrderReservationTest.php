<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\TableReservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_own_order_but_not_others()
    {
        $user = User::factory()->create(['role' => 'customer']);
        $other = User::factory()->create(['role' => 'customer']);

        $order = Order::create(["items" => json_encode([[]]), 'total_price' => 100, 'user_id' => $user->id]);
        $otherOrder = Order::create(["items" => json_encode([[]]), 'total_price' => 200, 'user_id' => $other->id]);

        $this->actingAs($user)
            ->get('/orders')
            ->assertStatus(200)
            ->assertSee((string)$order->id)
            ->assertSee('Rp');

        $this->actingAs($user)
            ->get('/orders/'.$order->id)
            ->assertStatus(200)
            ->assertSee((string)$order->id);

        $this->actingAs($user)
            ->get('/orders/'.$otherOrder->id)
            ->assertStatus(403);
    }

    public function test_admin_can_view_any_order()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'customer']);
        $order = Order::create(["items" => json_encode([[]]), 'total_price' => 150, 'user_id' => $user->id]);

        $this->actingAs($admin)
            ->get('/admin/orders')
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get('/admin/orders/'.$order->id)
            ->assertStatus(200)
            ->assertSee((string)$order->id);
    }

    public function test_user_can_view_own_reservation_but_not_others()
    {
        $user = User::factory()->create(['role' => 'customer']);
        $other = User::factory()->create(['role' => 'customer']);

        $res = TableReservation::create(['number_of_guests' => 2, 'reservation_date' => now(), 'user_id' => $user->id]);
        $otherRes = TableReservation::create(['number_of_guests' => 4, 'reservation_date' => now(), 'user_id' => $other->id]);

        $this->actingAs($user)
            ->get('/reservations')
            ->assertStatus(200)
            ->assertSee((string)$res->id)
            ->assertSee('View');

        $this->actingAs($user)
            ->get('/reservations/'.$res->id)
            ->assertStatus(200)
            ->assertSee((string)$res->id);

        $this->actingAs($user)
            ->get('/reservations/'.$otherRes->id)
            ->assertStatus(403);
    }

    public function test_admin_can_view_any_reservation()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'customer']);
        $res = TableReservation::create(['number_of_guests' => 3, 'reservation_date' => now(), 'user_id' => $user->id]);

        $this->actingAs($admin)
            ->get('/admin/reservations')
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get('/admin/reservations/'.$res->id)
            ->assertStatus(200)
            ->assertSee((string)$res->id);
    }
}
