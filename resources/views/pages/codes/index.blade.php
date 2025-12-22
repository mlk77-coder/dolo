@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Codes" />
    <x-common.component-card>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h2 class="text-gray-800 text-xl font-bold">All Discount Codes</h2>
            <a href="{{ route('codes.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Code
            </a>
        </div>

        <form method="GET" class="mb-6 flex flex-col md:flex-row gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by code, subject, or customer..." class="flex-1 px-4 py-2 border rounded-lg">
            <select name="category" class="px-4 py-2 border rounded-lg">
                <option value="">All Categories</option>
                @foreach(['food', 'shopping', 'entertainment', 'travel', 'other'] as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg">Filter</button>
            <a href="{{ route('codes.index') }}" class="px-6 py-2 bg-gray-200 rounded-lg">Clear</a>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left">ID</th>
                        <th class="px-5 py-3 text-left">Customer</th>
                        <th class="px-5 py-3 text-left">Subject</th>
                        <th class="px-5 py-3 text-left">Category</th>
                        <th class="px-5 py-3 text-left">Code</th>
                        <th class="px-5 py-3 text-left">Image</th>
                        <th class="px-5 py-3 text-left">Created</th>
                        <th class="px-5 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($codes as $code)
                        <tr class="border-b border-gray-100">
                            <td class="px-5 py-4">#{{ $code->id }}</td>
                            <td class="px-5 py-4">{{ $code->customer->name ?? '—' }}</td>
                            <td class="px-5 py-4 font-medium">{{ $code->subject }}</td>
                            <td class="px-5 py-4">{{ ucfirst($code->category ?? '—') }}</td>
                            <td class="px-5 py-4">
                                @if($code->code)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-sm font-mono">{{ $code->code }}</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                @if($code->image)
                                    <img src="{{ asset('storage/' . $code->image) }}" alt="Code Image" class="w-12 h-12 object-cover rounded">
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-5 py-4">{{ $code->created_at->format('M d, Y') }}</td>
                            <td class="px-5 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('codes.show', $code) }}" class="text-blue-500">View</a>
                                    <a href="{{ route('codes.edit', $code) }}" class="text-yellow-500">Edit</a>
                                    <form action="{{ route('codes.destroy', $code) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-5 py-8 text-center">No codes found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $codes->links() }}</div>
    </x-common.component-card>
@endsection

