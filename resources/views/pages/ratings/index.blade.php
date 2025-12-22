@extends('layouts.admin')
@php
use Illuminate\Support\Str;
@endphp
@section('content')
    <x-common.page-breadcrumb pageTitle="Ratings" />
    <x-common.component-card>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h2 class="text-gray-800 text-xl font-bold">All Ratings</h2>
            <a href="{{ route('ratings.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Rating
            </a>
        </div>

        <form method="GET" class="mb-6 flex flex-col md:flex-row gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="flex-1 px-4 py-2 border rounded-lg">
            <select name="approved" class="px-4 py-2 border rounded-lg">
                <option value="">All</option>
                <option value="1" {{ request('approved') == '1' ? 'selected' : '' }}>Approved</option>
                <option value="0" {{ request('approved') == '0' ? 'selected' : '' }}>Pending</option>
            </select>
            <select name="stars" class="px-4 py-2 border rounded-lg">
                <option value="">All Stars</option>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ request('stars') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                @endfor
            </select>
            <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg">Filter</button>
            <a href="{{ route('ratings.index') }}" class="px-6 py-2 bg-gray-200 rounded-lg">Clear</a>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left">User</th>
                        <th class="px-5 py-3 text-left">Deal</th>
                        <th class="px-5 py-3 text-left">Stars</th>
                        <th class="px-5 py-3 text-left">Comment</th>
                        <th class="px-5 py-3 text-left">Approved</th>
                        <th class="px-5 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ratings as $rating)
                        <tr class="border-b border-gray-100">
                            <td class="px-5 py-4">{{ $rating->user->name }}</td>
                            <td class="px-5 py-4">{{ $rating->deal->title_en ?? 'N/A' }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $rating->stars ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                    <span class="ml-1 text-sm text-gray-600">({{ $rating->stars }})</span>
                                </div>
                            </td>
                            <td class="px-5 py-4">{{ Str::limit($rating->comment ?? '—', 50) }}</td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-1 rounded text-xs {{ $rating->approved ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $rating->approved ? 'Approved' : 'Pending' }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('ratings.show', $rating) }}" class="text-blue-500">View</a>
                                    <a href="{{ route('ratings.edit', $rating) }}" class="text-yellow-500">Edit</a>
                                    <form action="{{ route('ratings.destroy', $rating) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-8 text-center">No ratings found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $ratings->links() }}</div>
    </x-common.component-card>
@endsection

