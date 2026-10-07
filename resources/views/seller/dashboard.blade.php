@extends('layouts.app')

@section('title', 'Seller Dashboard')

@push('styles')
<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    @media (min-width: 1024px) {
        .dashboard-grid {
            grid-template-columns: 2fr 1fr;
        }
    }

    .dashboard-main,
    .dashboard-sidebar {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    @media (min-width: 640px) {
        .summary-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    .summary-card {
        background-color: var(--white);
        border-radius: var(--radius-lg);
        padding: 1.25rem;
        box-shadow: var(--shadow);
        border: 1px solid #f1f5f9;
        transition: transform 0.2s;
    }

    .summary-card:hover {
        transform: translateY(-3px);
    }

    .summary-label {
        font-size: 0.8rem;
        color: var(--gray);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .summary-value {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--navy);
        margin-bottom: 0.5rem;
    }

    .summary-change {
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .summary-change.up {
        color: var(--success);
    }

    .summary-change.down {
        color: var(--danger);
    }

    .dashboard-card {
        background-color: var(--white);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow);
        border: 1px solid #f1f5f9;
    }

    .dashboard-card h2 {
        font-size: 1.125rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--navy);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .chart-tabs {
        display: flex;
        gap: 0.25rem;
        background-color: var(--gray-light);
        padding: 0.25rem;
        border-radius: var(--radius);
    }

    .chart-tab {
        padding: 0.375rem 0.75rem;
        border: none;
        background: none;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--gray);
        cursor: pointer;
        transition: all 0.2s;
    }

    .chart-tab.active {
        background-color: var(--white);
        color: var(--navy);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .chart-wrapper {
        display: flex;
        gap: 0.75rem;
        height: 280px;
    }

    .chart-y-axis {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-end;
        width: 55px;
        flex-shrink: 0;
        padding-bottom: 2.25rem;
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--gray);
    }

    .chart-plot {
        flex: 1;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .chart-grid {
        position: absolute;
        inset: 0;
        bottom: 2.25rem;
        z-index: 0;
    }

    .grid-line {
        position: absolute;
        left: 0;
        right: 0;
        border-top: 1px dashed #e2e8f0;
    }

    .chart-bars {
        flex: 1;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: clamp(0.35rem, 2vw, 0.875rem);
        position: relative;
        z-index: 1;
        padding-bottom: 2.25rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .chart-bar-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        gap: 0.5rem;
        position: relative;
        height: 100%;
    }

    .chart-bar {
        width: 100%;
        max-width: 52px;
        background: linear-gradient(180deg, var(--cyan) 0%, var(--ocean) 100%);
        border-radius: 0.5rem 0.5rem 0 0;
        transition: height 0.4s ease;
        position: relative;
        min-height: 2px;
    }

    .chart-bar:hover {
        filter: brightness(1.05);
    }

    .chart-tooltip {
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background-color: var(--navy);
        color: var(--white);
        padding: 0.35rem 0.6rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s;
        margin-bottom: 0.4rem;
        z-index: 2;
    }

    .chart-bar-wrapper:hover .chart-tooltip {
        opacity: 1;
        visibility: visible;
    }

    .chart-label {
        font-size: 0.75rem;
        color: var(--gray);
        font-weight: 600;
        position: absolute;
        bottom: 0;
        transform: translateY(1.4rem);
        white-space: nowrap;
    }

    .insight-list {
        list-style: none;
    }

    .insight-list li {
        display: flex;
        gap: 0.75rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.9rem;
        color: var(--navy);
    }

    .insight-list li:last-child {
        border-bottom: none;
    }

    .insight-bullet {
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 50%;
        background-color: var(--light-blue);
        color: var(--ocean);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .top-product {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.875rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .top-product:last-child {
        border-bottom: none;
    }

    .top-rank {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        background-color: var(--gray-light);
        color: var(--navy);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.875rem;
    }

    .top-info {
        flex: 1;
    }

    .top-name {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--navy);
    }

    .top-meta {
        font-size: 0.75rem;
        color: var(--gray);
    }

    .top-revenue {
        font-weight: 800;
        color: var(--ocean);
        font-size: 0.9rem;
    }

    .donut-chart {
        width: 160px;
        height: 160px;
        border-radius: 50%;
        position: relative;
        margin: 0 auto 1.5rem;
    }

    .donut-hole {
        position: absolute;
        inset: 28%;
        background-color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .donut-hole .value {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--navy);
    }

    .donut-hole .label {
        font-size: 0.65rem;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .city-bar {
        margin-bottom: 0.875rem;
    }

    .city-bar-header {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        margin-bottom: 0.35rem;
    }

    .city-bar-track {
        height: 8px;
        background-color: var(--gray-light);
        border-radius: 9999px;
        overflow: hidden;
    }

    .city-bar-fill {
        height: 100%;
        border-radius: 9999px;
        transition: width 0.6s ease;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
    }

    .quick-action {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        background-color: var(--light-blue);
        border-radius: var(--radius);
        text-decoration: none;
        color: var(--navy);
        font-weight: 600;
        font-size: 0.85rem;
        transition: background-color 0.2s, transform 0.2s;
    }

    .quick-action:hover {
        background-color: #bae6fd;
        transform: translateY(-2px);
    }

    .quick-action svg {
        width: 1.5rem;
        height: 1.5rem;
        color: var(--ocean);
    }

    .stock-alert {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        background-color: #fff7ed;
        border: 1px solid #fed7aa;
        border-radius: var(--radius);
        margin-bottom: 0.75rem;
    }

    .stock-alert:last-child {
        margin-bottom: 0;
    }

    .stock-alert-icon {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        background-color: #ffedd5;
        color: var(--coral);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stock-alert-info {
        flex: 1;
    }

    .stock-alert-name {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--navy);
    }

    .stock-alert-text {
        font-size: 0.8rem;
        color: var(--coral);
        font-weight: 600;
    }

    .status-badge-sm {
        display: inline-block;
        padding: 0.25rem 0.625rem;
        border-radius: 9999px;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .status-completed {
        background-color: #dcfce7;
        color: #166534;
    }

    .status-processing {
        background-color: #dbeafe;
        color: #1e40af;
    }

    .status-pending {
        background-color: #ffedd5;
        color: #9a3412;
    }

    .seller-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .seller-info h1 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--navy);
    }

    .seller-info p {
        color: var(--gray);
        font-size: 0.9rem;
    }
</style>
@endpush

@section('content')
    <div class="seller-header">
        <div class="seller-info">
            <h1>Pesisir Rasa</h1>
            <p>Lamongan &middot; Seller Dashboard</p>
        </div>
        <form action="{{ route('seller.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline">Logout</button>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-label">Total Sales</div>
            <div class="summary-value">Rp {{ number_format($summary['total_sales'], 0, ',', '.') }}</div>
            <span class="summary-change up">▲ +{{ $summary['sales_growth'] }}% vs last month</span>
        </div>
        <div class="summary-card">
            <div class="summary-label">Total Orders</div>
            <div class="summary-value">{{ number_format($summary['total_orders'], 0, ',', '.') }}</div>
            <span class="summary-change up">▲ +{{ $summary['orders_growth'] }}% vs last month</span>
        </div>
        <div class="summary-card">
            <div class="summary-label">Total Products</div>
            <div class="summary-value">{{ $summary['total_products'] }}</div>
            <span class="summary-change up">▲ +{{ $summary['new_products'] }} new product</span>
        </div>
        <div class="summary-card">
            <div class="summary-label">Average Order Value</div>
            <div class="summary-value">Rp {{ number_format($summary['average_order_value'], 0, ',', '.') }}</div>
            <span class="summary-change up">▲ +{{ $summary['aov_growth'] }}% vs last month</span>
        </div>
    </div>

    <div class="dashboard-grid" style="margin-top: 1.5rem;">
        <div class="dashboard-main">
            {{-- Sales Performance Chart --}}
            <div class="dashboard-card">
                <div class="chart-header">
                    <h2>Sales Performance</h2>
                    <div class="chart-tabs">
                        <button type="button" class="chart-tab active" data-period="7_days">7 Days</button>
                        <button type="button" class="chart-tab" data-period="4_weeks">4 Weeks</button>
                        <button type="button" class="chart-tab" data-period="6_months">6 Months</button>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <div class="chart-y-axis" id="salesYAxis"></div>
                    <div class="chart-plot">
                        <div class="chart-grid" id="salesGrid"></div>
                        <div class="chart-bars" id="salesChart"></div>
                    </div>
                </div>
            </div>

            {{-- Sales Analysis --}}
            <div class="dashboard-card">
                <h2>Sales Analysis</h2>
                <ul class="insight-list">
                    <li>
                        <span class="insight-bullet">1</span>
                        <span>Penjualan menunjukkan <strong>tren meningkat</strong> dari Senin ke Minggu.</span>
                    </li>
                    <li>
                        <span class="insight-bullet">2</span>
                        <span><strong>Minggu</strong> menjadi hari dengan penjualan tertinggi, sementara <strong>Rabu</strong> terendah.</span>
                    </li>
                    <li>
                        <span class="insight-bullet">3</span>
                        <span><strong>Fresh Snapper</strong> menyumbang penjualan terbesar minggu ini.</span>
                    </li>
                </ul>
            </div>

            {{-- Recent Orders --}}
            <div class="dashboard-card" id="recent-orders">
                <h2>Pesanan Terbaru</h2>
                <div class="cart-table" style="margin-bottom: 0;">
                    <table>
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>City</th>
                                <th>Product</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentOrders as $order)
                                <tr>
                                    <td data-label="Order"><strong>{{ $order['order'] }}</strong></td>
                                    <td data-label="Customer">{{ $order['customer'] }}</td>
                                    <td data-label="City">{{ $order['city'] }}</td>
                                    <td data-label="Product">{{ $order['product'] }}</td>
                                    <td data-label="Total">Rp {{ number_format($order['total'], 0, ',', '.') }}</td>
                                    <td data-label="Status">
                                        @php
                                            $statusClass = match ($order['status']) {
                                                'Completed' => 'status-completed',
                                                'Processing' => 'status-processing',
                                                'Pending Payment' => 'status-pending',
                                                default => 'status-completed',
                                            };
                                        @endphp
                                        <span class="status-badge-sm {{ $statusClass }}">{{ $order['status'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="dashboard-sidebar">
            {{-- Top Products --}}
            <div class="dashboard-card">
                <h2>Produk Terlaris</h2>
                @foreach ($topProducts as $index => $product)
                    <div class="top-product">
                        <div class="top-rank">{{ $index + 1 }}</div>
                        <div class="top-info">
                            <div class="top-name">{{ $product['name'] }}</div>
                            <div class="top-meta">{{ $product['sold'] }} sold</div>
                        </div>
                        <div class="top-revenue">Rp {{ number_format($product['revenue'], 0, ',', '.') }}</div>
                    </div>
                @endforeach
            </div>

            {{-- Customer Analytics --}}
            <div class="dashboard-card">
                <h2>Analisis Konsumen</h2>
                <div class="donut-chart" id="customerDonut" style="background: conic-gradient(
                    #087EA4 0% 42%,
                    #18AEE5 42% 66%,
                    #06b6d4 66% 81%,
                    #94a3b8 81% 92%,
                    #cbd5e1 92% 100%
                );">
                    <div class="donut-hole">
                        <span class="value">{{ $customerStats['total'] }}</span>
                        <span class="label">Customers</span>
                    </div>
                </div>

                @foreach ($customerCities as $index => $city)
                    @php
                        $colors = ['#087EA4', '#18AEE5', '#06b6d4', '#94a3b8', '#cbd5e1'];
                    @endphp
                    <div class="city-bar">
                        <div class="city-bar-header">
                            <span>{{ $city['city'] }}</span>
                            <span style="font-weight: 700;">{{ $city['percentage'] }}%</span>
                        </div>
                        <div class="city-bar-track">
                            <div class="city-bar-fill" style="width: {{ $city['percentage'] }}%; background-color: {{ $colors[$index] }};"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Customer Insight --}}
            <div class="dashboard-card">
                <h2>Customer Insight</h2>
                <ul class="insight-list">
                    <li>
                        <span class="insight-bullet">1</span>
                        <span>Mayoritas pelanggan berasal dari <strong>Surabaya</strong>.</span>
                    </li>
                    <li>
                        <span class="insight-bullet">2</span>
                        <span><strong>{{ $customerStats['new'] }}</strong> pelanggan baru melakukan pembelian bulan ini.</span>
                    </li>
                    <li>
                        <span class="insight-bullet">3</span>
                        <span><strong>{{ round(($customerStats['returning'] / $customerStats['total']) * 100) }}%</strong> pelanggan merupakan returning customers.</span>
                    </li>
                </ul>
            </div>

            {{-- Quick Actions --}}
            <div class="dashboard-card">
                <h2>Quick Actions</h2>
                <div class="quick-actions">
                    <a href="{{ route('seller.products.create') }}" class="quick-action">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" fill="currentColor"/></svg>
                        Tambah Produk
                    </a>
                    <a href="{{ route('seller.products.index') }}" class="quick-action">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" fill="currentColor"/></svg>
                        Kelola Produk
                    </a>
                    <a href="#recent-orders" class="quick-action" onclick="document.getElementById('recent-orders').scrollIntoView({behavior:'smooth'}); return false;">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" fill="currentColor"/></svg>
                        Lihat Pesanan
                    </a>
                </div>
            </div>

            {{-- Stock Alert --}}
            <div class="dashboard-card">
                <h2>Perlu Perhatian</h2>
                @foreach ($stockAlerts as $alert)
                    <div class="stock-alert">
                        <div class="stock-alert-icon">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 1.125rem; height: 1.125rem;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" fill="currentColor"/></svg>
                        </div>
                        <div class="stock-alert-info">
                            <div class="stock-alert-name">{{ $alert['name'] }}</div>
                            <div class="stock-alert-text">Stock tersisa {{ $alert['stock'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const salesData = @json($salesData);

    function formatRupiah(value) {
        if (value >= 1000000) {
            return 'Rp' + (value / 1000000).toFixed(1) + 'M';
        }
        return 'Rp' + (value / 1000).toFixed(0) + 'K';
    }

    function renderChart(period) {
        const data = salesData[period];
        const container = document.getElementById('salesChart');
        const yAxis = document.getElementById('salesYAxis');
        const grid = document.getElementById('salesGrid');
        const maxValue = Math.max(...data.values);

        container.innerHTML = '';
        yAxis.innerHTML = '';
        grid.innerHTML = '';

        // Y-axis labels and grid lines at 0%, 25%, 50%, 75%, 100%
        const steps = 4;
        for (let i = steps; i >= 0; i--) {
            const percentage = (i / steps) * 100;
            const value = (maxValue * (i / steps));

            const label = document.createElement('span');
            label.textContent = formatRupiah(value);
            yAxis.appendChild(label);

            const line = document.createElement('div');
            line.className = 'grid-line';
            line.style.bottom = percentage + '%';
            grid.appendChild(line);
        }

        data.labels.forEach((label, index) => {
            const value = data.values[index];
            const height = (value / maxValue) * 100;

            const wrapper = document.createElement('div');
            wrapper.className = 'chart-bar-wrapper';
            wrapper.innerHTML = `
                <div class="chart-tooltip">${formatRupiah(value)}</div>
                <div class="chart-bar" style="height: ${height}%;"></div>
                <div class="chart-label">${label}</div>
            `;
            container.appendChild(wrapper);
        });
    }

    document.querySelectorAll('.chart-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.chart-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            renderChart(tab.dataset.period);
        });
    });

    renderChart('7_days');
</script>
@endpush
