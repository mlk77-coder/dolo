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
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="px-4 py-2 border rounded-lg">
            <select name="status" class="px-4 py-2 border rounded-lg">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
            </select>
            <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg">Filter</button>
        </form>
        <div class="overflow-x-auto">
            <table class="w-full border">
                <thead class="bg-gray-50"><tr><th class="px-5 py-3 text-left">Order #</th><th class="px-5 py-3 text-left">Customer</th><th class="px-5 py-3 text-left">Total</th><th class="px-5 py-3 text-left">Status</th><th class="px-5 py-3 text-left">Date</th><th class="px-5 py-3 text-left">Actions</th></tr></thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-b"><td class="px-5 py-4"><a href="{{ route('orders.show', $order) }}" class="text-brand-500">{{ $order->order_number }}</a></td><td class="px-5 py-4">{{ $order->user->name }}</td><td class="px-5 py-4">${{ number_format($order->total, 2) }}</td><td class="px-5 py-4"><span class="px-2 py-1 rounded text-xs {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100') }}">{{ ucfirst($order->status) }}</span></td><td class="px-5 py-4">{{ $order->created_at->format('M d, Y') }}</td><td class="px-5 py-4"><a href="{{ route('orders.show', $order) }}" class="text-blue-500">View</a></td></tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-8 text-center">No orders found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $orders->links() }}</div>
    </x-common.component-card>
@endsection
