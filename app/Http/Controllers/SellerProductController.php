<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerProductController extends Controller
{
    private const SELLER_NAME = 'Pesisir Rasa';
    private const SELLER_LOCATION = 'Lamongan';

    /**
     * Siapkan data produk sebelum disimpan.
     */
    private function prepareProductData(Request $request, array $validated, ?Product $product = null): array
    {
        // Kategori "Others" menggunakan input manual
        if ($validated['category'] === 'Others' && !empty($validated['category_other'])) {
            $validated['category'] = $validated['category_other'];
        }

        // Seller info otomatis
        $validated['seller_name'] = self::SELLER_NAME;
        $validated['location'] = self::SELLER_LOCATION;

        // Harga dan promo
        $basePrice = (int) $validated['price'];
        $isPromo = $request->boolean('is_promo');

        if ($isPromo && !empty($validated['discount_percentage']) && $validated['discount_percentage'] > 0) {
            $discount = (int) $validated['discount_percentage'];
            $discountedPrice = (int) round($basePrice - ($basePrice * $discount / 100));

            $validated['original_price'] = $basePrice;
            $validated['price'] = $discountedPrice;
            $validated['discount_percentage'] = $discount;
            $validated['is_promo'] = true;
        } else {
            $validated['original_price'] = null;
            $validated['discount_percentage'] = null;
            $validated['is_promo'] = false;
        }

        // Upload gambar
        if ($request->hasFile('image')) {
            $directory = public_path('images/products');
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($directory, $filename);
            $validated['image'] = 'images/products/' . $filename;
        } elseif ($product) {
            // Pertahankan gambar lama saat edit jika tidak upload gambar baru
            unset($validated['image']);
        } else {
            $validated['image'] = null;
        }

        // Hapus field yang tidak perlu disimpan
        unset($validated['category_other']);

        return $validated;
    }

    /**
     * Tampilkan daftar produk dari sisi seller.
     */
    public function index(): View
    {
        $products = Product::latest()->get();

        return view('seller.products.index', compact('products'));
    }

    /**
     * Tampilkan form tambah produk.
     */
    public function create(): View
    {
        return view('seller.products.create');
    }

    /**
     * Simpan produk baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'is_promo' => 'boolean',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'category_other' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated = $this->prepareProductData($request, $validated);

        Product::create($validated);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit produk.
     */
    public function edit(Product $product): View
    {
        return view('seller.products.edit', compact('product'));
    }

    /**
     * Perbarui produk.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'is_promo' => 'boolean',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'category_other' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated = $this->prepareProductData($request, $validated, $product);

        $product->update($validated);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
