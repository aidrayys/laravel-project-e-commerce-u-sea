@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
    <div class="order-success">
        <div class="icon">&#10003;</div>
        <h1>Order Berhasil!</h1>
        <p>Terima kasih sudah berbelanja di U-Sea.</p>

        <div class="order-number">{{ $order->order_number }}</div>

        <div style="margin-bottom: 1rem;">
            <span class="status-badge">Status: {{ $order->status }}</span>
        </div>

        <div style="margin-bottom: 1.5rem; text-align: left; background-color: var(--gray-light); padding: 1rem; border-radius: var(--radius);">
            <div style="margin-bottom: 0.5rem;"><strong>Customer:</strong> {{ $order->customer_name }}</div>
            <div style="margin-bottom: 0.5rem;"><strong>Email:</strong> {{ $order->customer_email }}</div>
            <div style="margin-bottom: 0.5rem;"><strong>Phone:</strong> {{ $order->customer_phone }}</div>
            <div><strong>Address:</strong> {{ $order->address }}</div>
        </div>

        <h3 style="margin-bottom: 1rem; font-size: 1.125rem; text-align: left;">Ordered Products</h3>
        <div style="text-align: left; margin-bottom: 1.5rem;">
            @foreach ($order->orderItems as $item)
                <div class="summary-item">
                    <div>
                        <strong>{{ $item->product_name }}</strong>
                        @if ($item->weight)
                            <div style="font-size: 0.8rem; color: var(--ocean); font-weight: 600;">{{ $item->weight }}</div>
                        @endif
                        <div style="font-size: 0.875rem; color: var(--gray);">
                            {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                        </div>
                    </div>
                    <div>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                </div>
            @endforeach

            <div style="display: flex; justify-content: space-between; margin-top: 1rem; padding-top: 1rem; border-top: 2px solid #e2e8f0;">
                <span>Subtotal</span>
                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-top: 0.5rem;">
                <span>Shipping</span>
                <span>{{ $order->shipping === 0 ? 'FREE' : 'Rp ' . number_format($order->shipping, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-top: 0.5rem; font-size: 1.25rem; font-weight: 800;">
                <span>Total</span>
                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
            <a href="{{ route('home') }}" class="btn btn-outline">Back to Home</a>
        </div>
    </div>
@endsection
