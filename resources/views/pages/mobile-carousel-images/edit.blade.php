@extends('layouts.admin')
@php
use Illuminate\Support\Facades\Storage;
@endphp
@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Carousel Image" />
    <x-common.component-card title="Edit Carousel Image">
        <form action="{{ route('mobile-carousel-images.update', $mobileCarouselImage) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Title</label>
                    <input type="text" name="title" value="{{ old('title', $mobileCarouselImage->title) }}" class="w-full px-4 py-2 border rounded-lg">
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Status *</label>
                    <select name="status" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="active" {{ old('status', $mobileCarouselImage->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $mobileCarouselImage->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $mobileCarouselImage->sort_order) }}" min="0" class="w-full px-4 py-2 border rounded-lg">
                    @error('sort_order')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Link URL</label>
                    <input type="url" name="link_url" value="{{ old('link_url', $mobileCarouselImage->link_url) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="https://...">
                    @error('link_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg">{{ old('description', $mobileCarouselImage->description) }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Image</label>
                @if($mobileCarouselImage->image_url)
                    <div class="mb-2">
                        <img src="{{ Storage::url($mobileCarouselImage->image_url) }}" alt="{{ $mobileCarouselImage->title ?? 'Carousel Image' }}" class="w-32 h-32 object-cover rounded-lg">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
                <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image</p>
                @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-brand-500 text-white rounded-lg">Update</button>
                <a href="{{ route('mobile-carousel-images.index') }}" class="px-6 py-2 bg-gray-200 rounded-lg">Cancel</a>
            </div>
        </form>
    </x-common.component-card>
@endsection

