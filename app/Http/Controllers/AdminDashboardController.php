<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard with marketplace statistics from the database.
     */
    public function index(): View
    {
        $clickColumn = Schema::hasColumn('products', 'click') ? 'click' : 'clicks';

        $stats = [
            'users' => User::count(),
            'products' => Product::count(),
            'categories' => Category::count(),
            'product_clicks' => (int) (Product::sum($clickColumn) ?? 0),
            'orders' => Order::count(),
            'total_sales' => (int) (Order::sum('total') ?? 0),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
