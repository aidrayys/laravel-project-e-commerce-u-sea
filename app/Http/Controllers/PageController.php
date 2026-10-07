<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Tampilkan halaman beranda dengan produk unggulan.
     */
    public function home(): View
    {
        $products = Product::limit(8)->get();
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
