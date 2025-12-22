@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Customers" />
    <x-common.component-card>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">All Customers</h2>
            <a href="{{ route('customers.export-csv', request()->all()) }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export CSV
            </a>
        </div>
        <form method="GET" class="mb-6 flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..." class="px-4 py-2 border rounded-lg">
            <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg">Filter</button>
        </form>
        <div class="overflow-x-auto">
            <table class="w-full border">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left">Name</th>
                        <th class="px-5 py-3 text-left">Email</th>
                        <th class="px-5 py-3 text-left">Orders</th>
                        <th class="px-5 py-3 text-left">Created At</th>
                        <th class="px-5 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr class="border-b">
                            <td class="px-5 py-4">{{ $customer->name }}</td>
                            <td class="px-5 py-4">{{ $customer->email }}</td>
                            <td class="px-5 py-4">{{ $customer->orders_count ?? $customer->orders()->count() }}</td>
                            <td class="px-5 py-4">{{ $customer->created_at->format('M d, Y') }}</td>
                            <td class="px-5 py-4"><a href="{{ route('customers.show', $customer) }}" class="text-blue-500">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-8 text-center">No customers found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $customers->links() }}</div>
    </x-common.component-card>
@endsection

