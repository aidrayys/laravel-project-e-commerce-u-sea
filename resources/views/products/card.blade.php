<article class="card">
    <a href="{{ route('products.show', $product) }}" class="card-image-wrapper">
        <img src="{{ asset($product->image) }}"
             alt="{{ $product->name }}"
             class="card-image"
             onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'">
        @if ($product->is_promo && $product->discount_percentage)
            <span class="promo-badge">-{{ $product->discount_percentage }}%</span>
        @endif
    </a>

    <div class="card-body">
        <div class="card-category">{{ $product->category }}</div>
        <a href="{{ route('products.show', $product) }}">
            <h3 class="card-title">{{ $product->name }}</h3>
        </a>

        <div class="card-price-block">
            @if ($product->is_promo && $product->original_price)
                <span class="card-original-price">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
            @endif
            <div>
                <span class="card-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @if ($product->is_promo && $product->discount_percentage)
                    <span class="card-discount">{{ $product->discount_percentage }}% OFF</span>
                @endif
            </div>
        </div>

        <div class="seller-block">
            <div class="seller-avatar" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="currentColor"/>
                </svg>
            </div>
            <div class="seller-info">
                <div class="seller-name">{{ $product->seller_name }}</div>
                <div class="seller-location">
                    <svg class="seller-location-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="currentColor"/>
                    </svg>
                    {{ $product->location }}
                </div>
            </div>
            @if ($product->category === 'Fresh Seafood')
                <span class="seller-badge badge-local">LOCAL SELLER</span>
            @elseif ($product->category === 'Processed Seafood')
                <span class="seller-badge badge-umkm">UMKM PESISIR</span>
            @endif
        </div>

        <div class="card-rating">
            <span class="stars" aria-hidden="true">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= round($product->rating ?? 4.8))
                        ★
                    @else
                        ☆
                    @endif
                @endfor
            </span>
            <span class="rating-value">{{ number_format($product->rating ?? 4.8, 1) }}</span>
        </div>

        <div class="card-actions">
            <button type="button"
                    class="btn btn-primary btn-small open-product-modal"
                    style="width: 100%;"
                    data-product-id="{{ $product->id }}"
                    data-product-name="{{ $product->name }}"
                    data-product-category="{{ $product->category }}"
                    data-product-description="{{ $product->description }}"
                    data-product-image="{{ asset($product->image) }}"
                    data-product-price="{{ $product->price }}"
                    data-product-original-price="{{ $product->original_price }}"
                    data-product-discount="{{ $product->discount_percentage }}"
                    data-product-is-promo="{{ $product->is_promo ? 1 : 0 }}"
                    data-product-stock="{{ $product->stock }}"
                    data-product-rating="{{ $product->rating ?? 4.8 }}"
                    data-product-seller="{{ $product->seller_name }}"
                    data-product-location="{{ $product->location }}"
                    data-variants='@json($product->variants)'
                    data-add-url="{{ route('cart.add', $product) }}">
                Add to Cart
            </button>
        </div>
    </div>
</article>
