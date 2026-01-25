@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Create Code" />
    <x-common.component-card title="Create Discount Code">
        <form action="{{ route('codes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-gray-700 font-medium mb-2">Subject *</label>
                <input type="text" name="subject" value="{{ old('subject') }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500" placeholder="e.g., Summer Sale 2024">
                @error('subject')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Code *</label>
                    <input type="text" name="code" value="{{ old('code') }}" required class="w-full px-4 py-2 border rounded-lg font-mono uppercase focus:ring-2 focus:ring-brand-500 focus:border-brand-500" placeholder="SUMMER20" style="text-transform: uppercase;">
                    <p class="text-xs text-gray-500 mt-1">Unique discount code (e.g., SUMMER20, SAVE50)</p>
                    @error('code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Discount Amount *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                        <input type="number" name="discount_amount" value="{{ old('discount_amount') }}" required step="0.01" min="0" class="w-full pl-8 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500" placeholder="10.00">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Discount amount in dollars</p>
                    @error('discount_amount')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Valid Until (Optional)</label>
                <input type="date" name="valid_to" value="{{ old('valid_to') }}" min="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                <p class="text-xs text-gray-500 mt-1">Leave empty for no expiration date</p>
                @error('valid_to')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 text-brand-500 border-gray-300 rounded focus:ring-brand-500">
                    <span class="text-gray-700 font-medium">Active</span>
                </label>
                <p class="text-xs text-gray-500 mt-1 ml-7">Check to make this code active and usable</p>
                @error('is_active')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">External URL (Optional)</label>
                <input type="url" name="external_url" value="{{ old('external_url') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500" placeholder="https://example.com/deal">
                <p class="text-xs text-gray-500 mt-1">Link to external deal or promotion page</p>
                @error('external_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Image (Optional)</label>
                <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                <p class="text-xs text-gray-500 mt-1">PNG, JPG, WEBP, max 2MB</p>
                @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="px-6 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition">
                    Create Code
                </button>
                <a href="{{ route('codes.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Cancel
                </a>
            </div>
        </form>
    </x-common.component-card>
@endsection
