@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Notification Details" />
    <x-common.component-card>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Notification Details</h2>
            <div class="flex gap-2">
                <a href="{{ route('notifications.edit', $notification) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg">Edit</a>
                <a href="{{ route('notifications.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg">Back</a>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">User</h3>
                <p>{{ $notification->user->name }} ({{ $notification->user->email }})</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Type</h3>
                <p>{{ $notification->type ?? '—' }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Status</h3>
                <span class="px-2 py-1 rounded text-xs 
                    {{ $notification->status == 'sent' ? 'bg-green-100 text-green-700' : 
                       ($notification->status == 'failed' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                    {{ ucfirst($notification->status) }}
                </span>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Sent At</h3>
                <p>{{ $notification->sent_at ? $notification->sent_at->format('M d, Y H:i') : 'Not sent yet' }}</p>
            </div>
        </div>
        <div class="mt-6 bg-gray-50 p-4 rounded-lg">
            <h3 class="font-semibold mb-2">Title</h3>
            <p class="text-lg">{{ $notification->title }}</p>
        </div>
        @if($notification->message)
            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Message</h3>
                <p>{{ $notification->message }}</p>
            </div>
        @endif
    </x-common.component-card>
@endsection

