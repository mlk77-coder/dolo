@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Order Details" />
    <x-common.component-card>
        <div class="flex justify-between mb-6">
            <h2 class="text-xl font-bold">Order {{ $order->order_number }}</h2>
            <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Back to Orders</a>
        </div>

        <!-- Order Summary -->
        <div class="grid md:grid-cols-3 gap-6 mb-6">
            <div>
                <p class="text-gray-500 text-sm mb-1">Customer</p>
                <p class="font-medium">{{ $order->user->name }}</p>
                <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                @if($order->user->phone)
                    <p class="text-sm text-gray-500">{{ $order->user->phone }}</p>
                @endif
            </div>
            
            <div>
                <p class="text-gray-500 text-sm mb-1">Order Status</p>
                <form action="{{ route('orders.update', $order) }}" method="POST" class="flex gap-2 items-end">
                    @csrf
                    @method('PUT')
                    <select name="status" class="px-4 py-2 border rounded-lg">
                        <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $order->order_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="preparing" {{ $order->order_status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                        <option value="ready" {{ $order->order_status == 'ready' ? 'selected' : '' }}>Ready</option>
                        <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600">Update</button>
                </form>
            </div>

            <div>
                <p class="text-gray-500 text-sm mb-1">Payment Status</p>
                <p class="font-medium capitalize">{{ $order->payment_status }}</p>
                <p class="text-sm text-gray-500 mt-2">Method: {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div>
                <p class="text-gray-500 text-sm mb-1">Order Date</p>
                <p class="font-medium">{{ $order->created_at->format('M d, Y h:i A') }}</p>
            </div>
            
            @if($order->estimated_delivery)
            <div>
                <p class="text-gray-500 text-sm mb-1">Estimated Delivery</p>
                <p class="font-medium">{{ $order->estimated_delivery->format('M d, Y') }}</p>
            </div>
            @endif
        </div>

        @if($order->notes)
        <div class="mb-6">
            <p class="text-gray-500 text-sm mb-1">Notes</p>
            <p class="font-medium">{{ $order->notes }}</p>
        </div>
        @endif

        <!-- Order Items -->
        <h3 class="text-lg font-bold mb-4 mt-8">Order Items</h3>
        <div class="overflow-x-auto">
            <table class="w-full border">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left">Product</th>
                        <th class="px-5 py-3 text-left">Merchant</th>
                        <th class="px-5 py-3 text-center">Quantity</th>
                        <th class="px-5 py-3 text-right">Unit Price</th>
                        <th class="px-5 py-3 text-right">Discount</th>
                        <th class="px-5 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                @php
                                    $dealImage = null;
                                    if($order->deal) {
                                        // Try to get primary image first
                                        $dealImage = $order->deal->primaryImage;
                                        // If no primary image, get first image
                                        if(!$dealImage && $order->deal->images && $order->deal->images->count() > 0) {
                                            $dealImage = $order->deal->images->first();
                                        }
                                    }
                                @endphp
                                
                                @if($dealImage)
                                    <img src="{{ asset('storage/' . $dealImage->image_url) }}" 
                                         alt="{{ $order->deal->title_en ?? $order->deal->title_ar ?? 'Deal' }}" 
                                         class="w-16 h-16 object-cover rounded border"
                                         onerror="this.src='{{ asset('images/placeholder.png') }}'; this.onerror=null;">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium">{{ $order->deal->title_en ?? $order->deal->title_ar ?? 'N/A' }}</p>
                                    @if($order->deal && $order->deal->description)
                                        <p class="text-sm text-gray-500">{{ Str::limit($order->deal->description, 50) }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            {{ $order->deal->merchant->business_name ?? $order->deal->merchant->name ?? 'N/A' }}
                        </td>
                        <td class="px-5 py-4 text-center">
                            {{ $order->quantity }}
                        </td>
                        <td class="px-5 py-4 text-right">
                            ${{ number_format($order->unit_price, 2) }}
                        </td>
                        <td class="px-5 py-4 text-right">
                            ${{ number_format($order->discount_amount, 2) }}
                        </td>
                        <td class="px-5 py-4 text-right font-medium">
                            ${{ number_format($order->final_price, 2) }}
                        </td>
                    </tr>
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="5" class="px-5 py-3 text-right font-bold">Total:</td>
                        <td class="px-5 py-3 text-right font-bold text-lg">${{ number_format($order->final_price, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Status History -->
        @if($order->statusHistory && $order->statusHistory->count() > 0)
        <h3 class="text-lg font-bold mb-4 mt-8">Status History</h3>
        <div class="border rounded-lg">
            @foreach($order->statusHistory as $history)
                <div class="px-5 py-3 border-b last:border-b-0 flex justify-between items-center">
                    <div>
                        <p class="font-medium capitalize">{{ str_replace('_', ' ', $history->status) }}</p>
                        @if($history->note)
                            <p class="text-sm text-gray-500">{{ $history->note }}</p>
                        @endif
                    </div>
                    <p class="text-sm text-gray-500">{{ $history->created_at->format('M d, Y h:i A') }}</p>
                </div>
            @endforeach
        </div>
        @endif

        @if($order->cancelled_at)
        <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <p class="font-medium text-red-800">Order Cancelled</p>
            <p class="text-sm text-red-600 mt-1">Date: {{ $order->cancelled_at->format('M d, Y h:i A') }}</p>
            @if($order->cancellation_reason)
                <p class="text-sm text-red-600 mt-1">Reason: {{ $order->cancellation_reason }}</p>
            @endif
        </div>
        @endif
    </x-common.component-card>
@endsection
