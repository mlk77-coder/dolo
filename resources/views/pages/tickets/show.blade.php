@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Ticket Details" />
    <x-common.component-card>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Ticket #{{ $ticket->id }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('tickets.edit', $ticket) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg">Edit</a>
                <a href="{{ route('tickets.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg">Back</a>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">User</h3>
                <p>{{ $ticket->user->name }} ({{ $ticket->user->email }})</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Category</h3>
                <p>{{ ucfirst($ticket->category) }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Status</h3>
                <span class="px-2 py-1 rounded text-xs 
                    {{ $ticket->status == 'resolved' ? 'bg-green-100 text-green-700' : 
                       ($ticket->status == 'closed' ? 'bg-gray-100 text-gray-700' : 
                       ($ticket->status == 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700')) }}">
                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                </span>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Created</h3>
                <p>{{ $ticket->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
        <div class="mt-6 bg-gray-50 p-4 rounded-lg">
            <h3 class="font-semibold mb-2">Subject</h3>
            <p class="text-lg">{{ $ticket->subject }}</p>
        </div>
        @if($ticket->description)
            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Description</h3>
                <p>{{ $ticket->description }}</p>
            </div>
        @endif
    </x-common.component-card>
@endsection

