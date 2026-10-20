@extends('layouts.app')

@section('title', 'Pesanan Saya')

@push('styles')
<style>
    .order-tabs {
        display: flex;
        gap: 0.5rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
        scrollbar-width: none;
    }

    .order-tabs::-webkit-scrollbar {
        display: none;
    }

    .order-tab {
        flex-shrink: 0;
        padding: 0.625rem 1rem;
        background-color: var(--white);
        border: 1px solid #e2e8f0;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--navy);
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .order-tab:hover,
    .order-tab.active {
        background-color: var(--ocean);
        color: var(--white);
        border-color: var(--ocean);
    }

    .order-tab .count {
        background-color: var(--gray-light);
        color: var(--navy);
        font-size: 0.75rem;
        font-weight: 700;
        min-width: 1.25rem;
        height: 1.25rem;
        padding: 0 0.35rem;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .order-tab.active .count {
        background-color: rgba(255, 255, 255, 0.25);
        color: var(--white);
    }

    .order-card {
        background-color: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .order-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        background-color: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
    }

    .order-card-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .order-number {
        font-weight: 800;
        color: var(--navy);
    }

    .order-date {
        font-size: 0.85rem;
        color: var(--gray);
    }

    .order-status {
        display: inline-block;
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .status-pending { background-color: #fef3c7; color: #92400e; }
    .status-processing { background-color: #dbeafe; color: #1e40af; }
    .status-shipped { background-color: #e0e7ff; color: #3730a3; }
    .status-delivered { background-color: #d1fae5; color: #065f46; }
    .status-completed { background-color: #dcfce7; color: #166534; }
    .status-cancelled { background-color: #fee2e2; color: #991b1b; }

    .order-card-body {
        padding: 1.25rem;
    }

    .order-product {
        display: flex;
        gap: 1rem;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .order-product:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .order-product img {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: var(--radius);
        background-color: #e0f2fe;
        flex-shrink: 0;
    }

    .order-product-info {
        flex: 1;
        min-width: 0;
    }

    .order-product-name {
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 0.25rem;
    }

    .order-product-variant {
        font-size: 0.8rem;
        color: var(--ocean);
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .order-product-qty {
        font-size: 0.85rem;
        color: var(--gray);
    }

    .order-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        padding: 1rem 1.25rem;
        border-top: 1px solid #f1f5f9;
        background-color: #f8fafc;
    }

    .order-total-label {
        font-size: 0.9rem;
        color: var(--gray);
    }

    .order-total-value {
        font-size: 1.125rem;
        font-weight: 800;
        color: var(--navy);
    }

    .order-actions {
        display: flex;
        gap: 0.75rem;
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        background-color: var(--light-blue);
        color: var(--ocean);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .empty-state-icon svg {
        width: 40px;
        height: 40px;
    }
</style>
@endpush

@section('content')
    <h1 class="page-title">Pesanan Saya</h1>

    @php
        $statusLabels = [
            'all' => 'Semua',
            'Pending' => 'Menunggu',
            'Processing' => 'Diproses',
            'Shipped' => 'Dikirim',
            'Delivered' => 'Diterima',
            'Completed' => 'Selesai',
            'Cancelled' => 'Dibatalkan',
        ];
        $current = request('status', 'all');

        $counts = collect($statusLabels)->map(function ($label, $status) use ($orders) {
            if ($status === 'all') {
                return $orders->total();
            }
            return App\Models\Order::where('user_id', auth()->id())->where('status', $status)->count();
        });
    @endphp

    <div class="order-tabs">
        @foreach ($statusLabels as $status => $label)
            <a href="{{ route('orders.my', ['status' => $status]) }}"
               class="order-tab {{ $current === $status ? 'active' : '' }}">
                {{ $label }}
                <span class="count">{{ $counts[$status] }}</span>
            </a>
        @endforeach
    </div>

    @if ($orders->isEmpty())
        <div class="order-card">
            <div class="empty-state" style="padding: 3rem 1rem;">
                <div class="empty-state-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l3.59-3.58L17 12l-5 5z" fill="currentColor"/>
                    </svg>
                </div>
                <h2 style="margin-bottom: 0.5rem;">Belum ada pesanan</h2>
                <p style="color: var(--gray); margin-bottom: 1.5rem;">Anda belum memiliki pesanan dengan status ini.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Mulai Belanja</a>
            </div>
        </div>
    @else
        @foreach ($orders as $order)
            @php
                $statusClass = match ($order->status) {
                    'Pending' => 'status-pending',
                    'Processing' => 'status-processing',
                    'Shipped' => 'status-shipped',
                    'Delivered' => 'status-delivered',
                    'Completed' => 'status-completed',
                    'Cancelled' => 'status-cancelled',
                    default => 'status-pending',
                };
            @endphp
            <div class="order-card">
                <div class="order-card-header">
                    <div class="order-card-meta">
                        <span class="order-number">{{ $order->order_number }}</span>
                        <span class="order-date">{{ $order->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <span class="order-status {{ $statusClass }}">{{ $order->status }}</span>
                </div>

                <div class="order-card-body">
                    @foreach ($order->orderItems as $item)
                        <div class="order-product">
                            <img src="{{ asset($item->product?->image ?? 'images/placeholder.svg') }}"
                                 alt="{{ $item->product_name }}"
                                 onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'">
                            <div class="order-product-info">
                                <div class="order-product-name">{{ $item->product_name }}</div>
                                @if ($item->weight)
                                    <div class="order-product-variant">Varian: {{ $item->weight }}</div>
                                @endif
                                <div class="order-product-qty">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="order-card-footer">
                    <div>
                        <div class="order-total-label">Total Pembayaran</div>
                        <div class="order-total-value">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                    </div>
                    <div class="order-actions">
                        @if (in_array($order->status, ['Shipped', 'Delivered', 'Completed'], true))
                            <a href="{{ route('orders.show', ['order' => $order, 'tab' => 'tracking']) }}" class="btn btn-outline btn-small">Lacak Pengiriman</a>
                        @endif
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-primary btn-small">Detail Pesanan</a>
                    </div>
                </div>
            </div>
        @endforeach

        {{ $orders->links() }}
    @endif
@endsection
