@extends('layouts.admin')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Profile" />
    
    <div class="space-y-6">
        <x-common.component-card>
            <div class="max-w-2xl">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Profile Information</h2>

                @if (session('status') === 'profile-updated')
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                        Profile updated successfully!
                    </div>
                @endif

                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('patch')

                    <!-- Avatar -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <img 
                                    src="{{ $user->avatar ? Storage::url($user->avatar) : '/images/user/owner.png' }}" 
                                    alt="Avatar" 
                                    class="w-24 h-24 rounded-full object-cover border-2 border-gray-200"
                                    id="avatar-preview">
                            </div>
                            <div class="flex-1">
                                <input 
                                    type="file" 
                                    name="avatar" 
                                    id="avatar" 
                                    accept="image/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100"
                                    onchange="previewImage(this)">
                                <p class="mt-1 text-xs text-gray-500">Optional: Upload a new profile picture (max 2MB)</p>
                            </div>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $user->name) }}" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-brand-500 focus:border-brand-500">
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-brand-500 focus:border-brand-500"
                            placeholder="Leave blank to keep current password">
                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-brand-500 focus:border-brand-500"
                            placeholder="Confirm new password">
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center gap-4">
                        <button type="submit" class="px-6 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 font-medium">
                            Save Changes
                        </button>
                        <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </x-common.component-card>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
