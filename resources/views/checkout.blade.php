@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <h1 class="page-title">Checkout</h1>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin-left: 1.25rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="checkout-grid">
        <div class="checkout-card">
            <h2>Customer Information</h2>

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="customer_name" class="form-label">Customer Name</label>
                    <input type="text"
                           id="customer_name"
                           name="customer_name"
                           class="form-input"
                           value="{{ old('customer_name') }}"
                           required>
                </div>

                <div class="form-group">
                    <label for="customer_phone" class="form-label">Phone</label>
                    <input type="text"
                           id="customer_phone"
                           name="customer_phone"
                           class="form-input"
                           value="{{ old('customer_phone') }}"
                           required>
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Delivery Address</label>
                    <textarea id="address"
                              name="address"
                              class="form-textarea"
                              required>{{ old('address') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Place Order</button>
            </form>
        </div>

        <div class="checkout-card">
            <h2>Order Summary</h2>

            @foreach ($items as $item)
                <div class="summary-item">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <img src="{{ asset($item['product']->image) }}"
                             alt="{{ $item['product']->name }}"
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 0.5rem;"
                             onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'">
                        <div>
                            <strong>{{ $item['product']->name }}</strong>
                            <div style="font-size: 0.8rem; color: var(--gray);">
                                {{ $item['product']->seller_name }}
                                @if ($item['weight'])
                                    · {{ $item['weight'] }}
                                @endif
                            </div>
                            <div style="font-size: 0.8rem; color: var(--gray);">
                                {{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                        @if ($item['saved'] > 0)
                            <div style="font-size: 0.75rem; color: var(--success);">Save Rp {{ number_format($item['saved'], 0, ',', '.') }}</div>
                        @endif
                    </div>
                </div>
            @endforeach

            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.95rem;">
                <span style="color: var(--gray);">Subtotal</span>
                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            @if ($discountTotal > 0)
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.95rem; color: var(--success);">
                    <span>Discount</span>
                    <span>-Rp {{ number_format($discountTotal, 0, ',', '.') }}</span>
                </div>
            @endif
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.95rem;">
                <span style="color: var(--gray);">Shipping</span>
                <span>{{ $shipping === 0 ? 'FREE' : 'Rp ' . number_format($shipping, 0, ',', '.') }}</span>
            </div>

            <div class="summary-total">
                <span>Grand Total</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
@endsection
