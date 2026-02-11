@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Orders" />
    <x-common.component-card>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">All Orders</h2>
            <a href="{{ route('orders.export-csv', request()->all()) }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export CSV
            </a>
        </div>
        <form method="GET" class="mb-6 flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by order number or customer..." class="px-4 py-2 border rounded-lg flex-1">
            <select name="status" class="px-4 py-2 border rounded-lg">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>Preparing</option>
                <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Ready</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900">Filter</button>
        </form>
        <div class="overflow-x-auto">
            <table class="w-full border">
                <thead class="bg-gray-50"><tr><th class="px-5 py-3 text-left">Order #</th><th class="px-5 py-3 text-left">Customer</th><th class="px-5 py-3 text-left">Total</th><th class="px-5 py-3 text-left">Status</th><th class="px-5 py-3 text-left">Date</th><th class="px-5 py-3 text-left">Actions</th></tr></thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-5 py-4">
                                <a href="{{ route('orders.show', $order) }}" class="text-brand-500 hover:text-brand-600 font-medium">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td class="px-5 py-4">
                                <div>
                                    <p class="font-medium">{{ $order->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 font-medium">
                                ${{ number_format($order->final_price ?? $order->total_price ?? $order->total ?? 0, 2) }}
                            </td>
                            <td class="px-5 py-4">
                                @php
                                    $status = $order->order_status ?? $order->status;
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'confirmed' => 'bg-blue-100 text-blue-700',
                                        'preparing' => 'bg-purple-100 text-purple-700',
                                        'ready' => 'bg-indigo-100 text-indigo-700',
                                        'delivered' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                    ];
                                    $colorClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $colorClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-5 py-4">
                                <a href="{{ route('orders.show', $order) }}" class="text-blue-500 hover:text-blue-700 hover:underline">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-8 text-center text-gray-500">No orders found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $orders->links() }}</div>
    </x-common.component-card>
@endsection
