@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Order Details" />
    <x-common.component-card>
        <div class="flex justify-between mb-6"><h2 class="text-xl font-bold">Order {{ $order->order_number }}</h2><a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg">Back</a></div>
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div><p class="text-gray-500 text-sm">Customer</p><p class="font-medium">{{ $order->user->name }}</p><p class="text-sm text-gray-500">{{ $order->user->email }}</p></div>
            <div><p class="text-gray-500 text-sm">Status</p><form action="{{ route('orders.update', $order) }}" method="POST" class="flex gap-2 items-end"><select name="status" class="px-4 py-2 border rounded-lg">@foreach(['pending','processing','completed','canceled'] as $s)<option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>@endforeach</select>@csrf @method('PUT')<button type="submit" class="px-4 py-2 bg-brand-500 text-white rounded-lg">Update</button></form></div>
            <div><p class="text-gray-500 text-sm">Discount Code</p><p class="font-medium">{{ $order->discount_code ?? 'None' }}</p></div>
            <div><p class="text-gray-500 text-sm">Total</p><p class="text-2xl font-bold">${{ number_format($order->total, 2) }}</p></div>
        </div>
        <h3 class="text-lg font-bold mb-4">Order Items</h3>
        <table class="w-full border">
            <thead class="bg-gray-50"><tr><th class="px-5 py-3 text-left">Product</th><th class="px-5 py-3 text-left">Quantity</th><th class="px-5 py-3 text-left">Price</th><th class="px-5 py-3 text-left">Subtotal</th></tr></thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr class="border-b"><td class="px-5 py-4">{{ $item->product->name }}</td><td class="px-5 py-4">{{ $item->quantity }}</td><td class="px-5 py-4">${{ number_format($item->price, 2) }}</td><td class="px-5 py-4">${{ number_format($item->subtotal, 2) }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </x-common.component-card>
@endsection
