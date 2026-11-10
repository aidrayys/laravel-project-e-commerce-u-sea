<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    /** Kredensial penjual khusus pengujian (bukan akun demo asli). */
    protected const SELLER_USERNAME = 'test-seller';

    protected const SELLER_PASSWORD = 'test-secret';

    protected function setUp(): void
    {
        parent::setUp();

        // Tes tidak bergantung pada nilai .env lokal.
        config([
            'seller.username' => self::SELLER_USERNAME,
            'seller.password_hash' => Hash::make(self::SELLER_PASSWORD),
        ]);
    }
}
