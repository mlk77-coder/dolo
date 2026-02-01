@extends('layouts.admin')

@section('content')
    <x-common.page-breadcrumb pageTitle="Create Product" />

    <div class="space-y-6">
        <x-common.component-card title="Create New Product">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Category *</label>
                        <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('name')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">SKU *</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('sku')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Slug</label>
                        <input type="text" name="slug" value="{{ old('slug') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('slug')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Price *</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('price')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Discount Price</label>
                        <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('discount_price')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Stock *</label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('stock')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-theme-sm font-medium mb-2">Status *</label>
                        <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-theme-sm font-medium mb-2">Description *</label>
                    <textarea name="description" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-theme-sm font-medium mb-2">Product Image</label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    @error('image')
                        <p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="px-6 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition">
                        Create Product
                    </button>
                    <a href="{{ route('products.index') }}" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Cancel
                    </a>
                </div>
            </form>
        </x-common.component-card>
    </div>
@endsection
