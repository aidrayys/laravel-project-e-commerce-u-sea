<?php

namespace App\Http\Controllers;

use App\Exceptions\CheckoutException;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(private readonly CartService $cartService) {}

    /**
     * Tampilkan halaman checkout beserta ringkasan pesanan.
     * Harga & stok selalu dihitung ulang dari database, bukan dari session.
     */
    public function checkout(Request $request): View|RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        $summary = $this->cartService->summarize($cart);
        unset($summary['invalid']);

        /** @var User $user */
        $user = auth()->user();
        $customerDefaults = [
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => old('customer_phone', $user->phone ?? ''),
            'customer_city' => old('customer_city', $user->city ?? ''),
            'address' => old('address', $user->address ?? ''),
        ];

        return view('checkout', array_merge($summary, $customerDefaults));
    }

    /**
     * Simpan pesanan beserta item-itemnya ke database.
     *
     * Alur: validasi input -> transaksi DB -> kunci baris produk/varian (lockForUpdate)
     * -> cek stok -> simpan order & item dengan harga terkini -> kurangi stok -> commit.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:255',
            'customer_city' => 'nullable|string|max:255',
            'address' => 'required|string',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        try {
            $order = DB::transaction(function () use ($validated, $cart) {
                // lockForUpdate() mengunci baris produk/varian sampai transaksi selesai,
                // sehingga dua checkout bersamaan tidak bisa menjual stok yang sama.
                $summary = $this->cartService->summarize($cart, lock: true);

                if (! empty($summary['invalid'])) {
                    throw new CheckoutException(reset($summary['invalid']));
                }

                foreach ($summary['items'] as $item) {
                    if ($item['stock'] < $item['quantity']) {
                        throw new CheckoutException(
                            "Stok {$item['product']->name} tidak mencukupi. Stok tersedia: {$item['stock']}."
                        );
                    }
                }

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'customer_name' => $validated['customer_name'],
                    'customer_email' => $validated['customer_email'],
                    'customer_phone' => $validated['customer_phone'],
                    'address' => $validated['address'],
                    'city' => $validated['customer_city'] ?? null,
                    'subtotal' => $summary['subtotal'],
                    'shipping' => $summary['shipping'],
                    // Subtotal sudah memakai harga setelah diskon, jadi discount_total
                    // tetap 0 agar invoice (Subtotal - Diskon + Ongkir) tidak terpotong dua kali.
                    'discount_total' => 0,
                    'total' => $summary['total'],
                    'status' => 'Pending',
                ]);

                foreach ($summary['items'] as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product']->id,
                        'product_variant_id' => $item['variant']?->id,
                        'product_name' => $item['product']->name,
                        'weight' => $item['weight'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    // Kurangi stok pada sumber harga yang sama (varian atau produk).
                    ($item['variant'] ?? $item['product'])->decrement('stock', $item['quantity']);
                }

                $order->trackingEvents()->create([
                    'status' => $order->status,
                    'title' => 'Pesanan dibuat',
                    'description' => 'Pesanan berhasil dibuat dan menunggu konfirmasi.',
                    'event_at' => now(),
                ]);

                return $order;
            });
        } catch (CheckoutException $e) {
            // Transaksi sudah di-rollback otomatis; tidak ada stok yang berkurang.
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }

        session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat.');
    }

    /**
     * Tampilkan halaman konfirmasi pesanan (invoice).
     */
    public function show(Order $order): View
    {
        $this->authorizeOrder($order);

        $order->load('orderItems.product');

        return view('orders.show', compact('order'));
    }

    /**
     * Tampilkan daftar pesanan customer yang sedang login.
     */
    public function myOrders(Request $request): View
    {
        $query = Order::with('orderItems.product')
            ->where('user_id', auth()->id());

        $status = $request->input('status');
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('orders.my', compact('orders'));
    }

    /**
     * Pastikan user hanya dapat melihat pesanan miliknya sendiri
     * kecuali admin.
     */
    private function authorizeOrder(Order $order): void
    {
        /** @var User|null $user */
        $user = auth()->user();

        if ($user && $user->isAdmin()) {
            return;
        }

        if ($order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }
    }
}
