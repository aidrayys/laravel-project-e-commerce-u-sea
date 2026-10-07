<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketplaceFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\ProductSeeder::class);
    }

    public function test_home_page_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200)
                 ->assertSee('Belanja dari Laut')
                 ->assertSee('Fresh From The Sea');
    }

    public function test_products_page_loads_and_filters(): void
    {
        $response = $this->get('/products');
        $response->assertStatus(200)
                 ->assertSee('Fresh Tuna');

        $response = $this->get('/products?category=Fresh+Seafood');
        $response->assertStatus(200)
                 ->assertSee('Fresh Tuna')
                 ->assertDontSee('Fish Floss');
    }

    public function test_product_detail_page_loads(): void
    {
        $product = \App\Models\Product::first();
        $response = $this->get("/products/{$product->id}");
        $response->assertStatus(200)
                 ->assertSee($product->name);
    }

    public function test_add_to_cart_with_variant(): void
    {
        $product = \App\Models\Product::where('name', 'Fresh Tuna')->first();
        $variant = $product->variants()->first();

        $response = $this->post("/cart/add/{$product->id}", [
            'variant_id' => $variant->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('product_variants', [
            'id' => $variant->id,
        ]);
    }

    public function test_cart_page_loads(): void
    {
        $product = \App\Models\Product::first();
        $this->post("/cart/add/{$product->id}", ['quantity' => 1]);

        $response = $this->get('/cart');
        $response->assertStatus(200)
                 ->assertSee('Shopping Cart');
    }

    public function test_checkout_page_requires_cart(): void
    {
        $response = $this->get('/checkout');
        $response->assertRedirect('/cart');
    }

    public function test_order_can_be_placed(): void
    {
        $product = \App\Models\Product::first();
        $this->post("/cart/add/{$product->id}", ['quantity' => 1]);

        $response = $this->post('/checkout', [
            'customer_name' => 'Test User',
            'customer_phone' => '08123456789',
            'address' => 'Test Address',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Test User',
        ]);
    }
}
