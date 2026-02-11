@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Compose Email" />

    <form action="{{ route('email-marketing.send') }}" method="POST" id="emailForm">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Email Content Card -->
                <x-common.component-card title="Email Content">
                    <div class="space-y-4">
                        <!-- Subject -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email Subject <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="subject" 
                                value="{{ old('subject') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                                placeholder="Enter email subject..."
                                required
                            >
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email Message <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                name="message" 
                                rows="12"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                                placeholder="Write your email message here..."
                                required
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-2">
                                💡 Tip: Keep your message clear and concise. Include a call-to-action if needed.
                            </p>
                        </div>
                    </div>
                </x-common.component-card>

                <!-- Recipients Card -->
                <x-common.component-card title="Select Recipients">
                    <div class="space-y-4">
                        <!-- Recipient Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Send To <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-3">
                                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input 
                                        type="radio" 
                                        name="recipients" 
                                        value="all" 
                                        class="w-4 h-4 text-brand-500"
                                        {{ old('recipients') === 'all' ? 'checked' : '' }}
                                        onchange="toggleCustomerSelection()"
                                    >
                                    <span class="ml-3">
                                        <span class="font-medium text-gray-800">All Customers</span>
                                        <span class="block text-sm text-gray-500">Send to all {{ $customers->count() }} customers</span>
                                    </span>
                                </label>

                                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input 
                                        type="radio" 
                                        name="recipients" 
                                        value="selected" 
                                        class="w-4 h-4 text-brand-500"
                                        {{ old('recipients') === 'selected' ? 'checked' : '' }}
                                        onchange="toggleCustomerSelection()"
                                    >
                                    <span class="ml-3">
                                        <span class="font-medium text-gray-800">Selected Customers</span>
                                        <span class="block text-sm text-gray-500">Choose specific customers</span>
                                    </span>
                                </label>
                            </div>
                            @error('recipients')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Customer Selection -->
                        <div id="customerSelection" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Select Customers
                            </label>
                            <div class="border border-gray-300 rounded-lg max-h-64 overflow-y-auto">
                                @forelse($customers as $customer)
                                    <label class="flex items-center p-3 hover:bg-gray-50 border-b border-gray-100 last:border-0 cursor-pointer">
                                        <input 
                                            type="checkbox" 
                                            name="selected_customers[]" 
                                            value="{{ $customer->id }}"
                                            class="w-4 h-4 text-brand-500 rounded"
                                        >
                                        <div class="ml-3 flex-1">
                                            <p class="font-medium text-gray-800">{{ $customer->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $customer->email }}</p>
                                        </div>
                                        <span class="text-xs text-gray-400">
                                            Joined {{ $customer->created_at->format('M Y') }}
                                        </span>
                                    </label>
                                @empty
                                    <p class="p-4 text-center text-gray-500">No customers found</p>
                                @endforelse
                            </div>
                            @error('selected_customers')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-common.component-card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Actions Card -->
                <x-common.component-card title="Actions">
                    <div class="space-y-3">
                        <button 
                            type="submit" 
                            class="w-full px-4 py-3 bg-brand-500 text-white rounded-lg hover:bg-brand-600 font-medium flex items-center justify-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Send Email
                        </button>

                        <button 
                            type="button" 
                            onclick="previewEmail()"
                            class="w-full px-4 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-medium flex items-center justify-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Preview
                        </button>

                        <a 
                            href="{{ route('email-marketing.index') }}" 
                            class="w-full px-4 py-3 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium flex items-center justify-center gap-2"
                        >
                            Cancel
                        </a>
                    </div>
                </x-common.component-card>

                <!-- Tips Card -->
                <x-common.component-card title="Email Tips">
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-600">Use a clear and compelling subject line</p>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-600">Keep your message concise and focused</p>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-600">Include a clear call-to-action</p>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-600">Preview before sending</p>
                        </div>
                    </div>
                </x-common.component-card>
            </div>
        </div>
    </form>

    <script>
        function toggleCustomerSelection() {
            const selectedRadio = document.querySelector('input[name="recipients"]:checked');
            const customerSelection = document.getElementById('customerSelection');
            
            if (selectedRadio && selectedRadio.value === 'selected') {
                customerSelection.classList.remove('hidden');
            } else {
                customerSelection.classList.add('hidden');
            }
        }

        function previewEmail() {
            const subject = document.querySelector('input[name="subject"]').value;
            const message = document.querySelector('textarea[name="message"]').value;
            
            if (!subject || !message) {
                alert('Please fill in both subject and message before previewing.');
                return;
            }
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("email-marketing.preview") }}';
            form.target = '_blank';
            
            const csrfToken = document.querySelector('input[name="_token"]').value;
            form.innerHTML = `
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="subject" value="${subject}">
                <input type="hidden" name="message" value="${message}">
            `;
            
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleCustomerSelection();
        });
    </script>
@endsection
