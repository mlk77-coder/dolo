@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Create Rating" />
    <x-common.component-card title="Create Rating">
        <form action="{{ route('ratings.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">User *</label>
                    <select name="user_id" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Select User</option>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Deal *</label>
                    <select name="deal_id" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Select Deal</option>
                        @foreach($deals as $deal)
                            <option value="{{ $deal->id }}" {{ old('deal_id') == $deal->id ? 'selected' : '' }}>{{ $deal->title_en }}</option>
                        @endforeach
                    </select>
                    @error('deal_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Stars *</label>
                    <select name="stars" required class="w-full px-4 py-2 border rounded-lg">
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('stars') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                    @error('stars')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Approved</label>
                    <select name="approved" class="w-full px-4 py-2 border rounded-lg">
                        <option value="0" {{ old('approved') == '0' ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('approved') == '1' ? 'selected' : '' }}>Yes</option>
                    </select>
                    @error('approved')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Comment</label>
                <textarea name="comment" rows="4" class="w-full px-4 py-2 border rounded-lg">{{ old('comment') }}</textarea>
                @error('comment')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-brand-500 text-white rounded-lg">Create</button>
                <a href="{{ route('ratings.index') }}" class="px-6 py-2 bg-gray-200 rounded-lg">Cancel</a>
            </div>
        </form>
    </x-common.component-card>
@endsection

