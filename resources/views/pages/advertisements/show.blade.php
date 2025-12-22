@extends('layouts.admin')
@php
use Illuminate\Support\Facades\Storage;
@endphp
@section('content')
    <x-common.page-breadcrumb pageTitle="Advertisement Details" />
    <x-common.component-card>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Advertisement Details</h2>
            <div class="flex gap-2">
                <a href="{{ route('advertisements.edit', $advertisement) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg">Edit</a>
                <a href="{{ route('advertisements.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg">Back</a>
            </div>
        </div>
        @if($advertisement->image_url)
            <div class="mb-6">
                <img src="{{ Storage::url($advertisement->image_url) }}" alt="{{ $advertisement->title }}" class="w-full max-w-md rounded-lg">
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Title</h3>
                <p>{{ $advertisement->title }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Position</h3>
                <p>{{ ucfirst($advertisement->position) }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Status</h3>
                <span class="px-2 py-1 rounded text-xs {{ $advertisement->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                    {{ ucfirst($advertisement->status) }}
                </span>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Clicks / Views</h3>
                <p>{{ $advertisement->clicks }} / {{ $advertisement->views }}</p>
            </div>
            @if($advertisement->link_url)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold mb-2">Link URL</h3>
                    <a href="{{ $advertisement->link_url }}" target="_blank" class="text-blue-500 hover:underline">{{ $advertisement->link_url }}</a>
                </div>
            @endif
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Sort Order</h3>
                <p>{{ $advertisement->sort_order }}</p>
            </div>
        </div>
        @if($advertisement->description)
            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Description</h3>
                <p>{{ $advertisement->description }}</p>
            </div>
        @endif
    </x-common.component-card>
@endsection

