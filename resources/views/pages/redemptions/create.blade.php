@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Create Redemption" />
    <div class="space-y-6">
        <x-common.component-card title="Create New Redemption">
            <form action="{{ route('redemptions.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Order *</label>
                        <select name="order_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="">Select Order</option>
                            @foreach($orders as $order)
                                <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                    {{ $order->order_number }} - {{ $order->user->name }} (${{ number_format($order->total_price, 2) }})
                                </option>
                            @endforeach
                        </select>
                        @error('order_id')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Customer *</label>
                        <select name="user_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('user_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Merchant</label>
                        <select name="merchant_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="">Select Merchant</option>
                            @foreach(\App\Models\Merchant::all() as $merchant)
                                <option value="{{ $merchant->id }}" {{ old('merchant_id') == $merchant->id ? 'selected' : '' }}>
                                    {{ $merchant->business_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('merchant_id')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Status *</label>
                        <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Redeemed At</label>
                        <input type="datetime-local" name="redeemed_at" value="{{ old('redeemed_at') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('redeemed_at')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Redeemed By</label>
                        <input type="text" name="redeemed_by" value="{{ old('redeemed_by') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Name of person who redeemed">
                        @error('redeemed_by')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-theme-sm font-medium mb-2">Notes</label>
                    <textarea name="notes" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="px-6 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition">
                        Create Redemption
                    </button>
                    <a href="{{ route('redemptions.index') }}" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Cancel
                    </a>
                </div>
            </form>
        </x-common.component-card>
    </div>
@endsection

