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
                                    <img src="{{ $item['product']->image ?? asset('images/placeholder.svg') }}"
                                         alt="{{ $item['product']->name }}"
                                         onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'">
                                    <div>
                                        <strong>{{ $item['product']->name }}</strong>
                                        <div style="font-size: 0.875rem; color: var(--gray);">
                                            {{ $item['product']->seller_name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Price">
                                Rp {{ number_format($item['product']->price, 0, ',', '.') }}
                            </td>
                            <td data-label="Quantity">
                                <form action="{{ route('cart.update', $item['product']) }}" method="POST" style="display: inline-flex; gap: 0.5rem; align-items: center;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number"
                                           name="quantity"
                                           class="form-input quantity-input"
                                           value="{{ $item['quantity'] }}"
                                           min="1"
                                           max="{{ $item['product']->stock }}"
                                           required>
                                    <button type="submit" class="btn btn-primary btn-small">Update</button>
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
