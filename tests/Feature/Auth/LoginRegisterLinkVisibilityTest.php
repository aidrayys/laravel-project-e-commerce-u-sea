<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginRegisterLinkVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_shows_register_link(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Belum punya akun?', false);
        $response->assertSee('Daftar', false);
        $response->assertSee(route('register'), false);
    }

    public function test_register_page_shows_login_link(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Sudah punya akun?', false);
        $response->assertSee('Login', false);
        $response->assertSee(route('login'), false);
    }
}
