<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display a simple admin dashboard.
     */
    public function index(): View
    {
        $stats = [
            'users' => User::count(),
            'products' => Product::count(),
            'categories' => Category::count(),
            'orders' => Order::count(),
            'total_sales' => Order::sum('total') ?? 0,
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
