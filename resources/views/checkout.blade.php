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
                    <label for="customer_email" class="form-label">Email</label>
                    <input type="email"
                           id="customer_email"
                           name="customer_email"
                           class="form-input"
                           value="{{ old('customer_email') }}"
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
                    <div>
                        <strong>{{ $item['product']->name }}</strong>
                        <div style="font-size: 0.875rem; color: var(--gray);">
                            {{ $item['quantity'] }} x Rp {{ number_format($item['product']->price, 0, ',', '.') }}
                        </div>
                    </div>
                    <div>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                </div>
            @endforeach

            <div class="summary-total">
                <span>Grand Total</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
@endsection
