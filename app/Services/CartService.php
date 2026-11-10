<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Collection;

/**
 * Logika keranjang belanja yang dipakai bersama oleh halaman keranjang,
 * halaman checkout, dan proses pembuatan pesanan.
 *
 * Struktur data keranjang di session (array asosiatif, key = product_id):
 *   [product_id => ['quantity' => int, 'variant_id' => ?int, ...data tampilan]]
 *
 * PENTING: harga yang tersimpan di session hanya untuk tampilan cepat.
 * Semua perhitungan total selalu memakai harga terkini dari database.
 */
class CartService
{
    /** Batas minimum subtotal untuk mendapatkan gratis ongkir (Rupiah). */
    public const FREE_SHIPPING_MIN = 100000;

    /** Ongkos kirim standar jika subtotal di bawah batas gratis ongkir. */
    public const SHIPPING_COST = 10000;

    /**
     * Ambil data harga & stok terkini dari produk atau variannya.
     *
     * @return array{price:int, original_price:?int, discount_percentage:?int, stock:int, weight:?string}
     */
    public function pricing(Product $product, ?ProductVariant $variant = null): array
    {
        $source = $variant ?? $product;

        return [
            'price' => (int) $source->price,
            'original_price' => $source->original_price !== null ? (int) $source->original_price : null,
            'discount_percentage' => $source->discount_percentage !== null ? (int) $source->discount_percentage : null,
            'stock' => (int) $source->stock,
            'weight' => $variant?->weight,
        ];
    }

    /**
     * Cari varian yang benar-benar milik produk tersebut.
     * Mengembalikan null jika varian tidak ada atau milik produk lain.
     */
    public function findVariantFor(Product $product, mixed $variantId, bool $lock = false): ?ProductVariant
    {
        if (! $variantId) {
            return null;
        }

        $query = ProductVariant::where('id', $variantId)->where('product_id', $product->id);

        return ($lock ? $query->lockForUpdate() : $query)->first();
    }

    public function shippingFor(int $subtotal): int
    {
        return $subtotal >= self::FREE_SHIPPING_MIN ? 0 : self::SHIPPING_COST;
    }

    /**
     * Hitung ringkasan keranjang memakai harga terkini dari database.
     *
     * @param  array<int, array<string, mixed>>  $cart
     * @param  bool  $lock  Kunci baris produk/varian (dipakai di dalam transaksi checkout).
     * @return array{items: array<int, array<string, mixed>>, subtotal:int, discountTotal:int, shipping:int, total:int, invalid: array<int, string>}
     */
    public function summarize(array $cart, bool $lock = false): array
    {
        $query = Product::whereIn('id', array_keys($cart));
        /** @var Collection<int, Product> $products */
        $products = ($lock ? $query->lockForUpdate() : $query)->get()->keyBy('id');

        $items = [];
        $invalid = [];
        $subtotal = 0;
        $discountTotal = 0;

        foreach ($cart as $productId => $cartItem) {
            $product = $products->get($productId);

            if (! $product) {
                $invalid[$productId] = 'Produk tidak ditemukan.';

                continue;
            }

            $variant = null;
            if (! empty($cartItem['variant_id'])) {
                $variant = $this->findVariantFor($product, $cartItem['variant_id'], $lock);

                if (! $variant) {
                    $invalid[$productId] = "Varian {$product->name} tidak valid.";

                    continue;
                }
            }

            $pricing = $this->pricing($product, $variant);
            $quantity = (int) $cartItem['quantity'];
            $itemSubtotal = $pricing['price'] * $quantity;
            $saved = max(0, ($pricing['original_price'] ?? $pricing['price']) * $quantity - $itemSubtotal);

            $items[] = [
                'product' => $product,
                'variant' => $variant,
                'quantity' => $quantity,
                'price' => $pricing['price'],
                'original_price' => $pricing['original_price'],
                'discount_percentage' => $pricing['discount_percentage'],
                'weight' => $pricing['weight'],
                'stock' => $pricing['stock'],
                'subtotal' => $itemSubtotal,
                'saved' => $saved,
            ];

            $subtotal += $itemSubtotal;
            $discountTotal += $saved;
        }

        $shipping = $this->shippingFor($subtotal);

        return [
            'items' => $items,
            'subtotal' => $subtotal,
            'discountTotal' => $discountTotal,
            'shipping' => $shipping,
            'total' => $subtotal + $shipping,
            'invalid' => $invalid,
        ];
    }
}
