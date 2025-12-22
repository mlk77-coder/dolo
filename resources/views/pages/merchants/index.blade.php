@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Merchants" />
    <x-common.component-card>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">All Merchants</h2>
            <div class="flex gap-2">
                <a href="{{ route('merchants.export-csv', request()->all()) }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export CSV
                </a>
                <a href="{{ route('merchants.create') }}" class="px-4 py-2 bg-brand-500 text-white rounded-lg">Add Merchant</a>
            </div>
        </div>
        <form method="GET" class="flex flex-wrap gap-3 mb-4 items-end">
            <div>
                <label class="block text-xs text-gray-600 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" class="px-3 py-2 border rounded-lg" placeholder="Business or owner">
            </div>
            <div>
                <label class="block text-xs text-gray-600 mb-1">Status</label>
                <select name="status" class="px-3 py-2 border rounded-lg">
                    <option value="">All</option>
                    @foreach(['pending','active','inactive'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <button class="px-4 py-2 bg-gray-200 rounded-lg">Filter</button>
        </form>
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left">Business</th>
                        <th class="px-5 py-3 text-left">Owner</th>
                        <th class="px-5 py-3 text-left">City</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($merchants as $merchant)
                        <tr class="border-b border-gray-100">
                            <td class="px-5 py-4 font-medium">{{ $merchant->business_name }}</td>
                            <td class="px-5 py-4">{{ $merchant->owner_name ?? '—' }}</td>
                            <td class="px-5 py-4">{{ $merchant->city ?? '—' }}</td>
                            <td class="px-5 py-4"><span class="px-2 py-1 rounded text-xs bg-gray-100">{{ $merchant->status }}</span></td>
                            <td class="px-5 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('merchants.show', $merchant) }}" class="text-blue-500">View</a>
                                    <a href="{{ route('merchants.edit', $merchant) }}" class="text-yellow-500">Edit</a>
                                    <form action="{{ route('merchants.destroy', $merchant) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-8 text-center">No merchants found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $merchants->links() }}</div>
    </x-common.component-card>
@endsection

