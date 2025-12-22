@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Ticket" />
    <x-common.component-card title="Edit Ticket">
        <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">User *</label>
                    <select name="user_id" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Select User</option>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $ticket->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Category *</label>
                    <select name="category" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="technical" {{ old('category', $ticket->category) == 'technical' ? 'selected' : '' }}>Technical</option>
                        <option value="billing" {{ old('category', $ticket->category) == 'billing' ? 'selected' : '' }}>Billing</option>
                        <option value="general" {{ old('category', $ticket->category) == 'general' ? 'selected' : '' }}>General</option>
                        <option value="refund" {{ old('category', $ticket->category) == 'refund' ? 'selected' : '' }}>Refund</option>
                        <option value="other" {{ old('category', $ticket->category) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Status *</label>
                    <select name="status" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="open" {{ old('status', $ticket->status) == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ old('status', $ticket->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="resolved" {{ old('status', $ticket->status) == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="closed" {{ old('status', $ticket->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                    @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Subject *</label>
                <input type="text" name="subject" value="{{ old('subject', $ticket->subject) }}" required class="w-full px-4 py-2 border rounded-lg">
                @error('subject')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg">{{ old('description', $ticket->description) }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-brand-500 text-white rounded-lg">Update</button>
                <a href="{{ route('tickets.index') }}" class="px-6 py-2 bg-gray-200 rounded-lg">Cancel</a>
            </div>
        </form>
    </x-common.component-card>
@endsection

