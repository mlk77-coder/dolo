@extends('layouts.admin')
@php
    use Illuminate\Support\Facades\Storage;
@endphp
@section('content')
    <x-common.page-breadcrumb pageTitle="Code Details" />
    <x-common.component-card>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Discount Code #{{ $code->id }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('codes.edit', $code) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg">Edit</a>
                <a href="{{ route('codes.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg">Back</a>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Customer</h3>
                <p>{{ $code->customer->name ?? '—' }} ({{ $code->customer->email ?? '—' }})</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Category</h3>
                <p>{{ ucfirst($code->category ?? '—') }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Code</h3>
                @if($code->code)
                    <p class="font-mono text-lg font-bold text-blue-600">{{ $code->code }}</p>
                @else
                    <p>—</p>
                @endif
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Created</h3>
                <p>{{ $code->created_at->format('M d, Y H:i') }}</p>
            </div>
            @if($code->external_url)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold mb-2">External URL</h3>
                    <a href="{{ $code->external_url }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $code->external_url }}</a>
                </div>
            @endif
        </div>
        <div class="mt-6 bg-gray-50 p-4 rounded-lg">
            <h3 class="font-semibold mb-2">Subject</h3>
            <p class="text-lg">{{ $code->subject }}</p>
        </div>
        @if($code->description)
            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Description</h3>
                <p>{{ $code->description }}</p>
            </div>
        @endif
        @if($code->image)
            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Image</h3>
                <img src="{{ asset('storage/' . $code->image) }}" alt="Code Image" class="max-w-md rounded-lg border">
            </div>
        @endif
    </x-common.component-card>
@endsection

