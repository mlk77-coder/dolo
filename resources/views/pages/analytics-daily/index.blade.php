@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Analytics Daily" />
    <x-common.component-card>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h2 class="text-gray-800 text-xl font-bold">Daily Analytics</h2>
        </div>

        <form method="GET" class="mb-6 flex flex-col md:flex-row gap-4">
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-4 py-2 border rounded-lg" placeholder="From Date">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-4 py-2 border rounded-lg" placeholder="To Date">
            <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg">Filter</button>
            <a href="{{ route('analytics-daily.index') }}" class="px-6 py-2 bg-gray-200 rounded-lg">Clear</a>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left">Date</th>
                        <th class="px-5 py-3 text-left">Total Users</th>
                        <th class="px-5 py-3 text-left">New Users</th>
                        <th class="px-5 py-3 text-left">Total Orders</th>
                        <th class="px-5 py-3 text-left">Revenue</th>
                        <th class="px-5 py-3 text-left">Deal Views</th>
                        <th class="px-5 py-3 text-left">Page Views</th>
                        <th class="px-5 py-3 text-left">Sessions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($analytics as $day)
                        <tr class="border-b border-gray-100">
                            <td class="px-5 py-4 font-medium">{{ $day->date->format('M d, Y') }}</td>
                            <td class="px-5 py-4">{{ number_format($day->total_users) }}</td>
                            <td class="px-5 py-4">{{ number_format($day->new_users) }}</td>
                            <td class="px-5 py-4">{{ number_format($day->total_orders) }}</td>
                            <td class="px-5 py-4">${{ number_format($day->total_revenue, 2) }}</td>
                            <td class="px-5 py-4">{{ number_format($day->total_deal_views) }}</td>
                            <td class="px-5 py-4">{{ number_format($day->total_page_views) }}</td>
                            <td class="px-5 py-4">{{ number_format($day->total_sessions) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-5 py-8 text-center">No analytics data found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $analytics->links() }}</div>
    </x-common.component-card>
@endsection

