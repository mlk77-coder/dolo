@extends('layouts.admin')
@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <x-common.page-breadcrumb pageTitle="Product Details" />

    <div class="space-y-6">
        <x-common.component-card>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-gray-800 text-xl font-bold">{{ $product->name }}</h2>
                <div class="flex items-center gap-2">
                    <a href="{{ route('products.edit', $product) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                        Edit
                    </a>
                    <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Back
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full rounded-lg">
                    @else
                        <div class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400">No Image</span>
                        </div>
                    @endif
                </div>
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-500 text-theme-sm">SKU</p>
                        <p class="text-gray-800 text-lg font-medium">{{ $product->sku }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-theme-sm">Category</p>
                        <p class="text-gray-800 text-lg font-medium">{{ $product->category->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-theme-sm">Price</p>
                        <div class="flex items-center gap-2">
                            <p class="text-gray-800 text-2xl font-bold">${{ number_format($product->price, 2) }}</p>
                            @if($product->discount_price)
                                <p class="text-green-500 text-lg">${{ number_format($product->discount_price, 2) }}</p>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="text-gray-500 text-theme-sm">Stock</p>
                        <p class="text-gray-800 text-lg font-medium">{{ $product->stock }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-theme-sm">Status</p>
                        <span class="text-theme-xs inline-block rounded-full px-3 py-1 font-medium {{ $product->status == 'active' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-theme-sm">Description</p>
                        <p class="text-gray-800">{{ $product->description }}</p>
                    </div>
                </div>
            </div>
        </x-common.component-card>
    </div>
@endsection
