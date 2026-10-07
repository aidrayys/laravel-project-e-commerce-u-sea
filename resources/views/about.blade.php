@extends('layouts.app')

@section('title', 'About')

@section('content')
    <div class="product-detail" style="text-align: center; padding: 3rem 2rem;">
        <div style="max-width: 700px; margin: 0 auto;">
            <h1 class="page-title">About U-Sea</h1>
            <p style="font-size: 1.125rem; color: var(--gray); margin-bottom: 1.5rem;">
                U-Sea adalah marketplace yang menghubungkan nelayan lokal dan UMKM seafood pesisir Indonesia dengan pelanggan.
            </p>
            <p style="color: var(--gray); margin-bottom: 2rem;">
                "Belanja dari Laut, Bantu Nelayan Lokal." Setiap pembelian membantu keluarga nelayan dan pelaku usaha kecil di pesisir untuk mendapatkan akses pasar yang lebih luas.
            </p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Explore Products</a>
        </div>
    </div>
@endsection
