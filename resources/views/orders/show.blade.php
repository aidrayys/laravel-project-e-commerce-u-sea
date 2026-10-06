@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
    <div class="order-success">
        <div class="icon">&#10003;</div>
        <h1>Order Successfully Created</h1>
        <p>Thank you for shopping at U-Sea.</p>

        <div class="order-number">{{ $order->order_number }}</div>

        <div style="margin-bottom: 1rem;">
            <span class="status-badge">Status: {{ $order->status }}</span>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <div><strong>Customer:</strong> {{ $order->customer_name }}</div>
            <div><strong>Email:</strong> {{ $order->customer_email }}</div>
            <div><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</div>
        </div>

        <h3 style="margin-bottom: 1rem; font-size: 1.125rem;">Ordered Products</h3>
        <div style="text-align: left; margin-bottom: 1.5rem;">
            @foreach ($order->orderItems as $item)
                <div class="summary-item">
                    <div>
                        <strong>{{ $item->product_name }}</strong>
                        <div style="font-size: 0.875rem; color: var(--gray);">
                            {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                        </div>
                    </div>
                    <div>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                </div>
            @endforeach
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
            <a href="{{ route('home') }}" class="btn btn-outline">Back to Home</a>
        </div>
    </div>
@endsection
