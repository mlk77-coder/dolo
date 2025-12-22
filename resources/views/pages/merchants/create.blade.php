@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Create Merchant" />
    <x-common.component-card title="Create Merchant">
        <form action="{{ route('merchants.store') }}" method="POST" class="space-y-6">
            @csrf
            @include('pages.merchants.partials.form', ['merchant' => null])
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-brand-500 text-white rounded-lg">Create</button>
                <a href="{{ route('merchants.index') }}" class="px-6 py-2 bg-gray-200 rounded-lg">Cancel</a>
            </div>
        </form>
    </x-common.component-card>
@endsection

