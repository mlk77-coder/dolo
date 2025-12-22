@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Create Category" />
    <x-common.component-card title="Create Category">
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-theme-sm font-medium mb-2">Name (EN) *</label>
                    <input type="text" name="name_en" value="{{ old('name_en') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    @error('name_en')<p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-theme-sm font-medium mb-2">Name (AR) *</label>
                    <input type="text" name="name_ar" value="{{ old('name_ar') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    @error('name_ar')<p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-gray-700 text-theme-sm font-medium mb-2">Icon</label>
                <input type="text" name="icon" value="{{ old('icon') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="e.g. heroicon name or URL">
                @error('icon')<p class="text-red-500 text-theme-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 text-theme-sm font-medium mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('description') }}</textarea>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-brand-500 text-white rounded-lg">Create</button>
                <a href="{{ route('categories.index') }}" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg">Cancel</a>
            </div>
        </form>
    </x-common.component-card>
@endsection
