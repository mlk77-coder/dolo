<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Deal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_deals' => Deal::count(),
            'active_deals' => Deal::where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->where('status', 'active')
                ->count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'completed_orders' => Order::where('order_status', 'delivered')->count(),
            'total_revenue' => Order::whereIn('order_status', ['delivered', 'ready'])->sum('final_price'),
            'total_merchants' => \App\Models\Merchant::count(),
        ];

        // Recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(10)
            ->get();

        // Top selling deals (by order count)
        $topDeals = Deal::withCount('orders')
            ->with(['primaryImage', 'merchant'])
            ->orderBy('orders_count', 'desc')
            ->limit(5)
            ->get();

        // Chart Data: Orders by Status
        $ordersByStatus = [
            'pending' => Order::where('order_status', 'pending')->count(),
            'confirmed' => Order::where('order_status', 'confirmed')->count(),
            'preparing' => Order::where('order_status', 'preparing')->count(),
            'ready' => Order::where('order_status', 'ready')->count(),
            'delivered' => Order::where('order_status', 'delivered')->count(),
            'cancelled' => Order::where('order_status', 'cancelled')->count(),
        ];

        // Chart Data: Revenue Last 7 Days
        $revenueLast7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $revenue = Order::whereDate('created_at', $date)
                ->whereIn('order_status', ['delivered', 'ready'])
                ->sum('final_price');
            $revenueLast7Days[] = [
                'date' => now()->subDays($i)->format('M d'),
                'revenue' => (float) $revenue,
            ];
        }

        // Chart Data: Orders Last 7 Days
        $ordersLast7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $count = Order::whereDate('created_at', $date)->count();
            $ordersLast7Days[] = [
                'date' => now()->subDays($i)->format('M d'),
                'count' => $count,
            ];
        }

        return view('pages.dashboard.index', compact(
            'stats', 
            'recentOrders', 
            'topDeals',
            'ordersByStatus',
            'revenueLast7Days',
            'ordersLast7Days'
        ));
    }
}
