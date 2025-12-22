@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Category Details" />
    <x-common.component-card>
        <div class="flex justify-between mb-6"><h2 class="text-xl font-bold">{{ $category->name_en }}</h2><a href="{{ route('categories.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg">Back</a></div>
        <div class="space-y-4">
            <div><p class="text-gray-500 text-sm">Name (AR)</p><p class="font-medium">{{ $category->name_ar }}</p></div>
            <div><p class="text-gray-500 text-sm">Slug</p><p class="font-medium">{{ $category->slug }}</p></div>
            <div><p class="text-gray-500 text-sm">Icon</p><p class="font-medium">{{ $category->icon ?? 'N/A' }}</p></div>
            <div><p class="text-gray-500 text-sm">Description</p><p class="font-medium">{{ $category->description ?? 'N/A' }}</p></div>
            <div><p class="text-gray-500 text-sm">Products Count</p><p class="font-medium">{{ $category->products->count() }}</p></div>
        </div>
        @if($category->products->count() > 0)
            <h3 class="text-lg font-bold mt-6 mb-4">Products in this category</h3>
            <table class="w-full border"><thead class="bg-gray-50"><tr><th class="px-5 py-3 text-left">Name</th><th class="px-5 py-3 text-left">Price</th><th class="px-5 py-3 text-left">Stock</th><th class="px-5 py-3 text-left">Status</th></tr></thead><tbody>@foreach($category->products as $product)<tr class="border-b"><td class="px-5 py-4">{{ $product->name }}</td><td class="px-5 py-4">${{ number_format($product->price, 2) }}</td><td class="px-5 py-4">{{ $product->stock }}</td><td class="px-5 py-4"><span class="px-2 py-1 rounded text-xs">{{ ucfirst($product->status) }}</span></td></tr>@endforeach</tbody></table>
        @endif
    </x-common.component-card>
@endsection
