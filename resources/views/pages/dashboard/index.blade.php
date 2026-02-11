@extends('layouts.admin')
@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <x-common.page-breadcrumb pageTitle="{{ __('dashboard.title') }}" />

    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <!-- Stats Cards -->
        <div class="col-span-12 md:col-span-6 lg:col-span-3">
            <x-common.component-card>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-theme-sm">{{ __('dashboard.total_deals') }}</p>
                        <h3 class="text-gray-800 text-2xl font-bold">{{ number_format($stats['total_deals']) }}</h3>
                        <p class="text-gray-500 text-theme-xs mt-1">{{ $stats['active_deals'] }} {{ __('common.active') }}</p>
                    </div>
                    <div class="p-3 bg-brand-100 rounded-lg">
                        <svg class="w-8 h-8 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                </div>
            </x-common.component-card>
        </div>

        <div class="col-span-12 md:col-span-6 lg:col-span-3">
            <x-common.component-card>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-theme-sm">{{ __('dashboard.total_merchants') }}</p>
                        <h3 class="text-gray-800 text-2xl font-bold">{{ number_format($stats['total_merchants']) }}</h3>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </x-common.component-card>
        </div>

        <div class="col-span-12 md:col-span-6 lg:col-span-3">
            <x-common.component-card>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-theme-sm">{{ __('dashboard.total_orders') }}</p>
                        <h3 class="text-gray-800 text-2xl font-bold">{{ number_format($stats['total_orders']) }}</h3>
                        <p class="text-gray-500 text-theme-xs mt-1">{{ $stats['pending_orders'] }} {{ __('common.pending') }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </x-common.component-card>
        </div>

        <div class="col-span-12 md:col-span-6 lg:col-span-3">
            <x-common.component-card>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-theme-sm">{{ __('dashboard.total_revenue') }}</p>
                        <h3 class="text-gray-800 text-2xl font-bold">${{ number_format($stats['total_revenue'], 2) }}</h3>
                        <p class="text-gray-500 text-theme-xs mt-1">{{ $stats['completed_orders'] }} {{ __('common.completed') }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </x-common.component-card>
        </div>

        <!-- Recent Orders & Top Selling Deals Row -->
        <div class="col-span-12 lg:col-span-8">
            <x-common.component-card title="{{ __('dashboard.recent_orders') }}">
                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
                    <div class="max-w-full overflow-x-auto custom-scrollbar">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs">Order #</p>
                                    </th>
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs">Customer</p>
                                    </th>
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs">Total</p>
                                    </th>
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs">Status</p>
                                    </th>
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="font-medium text-gray-500 text-theme-xs">Date</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                    <tr class="border-b border-gray-100">
                                        <td class="px-5 py-4 sm:px-6">
                                            <a href="{{ route('orders.show', $order) }}" class="text-brand-500 hover:underline font-medium">
                                                {{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            <p class="text-gray-800 text-theme-sm">{{ $order->user->name }}</p>
                                            <p class="text-gray-500 text-theme-xs">{{ $order->user->email }}</p>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            <p class="text-gray-800 text-theme-sm font-medium">${{ number_format($order->final_price ?? $order->total_price ?? $order->total ?? 0, 2) }}</p>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            @php
                                                $status = $order->order_status ?? $order->status;
                                                $statusClasses = [
                                                    'pending' => 'bg-yellow-50 text-yellow-700',
                                                    'confirmed' => 'bg-blue-50 text-blue-700',
                                                    'preparing' => 'bg-purple-50 text-purple-700',
                                                    'ready' => 'bg-indigo-50 text-indigo-700',
                                                    'delivered' => 'bg-green-50 text-green-700',
                                                    'cancelled' => 'bg-red-50 text-red-700',
                                                ];
                                            @endphp
                                            <span class="text-theme-xs inline-block rounded-full px-2 py-0.5 font-medium {{ $statusClasses[$status] ?? 'bg-gray-50 text-gray-700' }}">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            <p class="text-gray-500 text-theme-sm">{{ $order->created_at->format('M d, Y') }}</p>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-8 text-center text-gray-500">No orders found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-common.component-card>
        </div>

        <!-- Top Selling Deals -->
        <div class="col-span-12 lg:col-span-4">
            <x-common.component-card title="{{ __('dashboard.top_deals') }}">
                <div class="space-y-4">
                    @forelse($topDeals as $deal)
                        <div class="flex items-center gap-3 pb-4 border-b border-gray-100 last:border-0">
                            <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                @php
                                    $dealImage = $deal->primaryImage ?? $deal->images->first();
                                @endphp
                                @if($dealImage)
                                    <img src="{{ asset('storage/' . $dealImage->image_url) }}" 
                                         alt="{{ $deal->title_en ?? $deal->title_ar }}" 
                                         class="w-full h-full object-cover"
                                         onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center text-gray-400\'><svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg></div>';">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-gray-800 text-theme-sm font-medium truncate">{{ $deal->title_en ?? $deal->title_ar }}</p>
                                <p class="text-gray-500 text-theme-xs">{{ $deal->orders_count }} {{ $deal->orders_count == 1 ? 'order' : 'orders' }}</p>
                                @if($deal->merchant)
                                    <p class="text-gray-400 text-theme-xs truncate">{{ $deal->merchant->business_name }}</p>
                                @endif
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-gray-800 text-theme-sm font-bold">${{ number_format($deal->discounted_price, 2) }}</p>
                                @if($deal->discount_percentage > 0)
                                    <p class="text-green-600 text-theme-xs">-{{ number_format($deal->discount_percentage) }}%</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <p class="text-gray-500 text-theme-sm">No deals with orders yet</p>
                            <a href="{{ route('deals.create') }}" class="mt-3 inline-block text-brand-500 hover:underline text-theme-sm font-medium">
                                Create your first deal →
                            </a>
                        </div>
                    @endforelse
                </div>
            </x-common.component-card>
        </div>

        <!-- Charts Section -->
        <div class="col-span-12 space-y-6">
            <!-- Revenue Chart -->
            <x-common.component-card title="Revenue Last 7 Days">
                <canvas id="revenueChart" height="80"></canvas>
            </x-common.component-card>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Orders Chart -->
                <x-common.component-card title="Orders Last 7 Days">
                    <canvas id="ordersChart" height="120"></canvas>
                </x-common.component-card>

                <!-- Orders by Status Chart -->
                <x-common.component-card title="Orders by Status">
                    <canvas id="statusChart" height="120"></canvas>
                </x-common.component-card>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: @json(array_column($revenueLast7Days, 'date')),
                datasets: [{
                    label: 'Revenue ($)',
                    data: @json(array_column($revenueLast7Days, 'revenue')),
                    borderColor: '#4F46E5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#4F46E5',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Revenue: $' + context.parsed.y.toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        });

        // Orders Chart
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: @json(array_column($ordersLast7Days, 'date')),
                datasets: [{
                    label: 'Orders',
                    data: @json(array_column($ordersLast7Days, 'count')),
                    backgroundColor: '#10B981',
                    borderRadius: 6,
                    barThickness: 30,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Confirmed', 'Preparing', 'Ready', 'Delivered', 'Cancelled'],
                datasets: [{
                    data: [
                        {{ $ordersByStatus['pending'] }},
                        {{ $ordersByStatus['confirmed'] }},
                        {{ $ordersByStatus['preparing'] }},
                        {{ $ordersByStatus['ready'] }},
                        {{ $ordersByStatus['delivered'] }},
                        {{ $ordersByStatus['cancelled'] }}
                    ],
                    backgroundColor: [
                        '#F59E0B', // Yellow - Pending
                        '#3B82F6', // Blue - Confirmed
                        '#8B5CF6', // Purple - Preparing
                        '#6366F1', // Indigo - Ready
                        '#10B981', // Green - Delivered
                        '#EF4444'  // Red - Cancelled
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                }
            }
        });
    </script>
@endsection
