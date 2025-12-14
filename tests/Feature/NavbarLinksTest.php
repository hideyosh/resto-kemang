<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavbarLinksTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_sees_my_orders_and_reservations_links()
    {
        $user = User::factory()->create(['role' => 'customer']);

        $this->actingAs($user)
            ->get('/')
            ->assertStatus(200)
            ->assertSee('My Orders')
            ->assertSee('My Reservations');
    }

    public function test_guest_does_not_see_profile_links()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertDontSee('My Orders')
            ->assertDontSee('My Reservations');
    }
}
