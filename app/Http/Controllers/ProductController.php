<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
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

        $products = $query->paginate(12)->withQueryString();
        $categories = Product::select('category')->distinct()->pluck('category');

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Tampilkan detail produk dan catat klik.
     * Setiap kunjungan halaman detail produk menambah jumlah klik sebanyak satu kali.
     */
    public function show(Product $product): View
    {
        $product->increment('click');

        // Keep legacy `clicks` column in sync when present.
        if (Schema::hasColumn($product->getTable(), 'clicks')) {
            $product->increment('clicks');
        }

        $product->refresh();

        return view('products.show', compact('product'));
    }

    /**
     * Tambahkan produk ke keranjang (session).
     */
    public function addToCart(Request $request, Product $product, CartService $cartService): RedirectResponse
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
            'variant_id' => 'nullable|integer',
        ]);

        $variantId = $request->input('variant_id');
        // Varian harus milik produk ini, mencegah manipulasi harga lewat variant_id produk lain.
        $variant = $cartService->findVariantFor($product, $variantId);

        if ($variantId && ! $variant) {
            return redirect()->back()->with('error', 'Varian produk tidak valid.');
        }

        $pricing = $cartService->pricing($product, $variant);
        $stock = $pricing['stock'];

        if ($stock < 1) {
            return redirect()->back()->with('error', "{$product->name} sedang tidak tersedia.");
        }

        $cart = session()->get('cart', []);
        $quantity = max(1, (int) $request->input('quantity', 1));

        // Jika varian berbeda dari yang sudah ada di keranjang, ganti item tersebut.
        if (isset($cart[$product->id]) && ($cart[$product->id]['variant_id'] ?? null) === $variant?->id) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $pricing['price'],
                'original_price' => $pricing['original_price'],
                'discount_percentage' => $pricing['discount_percentage'],
                'quantity' => $quantity,
                'image' => $product->image,
                'seller_name' => $product->seller_name,
                'location' => $product->location,
                'weight' => $pricing['weight'],
                'variant_id' => $variant?->id,
            ];
        }

        // Pastikan jumlah tidak melebihi stok yang tersedia.
        $cart[$product->id]['quantity'] = min($cart[$product->id]['quantity'], $stock);

        session()->put('cart', $cart);

        $message = "{$product->name} berhasil ditambahkan ke keranjang.";

        if ($request->input('redirect') === 'checkout') {
            return redirect()->route('checkout.index')->with('success', $message);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Tampilkan halaman keranjang belanja (harga dihitung ulang dari database).
     */
    public function cart(CartService $cartService): View
    {
        $summary = $cartService->summarize(session()->get('cart', []));
        unset($summary['invalid']);

        return view('cart', $summary);
    }

    /**
     * Perbarui jumlah produk di keranjang.
     */
    public function updateCart(Request $request, Product $product, CartService $cartService): RedirectResponse
    {
        $request->validate(['quantity' => 'required|integer|min:0']);

        $cart = session()->get('cart', []);
        $quantity = (int) $request->input('quantity');

        if (! isset($cart[$product->id])) {
            return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan di keranjang.');
        }

        $variant = $cartService->findVariantFor($product, $cart[$product->id]['variant_id'] ?? null);
        $stock = $cartService->pricing($product, $variant)['stock'];

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
