@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="product-detail">
        <div>
            <img src="{{ $product->image ?? asset('images/placeholder.svg') }}"
                 alt="{{ $product->name }}"
                 onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'">
        </div>

        <div class="product-info">
            <div class="card-category">{{ $product->category }}</div>
            <h1>{{ $product->name }}</h1>
            <div class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

            <p>{{ $product->description }}</p>

            <div class="meta"><strong>Seller:</strong> {{ $product->seller_name }}</div>
            <div class="meta"><strong>Location:</strong> {{ $product->location }}</div>
            <div class="meta"><strong>Stock:</strong> {{ $product->stock }} available</div>

            @if ($product->stock > 0)
                <form action="{{ route('cart.add', $product) }}" method="POST" style="margin-top: 1.5rem;">
                    @csrf
                    <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                        <div>
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number"
                                   id="quantity"
                                   name="quantity"
                                   class="form-input quantity-input"
                                   value="1"
                                   min="1"
                                   max="{{ $product->stock }}"
                                   required>
                        </div>
                        <button type="submit" class="btn btn-primary" style="margin-top: 1.5rem;">Add to Cart</button>
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
@endsection
