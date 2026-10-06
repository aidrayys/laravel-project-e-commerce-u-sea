<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Tampilkan halaman beranda dengan produk unggulan.
     */
    public function home(): View
    {
        $products = Product::limit(6)->get();

        return view('home', compact('products'));
    }

    /**
     * Tampilkan daftar produk dengan pencarian dan filter kategori.
     */
    public function index(Request $request): View
    {
        $query = Product::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('seller_name', 'like', "%{$search}%");
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
        if ($product->stock < 1) {
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
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
                'seller_name' => $product->seller_name,
            ];
        }

        // Pastikan jumlah tidak melebihi stok yang tersedia.
        if ($cart[$product->id]['quantity'] > $product->stock) {
            $cart[$product->id]['quantity'] = $product->stock;
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', "{$product->name} berhasil ditambahkan ke keranjang.");
    }

    /**
     * Tampilkan halaman keranjang belanja.
     */
    public function cart(Request $request): View
    {
        $cart = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $items = [];
        $total = 0;

        foreach ($cart as $id => $cartItem) {
            $product = $products->get($id);

            if (! $product) {
                continue;
            }

            $items[] = [
                'product' => $product,
                'quantity' => $cartItem['quantity'],
                'subtotal' => $product->price * $cartItem['quantity'],
            ];

            $total += $product->price * $cartItem['quantity'];
        }

        return view('cart', compact('items', 'total'));
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

        if ($quantity < 1) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id]['quantity'] = min($quantity, $product->stock);
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
