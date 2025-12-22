@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Abandoned Carts" />
    <x-common.component-card>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Abandoned Carts</h2>
            <p class="text-sm text-gray-500">Customers who added deals to cart but didn't complete their order</p>
        </div>
        <form method="GET" class="mb-6 flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..." class="px-4 py-2 border rounded-lg">
            <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg">Filter</button>
        </form>
        <div class="overflow-x-auto">
            <table class="w-full border">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left">Customer Name</th>
                        <th class="px-5 py-3 text-left">Email</th>
                        <th class="px-5 py-3 text-left">Pending Orders</th>
                        <th class="px-5 py-3 text-left">Last Activity</th>
                        <th class="px-5 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr class="border-b">
                            <td class="px-5 py-4">{{ $customer->name }}</td>
                            <td class="px-5 py-4">{{ $customer->email }}</td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-700">
                                    {{ $customer->orders_count ?? 0 }}
                                </span>
                            </td>
                            <td class="px-5 py-4">{{ $customer->updated_at->format('M d, Y H:i') }}</td>
                            <td class="px-5 py-4">
                                <a href="{{ route('customers.show', $customer) }}" class="text-blue-500 hover:underline">View Customer</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-8 text-center">No abandoned carts found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $customers->links() }}</div>
    </x-common.component-card>
@endsection

