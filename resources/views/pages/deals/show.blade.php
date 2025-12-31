@extends('layouts.admin')
@php
    use Illuminate\Support\Facades\Storage;
@endphp
@section('content')
    <x-common.page-breadcrumb pageTitle="Deal Details" />
    <x-common.component-card>
        <div class="flex justify-between mb-6">
            <h2 class="text-xl font-bold">{{ $deal->title_en }}</h2>
            <a href="{{ route('deals.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg">Back</a>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-500 text-sm">Title (EN)</p>
                <p class="font-medium">{{ $deal->title_en }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Title (AR)</p>
                <p class="font-medium">{{ $deal->title_ar }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Merchant</p>
                <p class="font-medium">
                    @if($deal->merchant)
                        <a href="{{ route('merchants.show', $deal->merchant) }}" class="text-blue-600 hover:underline">
                            {{ $deal->merchant->business_name }}
                        </a>
                    @else
                        —
                    @endif
                </p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Category</p>
                <p class="font-medium">{{ $deal->category->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">SKU</p>
                <p class="font-medium">{{ $deal->sku ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">City</p>
                <p class="font-medium">{{ $deal->city ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Area</p>
                <p class="font-medium">{{ $deal->area ?? '—' }}</p>
            </div>
            @if($deal->location_name || ($deal->latitude && $deal->longitude))
                <div class="md:col-span-2 mt-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-500 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-800">Deal Location Available</p>
                                @if($deal->location_name)
                                    <p class="text-sm text-gray-600">{{ $deal->location_name }}</p>
                                @endif
                                @if($deal->latitude && $deal->longitude)
                                    <p class="text-xs text-gray-500 font-mono">{{ $deal->latitude }}, {{ $deal->longitude }}</p>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('deals.view-location', $deal) }}" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition flex items-center gap-2 shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            View Location on Map
                        </a>
                    </div>
                </div>
            @endif
            <div>
                <p class="text-gray-500 text-sm">Prices</p>
                <p class="font-medium">
                    <span class="line-through text-gray-400">${{ number_format($deal->original_price, 2) }}</span>
                    <span class="ml-2 text-green-600 font-semibold">${{ number_format($deal->discounted_price, 2) }}</span>
                    @if($deal->show_savings_percentage && $deal->discount_percentage)
                        <span class="ml-2 text-sm text-gray-500">{{ $deal->discount_percentage }}%</span>
                    @endif
                </p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Buyer Counter</p>
                <p class="font-medium">
                    {{ $deal->buyer_counter ?? 0 }}
                    @if($deal->show_buyer_counter)
                        <span class="text-xs text-green-600">(Visible)</span>
                    @else
                        <span class="text-xs text-gray-400">(Hidden)</span>
                    @endif
                </p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Status</p>
                <p class="font-medium">{{ ucfirst($deal->status) }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Featured</p>
                <p class="font-medium">{{ $deal->featured ? 'Yes' : 'No' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Period</p>
                <p class="font-medium">{{ optional($deal->start_date)->format('M d, Y H:i') }} - {{ optional($deal->end_date)->format('M d, Y H:i') }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-gray-500 text-sm">Description</p>
                <p class="font-medium">{{ $deal->description ?? '—' }}</p>
            </div>
            @if($deal->deal_information)
                <div class="md:col-span-2">
                    <p class="text-gray-500 text-sm">Deal Information</p>
                    <p class="font-medium">{{ $deal->deal_information }}</p>
                </div>
            @endif
            @if($deal->video_url)
                <div class="md:col-span-2">
                    <p class="text-gray-500 text-sm mb-2">Video</p>
                    @if(str_contains($deal->video_url, 'http'))
                        <a href="{{ $deal->video_url }}" target="_blank" class="text-blue-600 hover:underline">{{ $deal->video_url }}</a>
                    @else
                        <video controls class="w-full max-w-2xl rounded-lg">
                            <source src="{{ asset('storage/' . $deal->video_url) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                </div>
            @endif
            @if($deal->images && $deal->images->count() > 0)
                <div class="md:col-span-2">
                    <p class="text-gray-500 text-sm mb-3">Images Gallery</p>
                    
                    <!-- Image Carousel -->
                    <div class="relative" x-data="{ 
                        currentImage: 0, 
                        images: @json($deal->images->map(function($img) { 
                            $url = asset('storage/' . $img->image_url);
                            return $url;
                        })) 
                    }">
                        <!-- Main Carousel Image -->
                        <div class="relative w-full h-96 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl overflow-hidden mb-4 shadow-lg">
                            <template x-for="(image, index) in images" :key="index">
                                <div x-show="currentImage === index" class="absolute inset-0 transition-opacity duration-500" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                    <img :src="image" :alt="'Deal Image ' + (index + 1)" class="w-full h-full object-cover">
                                </div>
                            </template>
                            
                            <!-- Navigation Arrows -->
                            <button @click="currentImage = (currentImage - 1 + images.length) % images.length" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white bg-opacity-90 text-gray-800 p-3 rounded-full hover:bg-opacity-100 hover:scale-110 transition-all shadow-lg z-10">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button @click="currentImage = (currentImage + 1) % images.length" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white bg-opacity-90 text-gray-800 p-3 rounded-full hover:bg-opacity-100 hover:scale-110 transition-all shadow-lg z-10">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                            
                            <!-- Image Counter -->
                            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black bg-opacity-70 text-white px-4 py-2 rounded-full text-sm font-medium backdrop-blur-sm">
                                <span x-text="currentImage + 1"></span> / <span x-text="images.length"></span>
                            </div>
                        </div>
                        
                        <!-- Thumbnail Navigation -->
                        <div class="grid grid-cols-4 md:grid-cols-6 gap-3">
                            <template x-for="(image, index) in images" :key="index">
                                <button @click="currentImage = index" class="relative aspect-square overflow-hidden rounded-lg border-2 transition-all hover:scale-105 shadow-md" :class="currentImage === index ? 'border-brand-500 ring-2 ring-brand-300 ring-offset-2' : 'border-gray-200 hover:border-gray-400'">
                                    <img :src="image" :alt="'Thumbnail ' + (index + 1)" class="w-full h-full object-cover">
                                    <div x-show="currentImage === index" class="absolute inset-0 bg-brand-500 bg-opacity-20"></div>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </x-common.component-card>
@endsection

