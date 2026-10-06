<article class="card">
    <a href="{{ route('products.show', $product) }}">
        <img src="{{ $product->image ?? asset('images/placeholder.svg') }}"
             alt="{{ $product->name }}"
             class="card-image"
             onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'">
    </a>

    <div class="card-body">
        <div class="card-category">{{ $product->category }}</div>
        <a href="{{ route('products.show', $product) }}">
            <h3 class="card-title">{{ $product->name }}</h3>
        </a>
        <div class="card-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
        <div class="card-meta">Seller: {{ $product->seller_name }}</div>
        <div class="card-meta">Location: {{ $product->location }}</div>

        <div class="card-actions">
            <form action="{{ route('cart.add', $product) }}" method="POST">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-primary btn-small" style="width: 100%;">Add to Cart</button>
            </form>
        </div>
    </div>
</article>
