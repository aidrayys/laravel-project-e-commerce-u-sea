<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class PageController extends Controller
{
    /** Jumlah maksimum produk yang ditampilkan di beranda. */
    private const HOME_PRODUCT_LIMIT = 12;

    /**
     * Tampilkan halaman beranda dengan produk unggulan.
     */
    public function home(): View
    {
        // Batasi jumlah produk di beranda; katalog lengkap tersedia di /products (paginasi).
        $products = Product::with('variants')->orderBy('id')->limit(self::HOME_PRODUCT_LIMIT)->get();
        $categories = Product::select('category')->distinct()->pluck('category');

        return view('home', compact('products', 'categories'));
    }

    /**
     * Tampilkan halaman tentang U-Sea.
     */
    public function about(): View
    {
        return view('about');
    }
}
