@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Merchant" />
    <x-common.component-card title="Edit Merchant">
        <form action="{{ route('merchants.update', $merchant) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')
            @include('pages.merchants.partials.form', ['merchant' => $merchant])
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-brand-500 text-white rounded-lg">Update</button>
                <a href="{{ route('merchants.index') }}" class="px-6 py-2 bg-gray-200 rounded-lg">Cancel</a>
            </div>
        </form>
    </x-common.component-card>
@endsection

