@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Create Deal" />
    <x-common.component-card title="Create Deal">
        <form action="{{ route('deals.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @include('pages.deals.partials.form', ['deal' => null, 'merchants' => $merchants, 'categories' => $categories])
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-brand-500 text-white rounded-lg">Create</button>
                <a href="{{ route('deals.index') }}" class="px-6 py-2 bg-gray-200 rounded-lg">Cancel</a>
            </div>
        </form>
    </x-common.component-card>
@endsection

