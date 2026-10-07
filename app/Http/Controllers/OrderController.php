<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
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
                'saved' => max(0, $itemOriginalSubtotal - $itemSubtotal),
            ];

            $subtotal += $itemSubtotal;
            $discountTotal += max(0, $itemOriginalSubtotal - $itemSubtotal);
        }

        $shipping = $subtotal >= 100000 ? 0 : 10000;
        $total = $subtotal + $shipping;

        return view('checkout', compact('items', 'subtotal', 'discountTotal', 'shipping', 'total'));
    }

    /**
     * Simpan pesanan beserta item-itemnya ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
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

            $stock = $cartItem['variant_id']
                ? ProductVariant::where('id', $cartItem['variant_id'])->value('stock')
                : $product->stock;

            if ($stock < $cartItem['quantity']) {
                return redirect()->route('cart.index')->with(
                    'error',
                    "Stok {$product->name} tidak mencukupi. Stok tersedia: {$stock}."
                );
            }
        }

        $order = DB::transaction(function () use ($validated, $cart, $products) {
            $subtotal = 0;

            foreach ($cart as $id => $cartItem) {
                $subtotal += $cartItem['price'] * $cartItem['quantity'];
            }

            $shipping = $subtotal >= 100000 ? 0 : 10000;
            $total = $subtotal + $shipping;

            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'address' => $validated['address'],
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'discount_total' => 0,
                'total' => $total,
                'status' => 'Pending',
            ]);

            foreach ($cart as $id => $cartItem) {
                $product = $products->get($id);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_variant_id' => $cartItem['variant_id'] ?? null,
                    'product_name' => $product->name,
                    'weight' => $cartItem['weight'] ?? null,
                    'price' => $cartItem['price'],
                    'quantity' => $cartItem['quantity'],
                    'subtotal' => $cartItem['price'] * $cartItem['quantity'],
                ]);

                if ($cartItem['variant_id']) {
                    ProductVariant::where('id', $cartItem['variant_id'])->decrement('stock', $cartItem['quantity']);
                } else {
                    $product->decrement('stock', $cartItem['quantity']);
                }
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
