@extends('layouts.admin')
@php
use Illuminate\Support\Facades\Storage;
@endphp
@section('content')
    <x-common.page-breadcrumb pageTitle="Carousel Image Details" />
    <x-common.component-card>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Carousel Image Details</h2>
            <div class="flex gap-2">
                <a href="{{ route('mobile-carousel-images.edit', $mobileCarouselImage) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg">Edit</a>
                <a href="{{ route('mobile-carousel-images.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg">Back</a>
            </div>
        </div>
        @if($mobileCarouselImage->image_url)
            <div class="mb-6">
                <img src="{{ Storage::url($mobileCarouselImage->image_url) }}" alt="{{ $mobileCarouselImage->title ?? 'Carousel Image' }}" class="w-full max-w-md rounded-lg">
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Title</h3>
                <p>{{ $mobileCarouselImage->title ?? '—' }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Status</h3>
                <span class="px-2 py-1 rounded text-xs {{ $mobileCarouselImage->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                    {{ ucfirst($mobileCarouselImage->status) }}
                </span>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Sort Order</h3>
                <p>{{ $mobileCarouselImage->sort_order }}</p>
            </div>
            @if($mobileCarouselImage->link_url)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold mb-2">Link URL</h3>
                    <a href="{{ $mobileCarouselImage->link_url }}" target="_blank" class="text-blue-500 hover:underline">{{ $mobileCarouselImage->link_url }}</a>
                </div>
            @endif
        </div>
        @if($mobileCarouselImage->description)
            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Description</h3>
                <p>{{ $mobileCarouselImage->description }}</p>
            </div>
        @endif
    </x-common.component-card>
@endsection

