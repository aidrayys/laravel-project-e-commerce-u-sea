@extends('layouts.app')

@section('title', 'Home')

@section('content')
    {{-- Hero Carousel --}}
    <section class="hero-carousel" aria-label="Promotional carousel">
        {{-- Slide 1 --}}
        <div class="hero-slide active">
            <div class="hero-slide-bg">
                <div class="hero-wave"></div>
                <div class="hero-bubble" style="width: 40px; height: 40px; top: 15%; left: 10%;"></div>
                <div class="hero-bubble" style="width: 24px; height: 24px; top: 25%; left: 25%; animation-delay: 1s;"></div>
                <div class="hero-bubble" style="width: 32px; height: 32px; top: 60%; left: 15%; animation-delay: 2s;"></div>
            </div>
            <div class="hero-content">
                <span class="hero-badge">SUPPORT LOCAL</span>
                <h1 class="hero-title">Belanja dari Laut, Bantu Nelayan Lokal</h1>
                <p class="hero-text">Temukan hasil laut segar langsung dari nelayan dan UMKM pesisir Indonesia.</p>
                <a href="{{ route('products.index') }}" class="btn btn-large hero-cta">Belanja Sekarang</a>
            </div>
            <div class="hero-visual">
                <img src="{{ asset('images/products/fresh-tuna.jpg') }}" alt="Fresh tuna from local fishermen">
            </div>
        </div>

        {{-- Slide 2 --}}
        <div class="hero-slide">
            <div class="hero-slide-bg">
                <div class="hero-wave"></div>
                <div class="hero-bubble" style="width: 36px; height: 36px; top: 20%; left: 12%;"></div>
                <div class="hero-bubble" style="width: 28px; height: 28px; top: 45%; left: 20%; animation-delay: 1.5s;"></div>
            </div>
            <div class="hero-content">
                <span class="hero-badge">FRESH FROM THE SEA</span>
                <h1 class="hero-title">Fresh Seafood, Fresh from the Sea</h1>
                <p class="hero-text">Seafood pilihan dengan kualitas terbaik dari pesisir Indonesia.</p>
                <a href="{{ route('products.index') }}" class="btn btn-large hero-cta">Lihat Produk</a>
            </div>
            <div class="hero-visual">
                <img src="{{ asset('images/products/fresh-shrimp.jpg') }}" alt="Fresh shrimp and seafood selection">
            </div>
        </div>

        {{-- Slide 3 --}}
        <div class="hero-slide">
            <div class="hero-slide-bg">
                <div class="hero-wave"></div>
                <div class="hero-bubble" style="width: 30px; height: 30px; top: 18%; left: 14%;"></div>
                <div class="hero-bubble" style="width: 22px; height: 22px; top: 55%; left: 8%; animation-delay: 0.8s;"></div>
            </div>
            <div class="hero-content">
                <span class="hero-badge">FREE SHIPPING</span>
                <h1 class="hero-title">Gratis Ongkir, Makin Hemat</h1>
                <p class="hero-text">Nikmati gratis ongkir untuk pesanan dan promo tertentu.</p>
                <a href="{{ route('products.index') }}" class="btn btn-large hero-cta">Ambil Promo</a>
            </div>
            <div class="hero-visual">
                <img src="{{ asset('images/products/smoked-milkfish.jpg') }}" alt="Seafood package ready for delivery">
            </div>
        </div>

        {{-- Slide 4 --}}
        <div class="hero-slide">
            <div class="hero-slide-bg">
                <div class="hero-wave"></div>
                <div class="hero-bubble" style="width: 34px; height: 34px; top: 22%; left: 11%;"></div>
                <div class="hero-bubble" style="width: 26px; height: 26px; top: 48%; left: 22%; animation-delay: 1.2s;"></div>
            </div>
            <div class="hero-content">
                <span class="hero-badge">UP TO 20% OFF</span>
                <h1 class="hero-title">Seafood Favorit, Harga Lebih Hemat</h1>
                <p class="hero-text">Dapatkan promo spesial untuk seafood segar dan produk olahan laut.</p>
                <a href="{{ route('products.index') }}" class="btn btn-large hero-cta">Lihat Promo</a>
            </div>
            <div class="hero-visual">
                <img src="{{ asset('images/products/seafood-crackers.jpg') }}" alt="Promotional seafood products">
            </div>
        </div>

        <button type="button" class="hero-arrow prev" onclick="prevSlide(); resetCarousel();" aria-label="Previous slide">&#10094;</button>
        <button type="button" class="hero-arrow next" onclick="nextSlide(); resetCarousel();" aria-label="Next slide">&#10095;</button>

        <div class="hero-controls">
            <button type="button" class="hero-dot active" onclick="showSlide(0); resetCarousel();" aria-label="Go to slide 1"></button>
            <button type="button" class="hero-dot" onclick="showSlide(1); resetCarousel();" aria-label="Go to slide 2"></button>
            <button type="button" class="hero-dot" onclick="showSlide(2); resetCarousel();" aria-label="Go to slide 3"></button>
            <button type="button" class="hero-dot" onclick="showSlide(3); resetCarousel();" aria-label="Go to slide 4"></button>
        </div>
    </section>

    {{-- Value Proposition --}}
    <section class="section">
        <h2 class="section-title">Kenapa Belanja di U-Sea?</h2>
        <div class="value-grid">
            <div class="value-card">
                <div class="value-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="currentColor"/></svg>
                </div>
                <h3>Support Local Fishermen</h3>
                <p>Setiap pembelian membantu menghubungkan hasil laut nelayan dengan pelanggan.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 22c4.97 0 9-4.03 9-9-4.5 0-9-9-9-9s-4.5 9-9 9c0 4.97 4.03 9 9 9z" fill="currentColor"/></svg>
                </div>
                <h3>Fresh from the Sea</h3>
                <p>Pilihan seafood segar dan berkualitas dari pesisir Indonesia.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.89 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" fill="currentColor"/></svg>
                </div>
                <h3>Harga Terjangkau</h3>
                <p>Belanja produk laut dari nelayan dan UMKM lokal.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 9h-2v-2h2v2zm0 4h-2v-2h2v2zm0 4h-2v-2h2v2zM20 3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H4V5h16v14zM7 7h5v2H7V7zm0 4h5v2H7v-2zm0 4h5v2H7v-2z" fill="currentColor"/></svg>
                </div>
                <h3>Gratis Ongkir</h3>
                <p>Nikmati promo gratis ongkir untuk pesanan tertentu.</p>
            </div>
        </div>
    </section>

    {{-- Promo Section --}}
    <section class="section">
        <h2 class="section-title">Promo Hari Ini</h2>
        <div class="promo-grid">
            <div class="promo-card">
                <div>
                    <h3>DISKON HINGGA 20%</h3>
                    <p>Seafood pilihan</p>
                </div>
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="currentColor"/></svg>
            </div>
            <div class="promo-card">
                <div>
                    <h3>GRATIS ONGKIR</h3>
                    <p>Min. belanja Rp100.000</p>
                </div>
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z" fill="currentColor"/></svg>
            </div>
            <div class="promo-card">
                <div>
                    <h3>NEW CUSTOMER</h3>
                    <p>Diskon pembelian pertama</p>
                </div>
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="currentColor"/></svg>
            </div>
            <div class="promo-card">
                <div>
                    <h3>BUY MORE SAVE MORE</h3>
                    <p>Belanja lebih banyak, lebih hemat</p>
                </div>
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" fill="currentColor"/></svg>
            </div>
        </div>
    </section>

    {{-- Category Section --}}
    <section class="section">
        <h2 class="section-title">Belanja Berdasarkan Kategori</h2>
        <div class="category-scroll">
            <a href="{{ route('products.index') }}" class="category-chip {{ request('category') ? '' : 'active' }}">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" fill="currentColor"/></svg>
                All
            </a>
            @foreach ($categories as $category)
                <a href="{{ route('products.index', ['category' => $category]) }}" class="category-chip {{ request('category') == $category ? 'active' : '' }}">
                    {{ $category }}
                </a>
            @endforeach
            <a href="{{ route('products.index', ['search' => 'Fish']) }}" class="category-chip">Fish</a>
            <a href="{{ route('products.index', ['search' => 'Shrimp']) }}" class="category-chip">Shrimp</a>
            <a href="{{ route('products.index', ['search' => 'Squid']) }}" class="category-chip">Squid</a>
            <a href="{{ route('products.index', ['search' => 'Sambal']) }}" class="category-chip">Sambal</a>
            <a href="{{ route('products.index', ['search' => 'Seafood Snacks']) }}" class="category-chip">Seafood Snacks</a>
        </div>
    </section>

    {{-- Featured Products --}}
    <section class="section">
        <div class="section-header">
            <h2 class="section-title" style="margin-bottom: 0;">Fresh From The Sea</h2>
            <a href="{{ route('products.index') }}">Lihat Semua &rarr;</a>
        </div>

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
        @endif
    </section>

    {{-- Support Local Fishermen Story --}}
    <section class="section" id="support-local">
        <div class="support-section">
            <div class="support-content">
                <h2>Your Purchase Supports Local Fishermen</h2>
                <p>U-Sea membantu mempertemukan hasil laut dari nelayan dan UMKM pesisir dengan pelanggan secara lebih mudah.</p>
                <div class="support-highlights">
                    <div class="support-highlight">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        Local Fishermen
                    </div>
                    <div class="support-highlight">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        Fresh Seafood
                    </div>
                    <div class="support-highlight">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        Direct Marketplace
                    </div>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-large hero-cta">Explore Seafood</a>
            </div>
            <div class="support-visual">
                <img src="{{ asset('images/products/fresh-snapper.jpg') }}" alt="Fresh seafood supporting local fishermen">
            </div>
        </div>
    </section>
@endsection
