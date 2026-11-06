<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class SellerDashboardController extends Controller
{
    public function index(): View
    {
        $sellerName = (string) session('seller_name', 'Pesisir Rasa');
        $clickColumn = Schema::hasColumn('products', 'click') ? 'click' : 'clicks';

        $sellerProductsQuery = Product::query()->where('seller_name', $sellerName);

        // Required dashboard stats (actual database, scoped to seller when ownership is supported).
        $totalProducts = (clone $sellerProductsQuery)->count();
        $totalProductClicks = (int) ((clone $sellerProductsQuery)->sum($clickColumn) ?? 0);
        $totalCategories = (int) ((clone $sellerProductsQuery)
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->count('category'));

        // Existing marketplace KPIs kept intact.
        $totalOrders = Order::count();
        $totalSales = (int) (Order::sum('total') ?? 0);
        $averageOrderValue = (int) (Order::avg('total') ?? 0);

        // Products with clicks detail (seller's products).
        $clickedProducts = (clone $sellerProductsQuery)
            ->where($clickColumn, '>', 0)
            ->orderByDesc($clickColumn)
            ->limit(50)
            ->get(['id', 'name', 'category', $clickColumn, 'image'])
            ->map(function ($product) use ($clickColumn) {
                $data = $product->toArray();
                $data['click'] = (int) ($data[$clickColumn] ?? 0);
                $data['clicks'] = $data['click'];

                return $data;
            })
            ->toArray();

        // Recent orders for modal
        $recentOrdersList = Order::with('orderItems.product')
            ->latest()
            ->limit(50)
            ->get()
            ->map(function ($order) {
                $firstItem = $order->orderItems->first();

                return [
                    'order' => $order->order_number,
                    'customer' => $order->customer_name,
                    'city' => $this->guessCity($order->address),
                    'product' => $firstItem?->product_name ?? '-',
                    'total' => $order->total,
                    'status' => $order->status,
                    'date' => $order->created_at->format('d M Y H:i'),
                ];
            })
            ->toArray();

        // Sales performance for the last 7 days
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        $orderTotalsByDay = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total) as total')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $labels = [];
        $values = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($date)->format('D');
            $values[] = (int) ($orderTotalsByDay[$date] ?? 0);
        }

        $salesData = [
            '7_days' => [
                'labels' => $labels,
                'values' => $values,
            ],
        ];

        // Top products by sold quantity
        $topProducts = OrderItem::select(
            'product_name',
            DB::raw('SUM(quantity) as sold'),
            DB::raw('SUM(subtotal) as revenue')
        )
            ->groupBy('product_name')
            ->orderByDesc('sold')
            ->limit(5)
            ->get()
            ->map(fn ($item) => [
                'name' => $item->product_name,
                'sold' => (int) $item->sold,
                'revenue' => (int) $item->revenue,
            ])
            ->toArray();

        // Recent orders table
        $recentOrders = Order::with('orderItems.product')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($order) {
                $firstItem = $order->orderItems->first();

                return [
                    'order' => $order->order_number,
                    'customer' => $order->customer_name,
                    'city' => $this->guessCity($order->address),
                    'product' => $firstItem?->product_name ?? '-',
                    'total' => $order->total,
                    'status' => $order->status,
                ];
            })
            ->toArray();

        // Stock alerts: products with low stock (seller's products).
        $stockAlerts = (clone $sellerProductsQuery)
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->limit(5)
            ->get()
            ->map(fn ($product) => [
                'name' => $product->name,
                'stock' => $product->stock,
            ])
            ->toArray();

        $summary = [
            'total_products' => $totalProducts,
            'total_product_clicks' => $totalProductClicks,
            'total_categories' => $totalCategories,
            'total_sales' => $totalSales,
            'total_orders' => $totalOrders,
            'average_order_value' => $averageOrderValue,
        ];

        // Placeholder analytics; city-level segmentation is not modelled
        $customerCities = [
            ['city' => 'Surabaya', 'percentage' => 42],
            ['city' => 'Lamongan', 'percentage' => 24],
            ['city' => 'Gresik', 'percentage' => 15],
            ['city' => 'Sidoarjo', 'percentage' => 11],
            ['city' => 'Other', 'percentage' => 8],
        ];

        $customerStats = [
            'total' => Order::distinct('customer_name')->count('customer_name'),
            'new' => 0,
            'returning' => 0,
        ];

        return view('seller.dashboard', compact(
            'summary',
            'clickedProducts',
            'recentOrdersList',
            'salesData',
            'topProducts',
            'customerCities',
            'customerStats',
            'recentOrders',
            'stockAlerts'
        ));
    }

    /**
     * Best-effort city extraction from a free-text address.
     * This is intentionally simple because the address is stored as plain text.
     */
    private function guessCity(?string $address): string
    {
        if (empty($address)) {
            return 'Unknown';
        }

        $cities = ['Surabaya', 'Lamongan', 'Gresik', 'Sidoarjo', 'Madura', 'Pasuruan'];
        $lowerAddress = strtolower($address);
        foreach ($cities as $city) {
            if (str_contains($lowerAddress, strtolower($city))) {
                return $city;
            }
        }

        return 'Other';
    }
}
