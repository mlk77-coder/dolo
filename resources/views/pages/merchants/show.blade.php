@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Merchant Details" />
    <x-common.component-card>
        <div class="flex justify-between mb-6">
            <h2 class="text-xl font-bold">{{ $merchant->business_name }}</h2>
            <a href="{{ route('merchants.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg">Back</a>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            <div><p class="text-gray-500 text-sm">Owner</p><p class="font-medium">{{ $merchant->owner_name ?? '—' }}</p></div>
            <div><p class="text-gray-500 text-sm">Phone</p><p class="font-medium">{{ $merchant->phone ?? '—' }}</p></div>
            <div><p class="text-gray-500 text-sm">Email</p><p class="font-medium">{{ $merchant->email ?? '—' }}</p></div>
            <div><p class="text-gray-500 text-sm">City</p><p class="font-medium">{{ $merchant->city ?? '—' }}</p></div>
            <div><p class="text-gray-500 text-sm">Address</p><p class="font-medium">{{ $merchant->address ?? '—' }}</p></div>
            <div><p class="text-gray-500 text-sm">Status</p><p class="font-medium">{{ $merchant->status }}</p></div>
            <div class="md:col-span-2"><p class="text-gray-500 text-sm">Description</p><p class="font-medium">{{ $merchant->description ?? '—' }}</p></div>
            <div class="md:col-span-2"><p class="text-gray-500 text-sm">Documents</p>
                @if(is_array($merchant->documents))
                    <ul class="list-disc list-inside">
                        @foreach($merchant->documents as $doc)
                            <li class="text-sm">{{ $doc }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="font-medium">—</p>
                @endif
            </div>
        </div>
    </x-common.component-card>
@endsection

