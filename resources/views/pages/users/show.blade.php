@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="User Details" />
    <x-common.component-card>
        <div class="flex justify-between mb-6"><h2 class="text-xl font-bold">{{ $user->name }}</h2><a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg">Back</a></div>
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div><p class="text-gray-500 text-sm">Email</p><p class="font-medium">{{ $user->email }}</p></div>
            <div><p class="text-gray-500 text-sm">Role</p><p class="font-medium">{{ ucfirst($user->role) }}</p></div>
            <div><p class="text-gray-500 text-sm">Total Orders</p><p class="font-medium">{{ $user->orders->count() }}</p></div>
            <div><p class="text-gray-500 text-sm">Registered</p><p class="font-medium">{{ $user->created_at->format('M d, Y') }}</p></div>
        </div>
        <h3 class="text-lg font-bold mb-4">Orders</h3>
        @if($user->orders->count() > 0)
            <table class="w-full border"><thead class="bg-gray-50"><tr><th class="px-5 py-3 text-left">Order #</th><th class="px-5 py-3 text-left">Total</th><th class="px-5 py-3 text-left">Status</th><th class="px-5 py-3 text-left">Date</th></tr></thead><tbody>@foreach($user->orders as $order)<tr class="border-b"><td class="px-5 py-4"><a href="{{ route('orders.show', $order) }}" class="text-brand-500">{{ $order->order_number }}</a></td><td class="px-5 py-4">${{ number_format($order->total, 2) }}</td><td class="px-5 py-4"><span class="px-2 py-1 rounded text-xs">{{ ucfirst($order->status) }}</span></td><td class="px-5 py-4">{{ $order->created_at->format('M d, Y') }}</td></tr>@endforeach</tbody></table>
        @else
            <p class="text-gray-500 text-center py-8">No orders found</p>
        @endif
    </x-common.component-card>
@endsection
