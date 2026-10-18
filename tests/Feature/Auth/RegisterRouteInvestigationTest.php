<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterRouteInvestigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_as_guest_returns_form(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    public function test_register_as_authenticated_renders_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }
}
