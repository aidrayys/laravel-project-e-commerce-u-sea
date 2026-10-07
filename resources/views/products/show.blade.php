@extends('layouts.app')

@section('title', $product->name)

@push('styles')
<style>
    .variant-options-page {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin: 0.75rem 0 1rem;
    }
    .variant-option-page {
        padding: 0.5rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: var(--radius);
        background-color: var(--white);
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
    }
    .variant-option-page:hover {
        border-color: var(--cyan);
    }
    .variant-option-page.active {
        border-color: var(--ocean);
        background-color: var(--light-blue);
        color: var(--ocean);
    }
</style>
@endpush

@section('content')
    <div class="product-detail">
        <div>
            <img src="{{ asset($product->image) }}"
                 alt="{{ $product->name }}"
                 onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'">
        </div>

        <div class="product-info">
            <div class="card-category">{{ $product->category }}</div>
            <h1>{{ $product->name }}</h1>

            <div class="seller-block" style="margin: 0.75rem 0;">
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

            <p>{{ $product->description }}</p>

            <div class="card-rating" style="margin: 0.75rem 0;">
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

            @if ($product->variants->isNotEmpty())
                <div style="font-weight: 700; margin-bottom: 0.5rem;">Choose Weight</div>
                <div class="variant-options-page" id="pageVariants">
                    @foreach ($product->variants as $index => $variant)
                        <button type="button"
                                class="variant-option-page {{ $index === 0 ? 'active' : '' }}"
                                data-price="{{ $variant->price }}"
                                data-original-price="{{ $variant->original_price }}"
                                data-discount="{{ $variant->discount_percentage }}"
                                data-stock="{{ $variant->stock }}"
                                data-variant-id="{{ $variant->id }}"
                                onclick="selectPageVariant(this)">
                            {{ $variant->weight }}
                        </button>
                    @endforeach
                </div>
            @endif

            <div class="price" id="pagePrice">
                @if ($product->is_promo && $product->original_price)
                    <span style="font-size: 1rem; color: var(--gray); text-decoration: line-through; font-weight: 400;">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span><br>
                @endif
                Rp {{ number_format($product->price, 0, ',', '.') }}
                @if ($product->is_promo && $product->discount_percentage)
                    <span class="modal-discount">-{{ $product->discount_percentage }}%</span>
                @endif
            </div>

            <div class="meta"><strong>Stock:</strong> <span id="pageStock">{{ $product->stock }}</span> available</div>

            @if ($product->stock > 0)
                <form action="{{ route('cart.add', $product) }}" method="POST" style="margin-top: 1.5rem;" id="pageAddForm">
                    @csrf
                    <input type="hidden" name="variant_id" id="pageVariantId" value="{{ $product->variants->first()?->id }}">
                    <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                        <div class="quantity-selector">
                            <button type="button" onclick="adjustPageQty(-1)">-</button>
                            <input type="number" id="pageQty" name="quantity" value="1" min="1" readonly>
                            <button type="button" onclick="adjustPageQty(1)">+</button>
                        </div>
                        <button type="submit" class="btn btn-primary" style="margin-top: 0;">Add to Cart</button>
                    </div>
                </form>
            @else
                <div class="alert alert-error" style="margin-top: 1.5rem;">
                    Out of stock
                </div>
            @endif

            <a href="{{ route('products.index') }}" class="btn btn-outline" style="margin-top: 1rem;">
                Back to Products
            </a>
        </div>
    </div>

    @push('scripts')
    <script>
        let pageSelectedVariant = null;
        const pageVariants = @json($product->variants);

        function selectPageVariant(btn) {
            document.querySelectorAll('.variant-option-page').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            pageSelectedVariant = pageVariants.find(v => v.id == btn.dataset.variantId);
            document.getElementById('pageVariantId').value = pageSelectedVariant.id;
            updatePagePrice();
        }

        function updatePagePrice() {
            const price = pageSelectedVariant ? pageSelectedVariant.price : {{ $product->price }};
            const originalPrice = pageSelectedVariant ? (pageSelectedVariant.original_price || 0) : {{ $product->original_price ?? 0 }};
            const discount = pageSelectedVariant ? (pageSelectedVariant.discount_percentage || 0) : {{ $product->discount_percentage ?? 0 }};
            const stock = pageSelectedVariant ? pageSelectedVariant.stock : {{ $product->stock }};

            let html = '';
            if (originalPrice > price) {
                html += `<span style="font-size: 1rem; color: var(--gray); text-decoration: line-through; font-weight: 400;">Rp ${originalPrice.toLocaleString('id-ID')}</span><br>`;
            }
            html += `Rp ${price.toLocaleString('id-ID')}`;
            if (discount > 0) {
                html += ` <span class="modal-discount">-${discount}%</span>`;
            }

            document.getElementById('pagePrice').innerHTML = html;
            document.getElementById('pageStock').textContent = stock;
        }

        function adjustPageQty(delta) {
            const input = document.getElementById('pageQty');
            const stock = pageSelectedVariant ? pageSelectedVariant.stock : {{ $product->stock }};
            let value = parseInt(input.value) + delta;
            if (value < 1) value = 1;
            if (value > stock) value = stock;
            input.value = value;
        }

        if (pageVariants.length > 0) {
            pageSelectedVariant = pageVariants[0];
            updatePagePrice();
        }
    </script>
    @endpush
@endsection
