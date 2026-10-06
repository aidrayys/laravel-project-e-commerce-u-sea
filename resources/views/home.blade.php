@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section class="hero">
        <div class="hero-label">Local Seafood Marketplace</div>
        <h1 class="hero-title">From the Sea, Direct to You.</h1>
        <p class="hero-text">
            Temukan seafood segar dan produk olahan laut dari UMKM pesisir Indonesia.
        </p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Explore Products</a>
    </section>

    <section>
        <h2 class="section-title">Featured Products</h2>

        @if ($products->isEmpty())
            <div class="empty-state">
                <h2>Belum ada produk</h2>
                <p>Produk akan segera tersedia.</p>
            </div>
        @else
            <div class="product-grid">
                @foreach ($products as $product)
                    @include('products.card', ['product' => $product])
                @endforeach
            </div>

            <div style="text-align: center; margin-top: 1.5rem;">
                <a href="{{ route('products.index') }}" class="btn btn-outline">View All Products</a>
            </div>
        @endif
    </section>
@endsection
