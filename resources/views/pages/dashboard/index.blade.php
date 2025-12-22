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
                        <p class="text-gray-500 text-theme-sm">{{ __('dashboard.total_products') }}</p>
                        <h3 class="text-gray-800 text-2xl font-bold">{{ number_format($stats['total_products']) }}</h3>
                        <p class="text-gray-500 text-theme-xs mt-1">{{ $stats['active_products'] }} {{ __('common.active') }}</p>
                    </div>
                    <div class="p-3 bg-brand-100 rounded-lg">
                        <svg class="w-8 h-8 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </x-common.component-card>
        </div>

        <div class="col-span-12 md:col-span-6 lg:col-span-3">
            <x-common.component-card>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-theme-sm">{{ __('dashboard.total_categories') }}</p>
                        <h3 class="text-gray-800 text-2xl font-bold">{{ number_format($stats['total_categories']) }}</h3>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

        <!-- Recent Orders -->
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
                                            <p class="text-gray-800 text-theme-sm font-medium">${{ number_format($order->total, 2) }}</p>
                                        </td>
                                        <td class="px-5 py-4 sm:px-6">
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-yellow-50 text-yellow-700',
                                                    'processing' => 'bg-blue-50 text-blue-700',
                                                    'completed' => 'bg-green-50 text-green-700',
                                                    'canceled' => 'bg-red-50 text-red-700',
                                                ];
                                            @endphp
                                            <span class="text-theme-xs inline-block rounded-full px-2 py-0.5 font-medium {{ $statusClasses[$order->status] ?? '' }}">
                                                {{ ucfirst($order->status) }}
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

        <!-- Active Deals & Top Products -->
        <div class="col-span-12 lg:col-span-4 space-y-6">
            <x-common.component-card title="{{ __('dashboard.active_discounts') }}">
                <div class="text-center py-8">
                    <div class="text-4xl font-bold text-gray-800 mb-2">{{ $stats['active_discounts'] }}</div>
                    <p class="text-gray-500 text-theme-sm">{{ __('dashboard.active_discounts') }}</p>
                    <a href="{{ route('deals.index') }}" class="mt-4 inline-block text-brand-500 hover:underline text-theme-sm font-medium">
                        View all deals →
                    </a>
                </div>
            </x-common.component-card>

            <x-common.component-card title="{{ __('dashboard.top_products') }}">
                <div class="space-y-4">
                    @forelse($topProducts as $product)
                        <div class="flex items-center gap-3 pb-4 border-b border-gray-100 last:border-0">
                            <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-800 text-theme-sm font-medium">{{ $product->name }}</p>
                                <p class="text-gray-500 text-theme-xs">{{ $product->orderItems()->count() }} orders</p>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-800 text-theme-sm font-bold">${{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No products found</p>
                    @endforelse
                </div>
            </x-common.component-card>
        </div>
    </div>
@endsection
