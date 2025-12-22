@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Code" />
    <x-common.component-card title="Edit Discount Code">
        <form action="{{ route('codes.update', $code) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Customer *</label>
                    <select name="customer_id" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id', $code->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->name }} ({{ $customer->email }})</option>
                        @endforeach
                    </select>
                    @error('customer_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Category</label>
                    <select name="category" class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Select Category</option>
                        <option value="food" {{ old('category', $code->category) == 'food' ? 'selected' : '' }}>Food</option>
                        <option value="shopping" {{ old('category', $code->category) == 'shopping' ? 'selected' : '' }}>Shopping</option>
                        <option value="entertainment" {{ old('category', $code->category) == 'entertainment' ? 'selected' : '' }}>Entertainment</option>
                        <option value="travel" {{ old('category', $code->category) == 'travel' ? 'selected' : '' }}>Travel</option>
                        <option value="other" {{ old('category', $code->category) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Subject *</label>
                <input type="text" name="subject" value="{{ old('subject', $code->subject) }}" required class="w-full px-4 py-2 border rounded-lg" placeholder="Discount code title">
                @error('subject')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg" placeholder="Code description">{{ old('description', $code->description) }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Code</label>
                    <input type="text" name="code" value="{{ old('code', $code->code) }}" class="w-full px-4 py-2 border rounded-lg font-mono" placeholder="DISCOUNT20">
                    @error('code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">External URL</label>
                    <input type="url" name="external_url" value="{{ old('external_url', $code->external_url) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="https://example.com">
                    @error('external_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Image</label>
                @if($code->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $code->image) }}" alt="Code Image" class="w-32 h-32 object-cover rounded-lg border">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
                <p class="text-xs text-gray-500 mt-1">PNG, JPG, WEBP, max 2MB</p>
                @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-brand-500 text-white rounded-lg">Update</button>
                <a href="{{ route('codes.index') }}" class="px-6 py-2 bg-gray-200 rounded-lg">Cancel</a>
            </div>
        </form>
    </x-common.component-card>
@endsection

