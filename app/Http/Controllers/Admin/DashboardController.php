<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products_count' => Product::count(),
            'categories_count' => Category::count(),
            'orders_count' => Order::count(),
            'revenue_this_month' => Order::whereMonth('created_at', Carbon::now()->month)
                                        ->whereYear('created_at', Carbon::now()->year)
                                        ->sum('total_price'),
            'orders_this_month' => Order::whereMonth('created_at', Carbon::now()->month)
                                        ->whereYear('created_at', Carbon::now()->year)
                                        ->count(),
        ];

        $recent_orders = Order::latest()->take(5)->get();

        $top_products = OrderItem::select('product_id', 'product_name', DB::raw('SUM(quantity) as total_sold'))
                                ->groupBy('product_id', 'product_name')
                                ->orderByDesc('total_sold')
                                ->take(5)
                                ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'top_products'));
    }
}
