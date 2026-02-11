@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Email Marketing" />

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-red-800">{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Stats Card 1 -->
        <x-common.component-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Total Customers</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ number_format($stats['total_customers']) }}</h3>
                    <p class="text-gray-500 text-xs mt-1">with email addresses</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </x-common.component-card>

        <!-- Stats Card 2 -->
        <x-common.component-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Verified Emails</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ number_format($stats['verified_emails']) }}</h3>
                    <p class="text-gray-500 text-xs mt-1">email verified customers</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </x-common.component-card>
    </div>

    <x-common.component-card>
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Email Marketing</h2>
                <p class="text-gray-500 text-sm mt-1">Send promotional emails to your customers</p>
            </div>
            <a href="{{ route('email-marketing.create') }}" class="px-6 py-3 bg-brand-500 text-white rounded-lg hover:bg-brand-600 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Compose Email
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Feature 1 -->
            <div class="p-6 border border-gray-200 rounded-lg">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Select Recipients</h3>
                        <p class="text-gray-600 text-sm">Choose to send to all customers or select specific ones</p>
                    </div>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="p-6 border border-gray-200 rounded-lg">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Compose Message</h3>
                        <p class="text-gray-600 text-sm">Write your email subject and message content</p>
                    </div>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="p-6 border border-gray-200 rounded-lg">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Preview Email</h3>
                        <p class="text-gray-600 text-sm">Preview how your email will look before sending</p>
                    </div>
                </div>
            </div>

            <!-- Feature 4 -->
            <div class="p-6 border border-gray-200 rounded-lg">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Send Instantly</h3>
                        <p class="text-gray-600 text-sm">Emails are sent immediately to selected recipients</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-blue-800 font-medium">Email Configuration Required</p>
                    <p class="text-blue-700 text-sm mt-1">Make sure your email settings are configured in the .env file (MAIL_* variables) before sending emails.</p>
                </div>
            </div>
        </div>
    </x-common.component-card>
@endsection
