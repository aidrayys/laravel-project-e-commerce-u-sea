<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Tampilkan daftar produk dengan pencarian dan filter kategori.
     */
    public function index(Request $request): View
    {
        $query = Product::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('seller_name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        $products = $query->get();
        $categories = Product::select('category')->distinct()->pluck('category');

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Tampilkan detail produk.
     */
    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }

    /**
     * Tambahkan produk ke keranjang (session).
     */
    public function addToCart(Request $request, Product $product): RedirectResponse
    {
        $variantId = $request->input('variant_id');
        $variant = $variantId ? ProductVariant::find($variantId) : null;

        $price = $variant ? $variant->price : $product->price;
        $originalPrice = $variant ? $variant->original_price : $product->original_price;
        $discountPercentage = $variant ? $variant->discount_percentage : $product->discount_percentage;
        $stock = $variant ? $variant->stock : $product->stock;
        $weight = $variant ? $variant->weight : null;

        if ($stock < 1) {
            return redirect()->back()->with('error', "{$product->name} sedang tidak tersedia.");
        }

        $cart = session()->get('cart', []);
        $quantity = (int) $request->input('quantity', 1);

        if ($quantity < 1) {
            $quantity = 1;
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $price,
                'original_price' => $originalPrice,
                'discount_percentage' => $discountPercentage,
                'quantity' => $quantity,
                'image' => $product->image,
                'seller_name' => $product->seller_name,
                'location' => $product->location,
                'weight' => $weight,
                'variant_id' => $variant?->id,
            ];
        }

        // Pastikan jumlah tidak melebihi stok yang tersedia.
        if ($cart[$product->id]['quantity'] > $stock) {
            $cart[$product->id]['quantity'] = $stock;
        }

        session()->put('cart', $cart);

        $message = "{$product->name} berhasil ditambahkan ke keranjang.";

        if ($request->input('redirect') === 'checkout') {
            return redirect()->route('checkout.index')->with('success', $message);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Tampilkan halaman keranjang belanja.
     */
    public function cart(Request $request): View
    {
        $cart = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $items = [];
        $subtotal = 0;
        $discountTotal = 0;

        foreach ($cart as $id => $cartItem) {
            $product = $products->get($id);

            if (! $product) {
                continue;
            }

            $itemSubtotal = $cartItem['price'] * $cartItem['quantity'];
            $itemOriginalSubtotal = ($cartItem['original_price'] ?? $cartItem['price']) * $cartItem['quantity'];

            $items[] = [
                'product' => $product,
                'quantity' => $cartItem['quantity'],
                'price' => $cartItem['price'],
                'original_price' => $cartItem['original_price'] ?? null,
                'discount_percentage' => $cartItem['discount_percentage'] ?? null,
                'weight' => $cartItem['weight'] ?? null,
                'subtotal' => $itemSubtotal,
                'saved' => $itemOriginalSubtotal - $itemSubtotal,
            ];

            $subtotal += $itemSubtotal;
            $discountTotal += max(0, $itemOriginalSubtotal - $itemSubtotal);
        }

        $shipping = $subtotal >= 100000 ? 0 : 10000;
        $total = $subtotal + $shipping;

        return view('cart', compact('items', 'subtotal', 'discountTotal', 'shipping', 'total'));
    }

    /**
     * Perbarui jumlah produk di keranjang.
     */
    public function updateCart(Request $request, Product $product): RedirectResponse
    {
        $cart = session()->get('cart', []);
        $quantity = (int) $request->input('quantity', 1);

        if (! isset($cart[$product->id])) {
            return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan di keranjang.');
        }

        $variantId = $cart[$product->id]['variant_id'] ?? null;
        $stock = $variantId
            ? ProductVariant::where('id', $variantId)->value('stock')
            : $product->stock;

        if ($quantity < 1) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id]['quantity'] = min($quantity, $stock);
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui.');
    }

    /**
     * Hapus produk dari keranjang.
     */
    public function removeFromCart(Product $product): RedirectResponse
    {
        $cart = session()->get('cart', []);

        unset($cart[$product->id]);

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
