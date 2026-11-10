<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pengujian keamanan keranjang & checkout:
 * - variant_id harus milik produk yang dipilih
 * - harga selalu diambil dari database, bukan session
 * - stok divalidasi sehingga tidak terjadi overselling
 */
class CartCheckoutSecurityTest extends TestCase
{
    use RefreshDatabase;

    private const CHECKOUT_DATA = [
        'customer_name' => 'Budi',
        'customer_email' => 'budi@example.com',
        'customer_phone' => '08123456789',
        'address' => 'Jl. Pantai No. 1',
    ];

    private function makeProduct(array $attributes = []): Product
    {
        return Product::create(array_merge([
            'name' => 'Produk Uji',
            'description' => 'Deskripsi',
            'price' => 50000,
            'stock' => 10,
            'category' => 'Fresh Seafood',
            'image' => 'images/products/fresh-tuna.jpg',
            'seller_name' => 'Nelayan Uji',
            'location' => 'Madura',
        ], $attributes));
    }

    private function makeVariant(Product $product, int $price, int $stock = 10): ProductVariant
    {
        return ProductVariant::create([
            'product_id' => $product->id,
            'weight' => '500g',
            'price' => $price,
            'stock' => $stock,
        ]);
    }

    private function loginCustomer(): User
    {
        $user = User::factory()->create(['role' => 'customer']);
        $this->actingAs($user);

        return $user;
    }

    public function test_variant_from_another_product_is_rejected(): void
    {
        $expensive = $this->makeProduct(['name' => 'Lobster', 'price' => 500000]);
        $cheap = $this->makeProduct(['name' => 'Teri']);
        $cheapVariant = $this->makeVariant($cheap, 1000);

        $this->from("/products/{$expensive->id}")
            ->post("/cart/add/{$expensive->id}", ['variant_id' => $cheapVariant->id, 'quantity' => 1])
            ->assertRedirect("/products/{$expensive->id}")
            ->assertSessionHas('error', 'Varian produk tidak valid.');

        $this->assertArrayNotHasKey($expensive->id, session('cart', []));
    }

    public function test_nonexistent_variant_is_rejected(): void
    {
        $product = $this->makeProduct();

        $this->post("/cart/add/{$product->id}", ['variant_id' => 999999])
            ->assertSessionHas('error', 'Varian produk tidak valid.');
    }

    public function test_valid_variant_uses_variant_price(): void
    {
        $product = $this->makeProduct();
        $variant = $this->makeVariant($product, 30000);

        $this->post("/cart/add/{$product->id}", ['variant_id' => $variant->id, 'quantity' => 2])
            ->assertSessionHas('success');

        $this->assertSame($variant->id, session("cart.{$product->id}.variant_id"));
        $this->assertSame(30000, session("cart.{$product->id}.price"));
    }

    public function test_invalid_quantity_is_rejected(): void
    {
        $product = $this->makeProduct();

        $this->post("/cart/add/{$product->id}", ['quantity' => 'abc'])
            ->assertSessionHasErrors('quantity');
    }

    public function test_checkout_uses_database_price_not_session_price(): void
    {
        $user = $this->loginCustomer();
        $product = $this->makeProduct(['price' => 50000]);

        // Simulasikan session yang dimanipulasi: harga diubah jadi Rp1.
        $this->withSession(['cart' => [
            $product->id => ['name' => $product->name, 'price' => 1, 'quantity' => 2, 'variant_id' => null],
        ]])->post('/checkout', self::CHECKOUT_DATA)->assertRedirect();

        $order = Order::where('user_id', $user->id)->firstOrFail();
        $this->assertSame(100000, $order->subtotal);
        $this->assertSame(0, $order->shipping); // >= Rp100.000 gratis ongkir
        $this->assertSame(100000, $order->total);
        $this->assertDatabaseHas('order_items', ['order_id' => $order->id, 'price' => 50000, 'subtotal' => 100000]);
    }

    public function test_cart_page_shows_current_database_price(): void
    {
        $product = $this->makeProduct(['price' => 50000]);
        $this->post("/cart/add/{$product->id}", ['quantity' => 1]);

        $product->update(['price' => 65000]);

        $this->get('/cart')->assertOk()->assertSee('65.000');
    }

    public function test_checkout_fails_when_stock_insufficient_and_nothing_is_saved(): void
    {
        $this->loginCustomer();
        $product = $this->makeProduct(['stock' => 5]);
        $this->post("/cart/add/{$product->id}", ['quantity' => 5]);

        // Stok berkurang setelah barang masuk keranjang (dibeli orang lain).
        $product->update(['stock' => 2]);

        $this->post('/checkout', self::CHECKOUT_DATA)
            ->assertRedirect('/cart')
            ->assertSessionHas('error');

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_items', 0);
        $this->assertSame(2, $product->fresh()->stock);
        $this->assertNotEmpty(session('cart'));
    }

    public function test_checkout_decrements_variant_stock_only(): void
    {
        $this->loginCustomer();
        $product = $this->makeProduct(['stock' => 10]);
        $variant = $this->makeVariant($product, 40000, 4);

        $this->post("/cart/add/{$product->id}", ['variant_id' => $variant->id, 'quantity' => 3]);
        $this->post('/checkout', self::CHECKOUT_DATA)->assertRedirect();

        $this->assertSame(1, $variant->fresh()->stock);
        $this->assertSame(10, $product->fresh()->stock);
        $this->assertNull(session('cart'));
    }

    public function test_second_checkout_cannot_oversell_last_stock(): void
    {
        $product = $this->makeProduct(['stock' => 1]);
        $cart = ['cart' => [$product->id => ['price' => 50000, 'quantity' => 1, 'variant_id' => null]]];

        $this->actingAs(User::factory()->create())->withSession($cart)
            ->post('/checkout', self::CHECKOUT_DATA)->assertRedirect();

        $this->actingAs(User::factory()->create())->withSession($cart)
            ->post('/checkout', self::CHECKOUT_DATA)
            ->assertRedirect('/cart')
            ->assertSessionHas('error');

        $this->assertDatabaseCount('orders', 1);
        $this->assertSame(0, $product->fresh()->stock);
    }

    public function test_tampered_variant_in_session_is_rejected_at_checkout(): void
    {
        $this->loginCustomer();
        $product = $this->makeProduct();
        $otherVariant = $this->makeVariant($this->makeProduct(['name' => 'Lain']), 1000);

        $this->withSession(['cart' => [
            $product->id => ['price' => 1000, 'quantity' => 1, 'variant_id' => $otherVariant->id],
        ]])->post('/checkout', self::CHECKOUT_DATA)
            ->assertRedirect('/cart')
            ->assertSessionHas('error');

        $this->assertDatabaseCount('orders', 0);
    }
}
