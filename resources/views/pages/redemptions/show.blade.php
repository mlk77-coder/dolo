@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Redemption Details" />
    <div class="space-y-6">
        <x-common.component-card>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold">Redemption Details</h2>
                <div class="flex gap-2">
                    <a href="{{ route('redemptions.edit', $redemption) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                        Edit
                    </a>
                    <a href="{{ route('redemptions.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Back
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2">Order Information</h3>
                    <p class="text-gray-600"><span class="font-medium">Order Number:</span> {{ $redemption->order->order_number ?? 'N/A' }}</p>
                    <p class="text-gray-600"><span class="font-medium">Total:</span> ${{ number_format($redemption->order->total_price ?? 0, 2) }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2">User Information</h3>
                    <p class="text-gray-600"><span class="font-medium">Name:</span> {{ $redemption->user->name ?? 'N/A' }}</p>
                    <p class="text-gray-600"><span class="font-medium">Email:</span> {{ $redemption->user->email ?? 'N/A' }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2">Merchant Information</h3>
                    <p class="text-gray-600"><span class="font-medium">Business:</span> {{ $redemption->merchant->business_name ?? 'N/A' }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2">Redemption Details</h3>
                    <p class="text-gray-600"><span class="font-medium">Status:</span> 
                        <span class="px-2 py-1 rounded text-xs {{ $redemption->status == 'completed' ? 'bg-green-100 text-green-700' : ($redemption->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($redemption->status) }}
                        </span>
                    </p>
                    <p class="text-gray-600"><span class="font-medium">Redeemed At:</span> {{ $redemption->redeemed_at ? $redemption->redeemed_at->format('M d, Y H:i') : 'Not redeemed yet' }}</p>
                    <p class="text-gray-600"><span class="font-medium">Redeemed By:</span> {{ $redemption->redeemed_by ?? 'N/A' }}</p>
                </div>
            </div>

            @if($redemption->notes)
                <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2">Notes</h3>
                    <p class="text-gray-600">{{ $redemption->notes }}</p>
                </div>
            @endif
        </x-common.component-card>
    </div>
@endsection

