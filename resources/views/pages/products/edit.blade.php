@extends('layouts.admin')
@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Product" />

    <div class="space-y-6">
        <x-common.component-card title="Edit Product">
            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Category *</label>
                        <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name_en }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Product Name *</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('name')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">SKU *</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('sku')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Slug</label>
                        <input type="text" name="slug" value="{{ old('slug', $product->slug) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('slug')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Price *</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('price')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Discount Price</label>
                        <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('discount_price')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Stock *</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('stock')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Status *</label>
                        <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-theme-sm font-medium mb-2">Description *</label>
                    <textarea name="description" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-theme-sm font-medium mb-2">Product Image</label>
                    @if($product->image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded-lg">
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    @error('image')
                        <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="px-6 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition">
                        Update Product
                    </button>
                    <a href="{{ route('products.index') }}" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Cancel
                    </a>
                </div>
            </form>
        </x-common.component-card>
    </div>
@endsection
