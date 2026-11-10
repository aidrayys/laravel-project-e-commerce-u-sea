<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Pengujian login Seller Center: kredensial dari config (.env),
 * verifikasi hash, dan regenerasi session.
 */
class SellerAuthTest extends TestCase
{
    public function test_seller_can_login_with_configured_credentials(): void
    {
        $this->post('/seller/login', ['username' => self::SELLER_USERNAME, 'password' => self::SELLER_PASSWORD])
            ->assertRedirect('/seller/dashboard');

        $this->assertTrue(session('seller_logged_in'));
    }

    public function test_wrong_password_is_rejected(): void
    {
        $this->from('/seller/login')
            ->post('/seller/login', ['username' => self::SELLER_USERNAME, 'password' => 'salah'])
            ->assertRedirect('/seller/login')
            ->assertSessionHas('error');

        $this->assertNull(session('seller_logged_in'));
    }

    public function test_login_is_rejected_when_credentials_not_configured(): void
    {
        config(['seller.username' => null, 'seller.password_hash' => null]);

        $this->post('/seller/login', ['username' => '', 'password' => ''])
            ->assertSessionHasErrors(['username', 'password']);

        $this->post('/seller/login', ['username' => 'x', 'password' => 'y'])
            ->assertSessionHas('error');
        $this->assertNull(session('seller_logged_in'));
    }

    public function test_session_id_is_regenerated_after_login(): void
    {
        $this->get('/seller/login');
        $before = session()->getId();

        $this->post('/seller/login', ['username' => self::SELLER_USERNAME, 'password' => self::SELLER_PASSWORD]);

        $this->assertNotSame($before, session()->getId());
    }

    public function test_logout_removes_seller_access(): void
    {
        $this->post('/seller/login', ['username' => self::SELLER_USERNAME, 'password' => self::SELLER_PASSWORD]);
        $this->post('/seller/logout')->assertRedirect('/');

        $this->get('/seller/dashboard')->assertRedirect('/seller/login');
    }
}
