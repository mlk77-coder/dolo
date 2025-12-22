@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Notifications" />
    <x-common.component-card>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h2 class="text-gray-800 text-xl font-bold">All Notifications</h2>
            <a href="{{ route('notifications.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Notification
            </a>
        </div>

        <form method="GET" class="mb-6 flex flex-col md:flex-row gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="flex-1 px-4 py-2 border rounded-lg">
            <select name="status" class="px-4 py-2 border rounded-lg">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
            <select name="type" class="px-4 py-2 border rounded-lg">
                <option value="">All Types</option>
                @foreach(['order', 'deal', 'promotion', 'system', 'other'] as $type)
                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg">Filter</button>
            <a href="{{ route('notifications.index') }}" class="px-6 py-2 bg-gray-200 rounded-lg">Clear</a>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left">User</th>
                        <th class="px-5 py-3 text-left">Title</th>
                        <th class="px-5 py-3 text-left">Type</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-left">Sent At</th>
                        <th class="px-5 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notification)
                        <tr class="border-b border-gray-100">
                            <td class="px-5 py-4">{{ $notification->user->name }}</td>
                            <td class="px-5 py-4 font-medium">{{ $notification->title }}</td>
                            <td class="px-5 py-4">{{ $notification->type ?? '—' }}</td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-1 rounded text-xs 
                                    {{ $notification->status == 'sent' ? 'bg-green-100 text-green-700' : 
                                       ($notification->status == 'failed' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ ucfirst($notification->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4">{{ $notification->sent_at ? $notification->sent_at->format('M d, Y H:i') : '—' }}</td>
                            <td class="px-5 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('notifications.show', $notification) }}" class="text-blue-500">View</a>
                                    <a href="{{ route('notifications.edit', $notification) }}" class="text-yellow-500">Edit</a>
                                    <form action="{{ route('notifications.destroy', $notification) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-8 text-center">No notifications found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $notifications->links() }}</div>
    </x-common.component-card>
@endsection

