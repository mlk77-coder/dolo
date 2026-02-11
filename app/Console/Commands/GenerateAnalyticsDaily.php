<?php

namespace App\Console\Commands;

use App\Models\AnalyticsDaily;
use App\Models\Customer;
use App\Models\Order;
use App\Models\DealView;
use Illuminate\Console\Command;
use Carbon\Carbon;

class GenerateAnalyticsDaily extends Command
{
    protected $signature = 'analytics:generate {--days=30 : Number of days to generate analytics for}';
    protected $description = 'Generate daily analytics data from existing orders and users';

    public function handle()
    {
        $days = (int) $this->option('days');
        $this->info("Generating analytics for the last {$days} days...");

        $startDate = Carbon::now()->subDays($days);
        $endDate = Carbon::now();

        $progressBar = $this->output->createProgressBar($days);
        $progressBar->start();

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $this->generateForDate($date->toDateString());
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();
        $this->info('Analytics generated successfully!');

        return 0;
    }

    private function generateForDate(string $date)
    {
        $carbonDate = Carbon::parse($date);
        
        // Count total users up to this date
        $totalUsers = Customer::where('created_at', '<=', $carbonDate->endOfDay())->count();
        
        // Count new users on this date
        $newUsers = Customer::whereDate('created_at', $carbonDate)->count();
        
        // Count orders on this date
        $totalOrders = Order::whereDate('created_at', $carbonDate)->count();
        
        // Calculate revenue from delivered/ready orders on this date
        $totalRevenue = Order::whereDate('created_at', $carbonDate)
            ->whereIn('order_status', ['delivered', 'ready'])
            ->sum('final_price');
        
        // Count deal views on this date (if deal_views table has data)
        $totalDealViews = DealView::whereDate('created_at', $carbonDate)->count();
        
        // Estimate page views (orders * 5 as rough estimate)
        $totalPageViews = $totalOrders * 5;
        
        // Estimate sessions (unique users who placed orders + new users)
        $totalSessions = Order::whereDate('created_at', $carbonDate)
            ->distinct('user_id')
            ->count() + $newUsers;
        
        // Create or update analytics record
        AnalyticsDaily::updateOrCreate(
            ['date' => $date],
            [
                'total_users' => $totalUsers,
                'new_users' => $newUsers,
                'total_orders' => $totalOrders,
                'total_revenue' => $totalRevenue,
                'total_deal_views' => $totalDealViews,
                'total_deal_clicks' => $totalOrders, // Orders are essentially deal clicks
                'total_page_views' => $totalPageViews,
                'total_sessions' => $totalSessions,
                'average_session_duration' => 0, // Would need tracking implementation
                'additional_metrics' => [
                    'pending_orders' => Order::whereDate('created_at', $carbonDate)
                        ->where('order_status', 'pending')
                        ->count(),
                    'cancelled_orders' => Order::whereDate('created_at', $carbonDate)
                        ->where('order_status', 'cancelled')
                        ->count(),
                ],
            ]
        );
    }
}
