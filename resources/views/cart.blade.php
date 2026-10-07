@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <h1 class="page-title">Shopping Cart</h1>

    @if (empty($items))
        <div class="empty-state">
            <h2>Your cart is empty</h2>
            <p>Temukan seafood segar favoritmu dan tambahkan ke keranjang.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Browse Products</a>
        </div>
    @else
        <div class="cart-table">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td data-label="Product">
                                <div class="cart-item">
                                    <img src="{{ asset($item['product']->image) }}"
                                         alt="{{ $item['product']->name }}"
                                         onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'">
                                    <div>
                                        <strong>{{ $item['product']->name }}</strong>
                                        <div style="font-size: 0.875rem; color: var(--gray);">
                                            {{ $item['product']->seller_name }}
                                        </div>
                                        @if ($item['weight'])
                                            <div style="font-size: 0.8rem; color: var(--ocean); font-weight: 600;">
                                                {{ $item['weight'] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td data-label="Price">
                                @if ($item['original_price'] && $item['original_price'] > $item['price'])
                                    <div style="font-size: 0.8rem; color: var(--gray); text-decoration: line-through;">
                                        Rp {{ number_format($item['original_price'], 0, ',', '.') }}
                                    </div>
                                @endif
                                Rp {{ number_format($item['price'], 0, ',', '.') }}
                            </td>
                            <td data-label="Quantity">
                                <form action="{{ route('cart.update', $item['product']) }}" method="POST" style="display: inline-flex; gap: 0.5rem; align-items: center;">
                                    @csrf
                                    @method('PATCH')
                                    <div class="quantity-selector">
                                        <button type="button" onclick="this.nextElementSibling.value = Math.max(1, parseInt(this.nextElementSibling.value) - 1); this.closest('form').submit();">-</button>
                                        <input type="number"
                                               name="quantity"
                                               value="{{ $item['quantity'] }}"
                                               min="1"
                                               max="{{ $item['product']->stock }}"
                                               readonly>
                                        <button type="button" onclick="this.previousElementSibling.value = Math.min({{ $item['product']->stock }}, parseInt(this.previousElementSibling.value) + 1); this.closest('form').submit();">+</button>
                                    </div>
                                </form>
                            </td>
                            <td data-label="Subtotal">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </td>
                            <td data-label="Actions">
                                <div class="cart-actions-cell">
                                    <form action="{{ route('cart.remove', $item['product']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-small">Remove</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="cart-summary">
            @php
                $freeShippingThreshold = 100000;
                $progress = min(100, ($subtotal / $freeShippingThreshold) * 100);
                $remaining = max(0, $freeShippingThreshold - $subtotal);
            @endphp

            <div class="free-shipping-bar">
                <div class="free-shipping-text">
                    @if ($shipping === 0)
                        <strong>Yeay! Kamu dapat GRATIS ONGKIR.</strong>
                    @else
                        Tambah <strong>Rp {{ number_format($remaining, 0, ',', '.') }}</strong> lagi untuk <strong>GRATIS ONGKIR</strong>
                    @endif
                </div>
                <div class="free-shipping-progress">
                    <div style="width: {{ $progress }}%;"></div>
                </div>
            </div>

            <div class="cart-summary-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            @if ($discountTotal > 0)
                <div class="cart-summary-row" style="color: var(--success);">
                    <span>Discount</span>
                    <span>-Rp {{ number_format($discountTotal, 0, ',', '.') }}</span>
                </div>
            @endif
            <div class="cart-summary-row">
                <span>Shipping</span>
                <span>{{ $shipping === 0 ? 'FREE' : 'Rp ' . number_format($shipping, 0, ',', '.') }}</span>
            </div>
            <div class="cart-summary-row total">
                <span>Total</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-top: 1rem;">
                <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="width: 100%;">Proceed to Checkout</a>
                <a href="{{ route('products.index') }}" class="btn btn-outline" style="width: 100%;">Continue Shopping</a>
            </div>
        </div>
    @endif
@endsection
