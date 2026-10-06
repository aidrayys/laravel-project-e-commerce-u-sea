<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Tampilkan halaman checkout beserta ringkasan pesanan.
     */
    public function checkout(Request $request): View|RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong. Silakan tambahkan produk terlebih dahulu.');
        }

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

        return view('checkout', compact('items', 'total'));
    }

    /**
     * Simpan pesanan beserta item-itemnya ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        // Periksa ketersediaan stok sebelum membuat pesanan.
        foreach ($cart as $id => $cartItem) {
            $product = $products->get($id);

            if (! $product) {
                return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan.');
            }

            if ($product->stock < $cartItem['quantity']) {
                return redirect()->route('cart.index')->with(
                    'error',
                    "Stok {$product->name} tidak mencukupi. Stok tersedia: {$product->stock}."
                );
            }
        }

        $order = DB::transaction(function () use ($validated, $cart, $products) {
            $total = 0;

            foreach ($cart as $id => $cartItem) {
                $product = $products->get($id);
                $total += $product->price * $cartItem['quantity'];
            }

            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'address' => $validated['address'],
                'total' => $total,
                'status' => 'Pending',
            ]);

            foreach ($cart as $id => $cartItem) {
                $product = $products->get($id);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $cartItem['quantity'],
                    'subtotal' => $product->price * $cartItem['quantity'],
                ]);

                $product->decrement('stock', $cartItem['quantity']);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat.');
    }

    /**
     * Tampilkan halaman konfirmasi pesanan.
     */
    public function show(Order $order): View
    {
        $order->load('orderItems.product');

        return view('orders.show', compact('order'));
    }
}
