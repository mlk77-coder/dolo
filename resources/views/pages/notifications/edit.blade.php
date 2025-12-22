@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Notification" />
    <x-common.component-card title="Edit Notification">
        <form action="{{ route('notifications.update', $notification) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">User *</label>
                    <select name="user_id" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Select User</option>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $notification->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    @error('user_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Type</label>
                    <select name="type" class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Select Type</option>
                        <option value="order" {{ old('type', $notification->type) == 'order' ? 'selected' : '' }}>Order</option>
                        <option value="deal" {{ old('type', $notification->type) == 'deal' ? 'selected' : '' }}>Deal</option>
                        <option value="promotion" {{ old('type', $notification->type) == 'promotion' ? 'selected' : '' }}>Promotion</option>
                        <option value="system" {{ old('type', $notification->type) == 'system' ? 'selected' : '' }}>System</option>
                        <option value="other" {{ old('type', $notification->type) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Status *</label>
                    <select name="status" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="pending" {{ old('status', $notification->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="sent" {{ old('status', $notification->status) == 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="failed" {{ old('status', $notification->status) == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                    @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Sent At</label>
                    <input type="datetime-local" name="sent_at" value="{{ old('sent_at', $notification->sent_at ? $notification->sent_at->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-2 border rounded-lg">
                    @error('sent_at')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Title *</label>
                <input type="text" name="title" value="{{ old('title', $notification->title) }}" required class="w-full px-4 py-2 border rounded-lg">
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Message</label>
                <textarea name="message" rows="4" class="w-full px-4 py-2 border rounded-lg">{{ old('message', $notification->message) }}</textarea>
                @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-brand-500 text-white rounded-lg">Update</button>
                <a href="{{ route('notifications.index') }}" class="px-6 py-2 bg-gray-200 rounded-lg">Cancel</a>
            </div>
        </form>
    </x-common.component-card>
@endsection

