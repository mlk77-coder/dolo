@extends('layouts.admin')
@php
use Illuminate\Support\Facades\Storage;
@endphp
@section('content')
    <x-common.page-breadcrumb pageTitle="Advertisements" />
    <x-common.component-card>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h2 class="text-gray-800 text-xl font-bold">All Advertisements</h2>
            <a href="{{ route('advertisements.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Advertisement
            </a>
        </div>

        <form method="GET" class="mb-6 flex flex-col md:flex-row gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="flex-1 px-4 py-2 border rounded-lg">
            <select name="status" class="px-4 py-2 border rounded-lg">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <select name="position" class="px-4 py-2 border rounded-lg">
                <option value="">All Positions</option>
                @foreach(['homepage', 'sidebar', 'footer', 'header', 'other'] as $pos)
                    <option value="{{ $pos }}" {{ request('position') == $pos ? 'selected' : '' }}>{{ ucfirst($pos) }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg">Filter</button>
            <a href="{{ route('advertisements.index') }}" class="px-6 py-2 bg-gray-200 rounded-lg">Clear</a>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left">Image</th>
                        <th class="px-5 py-3 text-left">Title</th>
                        <th class="px-5 py-3 text-left">Position</th>
                        <th class="px-5 py-3 text-left">Clicks/Views</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($advertisements as $ad)
                        <tr class="border-b border-gray-100">
                            <td class="px-5 py-4">
                                <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100">
                                    @if($ad->image_url)
                                        <img src="{{ Storage::url($ad->image_url) }}" alt="{{ $ad->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4 font-medium">{{ $ad->title }}</td>
                            <td class="px-5 py-4">{{ ucfirst($ad->position) }}</td>
                            <td class="px-5 py-4 text-sm">{{ $ad->clicks }}/{{ $ad->views }}</td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-1 rounded text-xs {{ $ad->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($ad->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('advertisements.show', $ad) }}" class="text-blue-500">View</a>
                                    <a href="{{ route('advertisements.edit', $ad) }}" class="text-yellow-500">Edit</a>
                                    <form action="{{ route('advertisements.destroy', $ad) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-8 text-center">No advertisements found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $advertisements->links() }}</div>
    </x-common.component-card>
@endsection

