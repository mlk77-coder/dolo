@extends('layouts.admin')
@php
use Illuminate\Support\Facades\Storage;
@endphp
@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Advertisement" />
    <x-common.component-card title="Edit Advertisement">
        <form action="{{ route('advertisements.update', $advertisement) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Title *</label>
                    <input type="text" name="title" value="{{ old('title', $advertisement->title) }}" required class="w-full px-4 py-2 border rounded-lg">
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Position *</label>
                    <select name="position" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="homepage" {{ old('position', $advertisement->position) == 'homepage' ? 'selected' : '' }}>Homepage</option>
                        <option value="sidebar" {{ old('position', $advertisement->position) == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                        <option value="footer" {{ old('position', $advertisement->position) == 'footer' ? 'selected' : '' }}>Footer</option>
                        <option value="header" {{ old('position', $advertisement->position) == 'header' ? 'selected' : '' }}>Header</option>
                        <option value="other" {{ old('position', $advertisement->position) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('position')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Status *</label>
                    <select name="status" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="active" {{ old('status', $advertisement->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $advertisement->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $advertisement->sort_order) }}" min="0" class="w-full px-4 py-2 border rounded-lg">
                    @error('sort_order')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Link URL</label>
                    <input type="url" name="link_url" value="{{ old('link_url', $advertisement->link_url) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="https://...">
                    @error('link_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Start Date</label>
                    <input type="datetime-local" name="start_date" value="{{ old('start_date', $advertisement->start_date ? $advertisement->start_date->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-2 border rounded-lg">
                    @error('start_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">End Date</label>
                    <input type="datetime-local" name="end_date" value="{{ old('end_date', $advertisement->end_date ? $advertisement->end_date->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-2 border rounded-lg">
                    @error('end_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg">{{ old('description', $advertisement->description) }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Image</label>
                @if($advertisement->image_url)
                    <div class="mb-2">
                        <img src="{{ Storage::url($advertisement->image_url) }}" alt="{{ $advertisement->title }}" class="w-32 h-32 object-cover rounded-lg">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
                <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image</p>
                @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-brand-500 text-white rounded-lg">Update</button>
                <a href="{{ route('advertisements.index') }}" class="px-6 py-2 bg-gray-200 rounded-lg">Cancel</a>
            </div>
        </form>
    </x-common.component-card>
@endsection

