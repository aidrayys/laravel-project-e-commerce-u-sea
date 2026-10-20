@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_number)

@push('styles')
<style>
    .order-detail-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    @media (min-width: 1024px) {
        .order-detail-grid {
            grid-template-columns: 1fr 360px;
        }
    }

    .order-section {
        background-color: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .order-section h2 {
        font-size: 1.125rem;
        font-weight: 800;
        color: var(--navy);
        margin-bottom: 1rem;
    }

    .order-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .order-detail-number {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--navy);
    }

    .order-detail-date {
        color: var(--gray);
        font-size: 0.9rem;
    }

    .order-detail-status {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 700;
    }

    .product-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .product-list-item {
        display: flex;
        gap: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .product-list-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .product-list-item img {
        width: 72px;
        height: 72px;
        object-fit: cover;
        border-radius: var(--radius);
        background-color: #e0f2fe;
        flex-shrink: 0;
    }

    .product-list-info {
        flex: 1;
    }

    .product-list-name {
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 0.25rem;
    }

    .product-list-variant {
        font-size: 0.85rem;
        color: var(--ocean);
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .product-list-qty {
        font-size: 0.85rem;
        color: var(--gray);
    }

    .product-list-price {
        font-weight: 700;
        color: var(--navy);
        text-align: right;
    }

    .price-breakdown {
        border-top: 1px solid #f1f5f9;
        padding-top: 1rem;
        margin-top: 1rem;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        color: var(--gray);
    }

    .price-row.total {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--navy);
        border-top: 2px solid #f1f5f9;
        padding-top: 0.75rem;
        margin-top: 0.75rem;
    }

    .info-row {
        display: flex;
        margin-bottom: 0.75rem;
    }

    .info-label {
        width: 140px;
        flex-shrink: 0;
        color: var(--gray);
        font-size: 0.9rem;
    }

    .info-value {
        flex: 1;
        font-weight: 600;
        color: var(--navy);
    }

    /* Timeline */
    .timeline {
        position: relative;
        padding-left: 1.5rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 7px;
        width: 2px;
        background-color: #e2e8f0;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        left: -1.5rem;
        top: 0.25rem;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: var(--gray-light);
        border: 2px solid #cbd5e1;
        z-index: 1;
    }

    .timeline-item.active .timeline-dot {
        background-color: var(--ocean);
        border-color: var(--ocean);
    }

    .timeline-item.completed .timeline-dot {
        background-color: var(--success);
        border-color: var(--success);
    }

    .timeline-title {
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 0.25rem;
    }

    .timeline-desc {
        font-size: 0.85rem;
        color: var(--gray);
        margin-bottom: 0.25rem;
    }

    .timeline-time {
        font-size: 0.8rem;
        color: var(--ocean);
        font-weight: 600;
    }

    .tracking-note {
        background-color: var(--light-blue);
        border: 1px dashed var(--ocean);
        border-radius: var(--radius);
        padding: 1rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        color: var(--ocean-dark);
    }
</style>
@endpush

@section('content')
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

    <div class="section-header">
        <h1 class="page-title" style="margin-bottom: 0;">Detail Pesanan</h1>
        <a href="{{ route('orders.my') }}" class="btn btn-outline">Kembali ke Pesanan Saya</a>
    </div>

    <div class="order-detail-grid">
        <div>
            <div class="order-section">
                <div class="order-detail-header">
                    <div>
                        <div class="order-detail-number">{{ $order->order_number }}</div>
                        <div class="order-detail-date">{{ $order->created_at->format('d M Y H:i') }}</div>
                    </div>
                    <span class="order-detail-status {{ $statusClass }}">{{ $order->status }}</span>
                </div>

                <h2>Produk Dipesan</h2>
                <div class="product-list">
                    @foreach ($order->orderItems as $item)
                        <div class="product-list-item">
                            <img src="{{ asset($item->product?->image ?? 'images/placeholder.svg') }}"
                                 alt="{{ $item->product_name }}"
                                 onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'">
                            <div class="product-list-info">
                                <div class="product-list-name">{{ $item->product_name }}</div>
                                @if ($item->weight)
                                    <div class="product-list-variant">Varian: {{ $item->weight }}</div>
                                @endif
                                <div class="product-list-qty">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                            </div>
                            <div class="product-list-price">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="price-breakdown">
                    <div class="price-row">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if ($order->discount_total > 0)
                        <div class="price-row">
                            <span>Diskon</span>
                            <span>-Rp {{ number_format($order->discount_total, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="price-row">
                        <span>Ongkir</span>
                        <span>{{ $order->shipping === 0 ? 'GRATIS' : 'Rp ' . number_format($order->shipping, 0, ',', '.') }}</span>
                    </div>
                    <div class="price-row total">
                        <span>Total Pembayaran</span>
                        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            @if (in_array($order->status, ['Shipped', 'Delivered', 'Completed'], true))
                <div class="order-section" id="tracking">
                    <h2>Lacak Pengiriman</h2>
                    <div class="tracking-note">
                        Tracking berikut adalah simulasi demo untuk keperluan pengembangan lokal.
                    </div>
                    <div class="timeline">
                        @foreach ($order->trackingEvents as $index => $event)
                            @php
                                $isLast = $loop->last;
                                $itemClass = $isLast ? 'active' : 'completed';
                            @endphp
                            <div class="timeline-item {{ $itemClass }}">
                                <div class="timeline-dot"></div>
                                <div class="timeline-title">{{ $event->title }}</div>
                                <div class="timeline-desc">{{ $event->description }}</div>
                                <div class="timeline-time">{{ $event->event_at->format('d M Y, H:i') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div>
            <div class="order-section">
                <h2>Informasi Penerima</h2>
                <div class="info-row">
                    <div class="info-label">Nama</div>
                    <div class="info-value">{{ $order->customer_name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $order->customer_email }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Nomor HP</div>
                    <div class="info-value">{{ $order->customer_phone }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Kota</div>
                    <div class="info-value">{{ $order->city ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Alamat</div>
                    <div class="info-value">{{ $order->address }}</div>
                </div>
            </div>

            <div class="order-section">
                <h2>Informasi Pembayaran</h2>
                <div class="info-row">
                    <div class="info-label">Metode</div>
                    <div class="info-value">Transfer Bank / COD</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status</div>
                    <div class="info-value">{{ $order->status }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
