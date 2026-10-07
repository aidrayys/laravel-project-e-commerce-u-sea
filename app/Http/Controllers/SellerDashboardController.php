<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class SellerDashboardController extends Controller
{
    public function index(): View
    {
        $summary = [
            'total_sales' => 12850000,
            'sales_growth' => 12.5,
            'total_orders' => 186,
            'orders_growth' => 8.3,
            'total_products' => 5,
            'new_products' => 1,
            'average_order_value' => 69086,
            'aov_growth' => 4.2,
        ];

        $salesData = [
            '7_days' => [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'values' => [1200000, 1500000, 1100000, 1800000, 2000000, 2400000, 2800000],
            ],
            '4_weeks' => [
                'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                'values' => [11500000, 6200000, 10100000, 12850000],
            ],
            '6_months' => [
                'labels' => ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                'values' => [10500000, 4200000, 7800000, 12100000, 6500000, 12850000],
            ],
        ];

        $topProducts = [
            ['name' => 'Fresh Snapper', 'sold' => 32, 'revenue' => 2240000],
            ['name' => 'Fresh Squid', 'sold' => 27, 'revenue' => 2025000],
            ['name' => 'Spicy Squid Sambal', 'sold' => 24, 'revenue' => 840000],
            ['name' => 'Fresh Tuna', 'sold' => 21, 'revenue' => 1785000],
        ];

        $customerCities = [
            ['city' => 'Surabaya', 'percentage' => 42],
            ['city' => 'Lamongan', 'percentage' => 24],
            ['city' => 'Gresik', 'percentage' => 15],
            ['city' => 'Sidoarjo', 'percentage' => 11],
            ['city' => 'Other', 'percentage' => 8],
        ];

        $customerStats = [
            'total' => 128,
            'new' => 34,
            'returning' => 94,
        ];

        $recentOrders = [
            ['order' => '#USEA001', 'customer' => 'Caca Sea', 'city' => 'Surabaya', 'product' => 'Fresh Snapper', 'total' => 140000, 'status' => 'Completed'],
            ['order' => '#USEA002', 'customer' => 'Budi Nelayan', 'city' => 'Lamongan', 'product' => 'Fresh Squid', 'total' => 150000, 'status' => 'Processing'],
            ['order' => '#USEA003', 'customer' => 'Dewi Ocean', 'city' => 'Gresik', 'product' => 'Spicy Squid Sambal', 'total' => 70000, 'status' => 'Pending Payment'],
            ['order' => '#USEA004', 'customer' => 'Rina Pesisir', 'city' => 'Surabaya', 'product' => 'Fresh Tuna', 'total' => 170000, 'status' => 'Completed'],
            ['order' => '#USEA005', 'customer' => 'Ari Bahari', 'city' => 'Sidoarjo', 'product' => 'Fresh Snapper', 'total' => 140000, 'status' => 'Completed'],
        ];

        $stockAlerts = [
            ['name' => 'Fresh Squid', 'stock' => 4],
            ['name' => 'Spicy Squid Sambal', 'stock' => 6],
        ];

        return view('seller.dashboard', compact(
            'summary',
            'salesData',
            'topProducts',
            'customerCities',
            'customerStats',
            'recentOrders',
            'stockAlerts'
        ));
    }
}
