@extends('layouts.admin')
@php
use Illuminate\Support\Facades\Storage;
@endphp
@section('content')
    <x-common.page-breadcrumb pageTitle="Mobile Carousel Images" />
    <x-common.component-card>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h2 class="text-gray-800 text-xl font-bold">All Carousel Images</h2>
            <a href="{{ route('mobile-carousel-images.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Image
            </a>
        </div>

        <form method="GET" class="mb-6 flex flex-col md:flex-row gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="flex-1 px-4 py-2 border rounded-lg">
            <select name="status" class="px-4 py-2 border rounded-lg">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg">Filter</button>
            <a href="{{ route('mobile-carousel-images.index') }}" class="px-6 py-2 bg-gray-200 rounded-lg">Clear</a>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left">Image</th>
                        <th class="px-5 py-3 text-left">Title</th>
                        <th class="px-5 py-3 text-left">Sort Order</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($carouselImages as $image)
                        <tr class="border-b border-gray-100">
                            <td class="px-5 py-4">
                                <div class="w-24 h-16 rounded-lg overflow-hidden bg-gray-100">
                                    @if($image->image_url)
                                        <img src="{{ Storage::url($image->image_url) }}" alt="{{ $image->title ?? 'Carousel Image' }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4 font-medium">{{ $image->title ?? '—' }}</td>
                            <td class="px-5 py-4">{{ $image->sort_order }}</td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-1 rounded text-xs {{ $image->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($image->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('mobile-carousel-images.show', $image) }}" class="text-blue-500">View</a>
                                    <a href="{{ route('mobile-carousel-images.edit', $image) }}" class="text-yellow-500">Edit</a>
                                    <form action="{{ route('mobile-carousel-images.destroy', $image) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-8 text-center">No carousel images found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $carouselImages->links() }}</div>
    </x-common.component-card>
@endsection

