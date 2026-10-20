<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerCategoryController extends Controller
{
    /**
     * Tampilkan daftar kategori dengan jumlah produk.
     */
    public function index(): View
    {
        $categories = Category::withCount('products')->latest()->get();

        return view('seller.categories.index', compact('categories'));
    }

    /**
     * Tampilkan form tambah kategori.
     */
    public function create(): View
    {
        return view('seller.categories.create');
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($validated);

        return redirect()->route('seller.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit kategori.
     */
    public function edit(Category $category): View
    {
        return view('seller.categories.edit', compact('category'));
    }

    /**
     * Perbarui kategori.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
        ]);

        $category->update($validated);

        return redirect()->route('seller.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori.
     *
     * Kategori yang memiliki produk tidak boleh dihapus.
     */
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('seller.categories.index')
                ->with('error', "Kategori \"{$category->name}\" tidak dapat dihapus karena masih memiliki produk.");
        }

        $category->delete();

        return redirect()->route('seller.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
