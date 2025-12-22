@extends('layouts.admin')

@section('content')
    <x-common.page-breadcrumb pageTitle="Categories" />
    <div class="space-y-6">
        <x-common.component-card>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h2 class="text-gray-800 text-xl font-bold">All Categories</h2>
                <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Category
                </a>
            </div>
            <form method="GET" class="mb-6">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="px-4 py-2 border border-gray-300 rounded-lg">
                <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg">Search</button>
            </form>
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
                <table class="w-full">
                    <thead class="border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-3 text-left">Name (EN)</th>
                            <th class="px-5 py-3 text-left">Name (AR)</th>
                            <th class="px-5 py-3 text-left">Slug</th>
                            <th class="px-5 py-3 text-left">Icon</th>
                            <th class="px-5 py-3 text-left">Products</th>
                            <th class="px-5 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="border-b border-gray-100">
                                <td class="px-5 py-4">{{ $category->name_en }}</td>
                                <td class="px-5 py-4">{{ $category->name_ar }}</td>
                                <td class="px-5 py-4 text-gray-500">{{ $category->slug }}</td>
                                <td class="px-5 py-4 text-gray-500">{{ $category->icon ?? '—' }}</td>
                                <td class="px-5 py-4">{{ $category->products_count ?? $category->products()->count() }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('categories.edit', $category) }}" class="p-2 text-yellow-500 hover:bg-yellow-50 rounded">Edit</a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-5 py-8 text-center text-gray-500">No categories found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $categories->links() }}</div>
        </x-common.component-card>
    </div>
@endsection
