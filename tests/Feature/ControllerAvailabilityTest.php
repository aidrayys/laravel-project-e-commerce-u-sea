<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ControllerAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\ProductSeeder::class);
    }

    public function test_page_controller_home(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200)
                 ->assertViewIs('home');
    }

    public function test_page_controller_about(): void
    {
        $response = $this->get('/about');
        $response->assertStatus(200)
                 ->assertViewIs('about');
    }

    public function test_product_controller_index(): void
    {
        $response = $this->get('/products');
        $response->assertStatus(200)
                 ->assertViewIs('products.index');
    }

    public function test_product_controller_show(): void
    {
        $product = \App\Models\Product::first();
        $response = $this->get("/products/{$product->id}");
        $response->assertStatus(200)
                 ->assertViewIs('products.show');
    }

    public function test_seller_login_and_dashboard(): void
    {
        $this->get('/seller/login')->assertStatus(200)->assertViewIs('seller.login');

        $this->post('/seller/login', ['username' => 'wrong', 'password' => 'wrong'])
            ->assertRedirect();

        $this->post('/seller/login', ['username' => 'pesisirrasa', 'password' => '123'])
            ->assertRedirect('/seller/dashboard');

        $this->get('/seller/dashboard')->assertStatus(200)->assertViewIs('seller.dashboard');

        $this->post('/seller/logout')->assertRedirect('/');
    }

    public function test_seller_product_controller_routes(): void
    {
        $this->post('/seller/login', ['username' => 'pesisirrasa', 'password' => '123'])
            ->assertRedirect('/seller/dashboard');

        $this->get('/seller/products')->assertStatus(200)->assertViewIs('seller.products.index');
        $this->get('/seller/products/create')->assertStatus(200)->assertViewIs('seller.products.create');

        $product = \App\Models\Product::first();
        $this->get("/seller/products/{$product->id}/edit")
            ->assertStatus(200)
            ->assertViewIs('seller.products.edit');
    }

    public function test_seller_can_create_product_without_promo(): void
    {
        $this->post('/seller/login', ['username' => 'pesisirrasa', 'password' => '123'])
            ->assertRedirect('/seller/dashboard');

        $response = $this->post('/seller/products', [
            'name' => 'Test Seafood',
            'description' => 'Fresh test seafood from Lamongan.',
            'price' => 100000,
            'stock' => 25,
            'category' => 'Fish',
            'is_promo' => false,
        ]);

        $response->assertRedirect('/seller/products');

        $this->assertDatabaseHas('products', [
            'name' => 'Test Seafood',
            'price' => 100000,
            'original_price' => null,
            'discount_percentage' => null,
            'is_promo' => false,
            'seller_name' => 'Pesisir Rasa',
            'location' => 'Lamongan',
            'category' => 'Fish',
        ]);
    }

    public function test_seller_can_create_product_with_promo(): void
    {
        $this->post('/seller/login', ['username' => 'pesisirrasa', 'password' => '123'])
            ->assertRedirect('/seller/dashboard');

        $response = $this->post('/seller/products', [
            'name' => 'Promo Seafood',
            'description' => 'Promo test seafood.',
            'price' => 100000,
            'stock' => 10,
            'category' => 'Others',
            'category_other' => 'Special Seafood',
            'is_promo' => true,
            'discount_percentage' => 15,
        ]);

        $response->assertRedirect('/seller/products');

        $this->assertDatabaseHas('products', [
            'name' => 'Promo Seafood',
            'price' => 85000,
            'original_price' => 100000,
            'discount_percentage' => 15,
            'is_promo' => true,
            'category' => 'Special Seafood',
            'seller_name' => 'Pesisir Rasa',
            'location' => 'Lamongan',
        ]);
    }
}
