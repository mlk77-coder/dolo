<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .geometric-pattern {
            background-image: 
                linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                linear-gradient(45deg, rgba(255, 255, 255, 0.05) 25%, transparent 25%),
                linear-gradient(-45deg, rgba(255, 255, 255, 0.05) 25%, transparent 25%);
            background-size: 100% 100%, 40px 40px, 40px 40px;
            background-position: 0 0, 0 0, 20px 20px;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Left Side - Royal Blue Background -->
        <div class="hidden lg:flex lg:w-1/2 bg-[#1e3a8a] geometric-pattern relative overflow-hidden">
            <div class="absolute top-8 left-8">
                <svg class="w-10 h-10 text-white opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            
            <div class="flex flex-col justify-center px-12 py-16 text-white relative z-10">
                <h1 class="text-6xl font-bold mb-6 leading-tight">
                    Hello Admin 👋
                </h1>
                <p class="text-lg text-blue-100 leading-relaxed max-w-md">
                    Skip repetitive and manual sales-marketing tasks. Get highly productive through automation and save tons of time!
                </p>
            </div>
            
            <div class="absolute bottom-8 left-12 text-white text-xs opacity-75">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
        </div>

        <!-- Right Side - White Background with Form -->
        <div class="flex-1 flex flex-col justify-center px-6 sm:px-12 lg:px-16 py-12 bg-white">
            <div class="w-full max-w-md mx-auto">
                <!-- Brand Name -->
                <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ config('app.name') }}</h2>
                
                <!-- Welcome Heading -->
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Welcome Back!</h3>
                
                <!-- Mobile: Show tagline on small screens -->
                <div class="lg:hidden mb-6">
                    <p class="text-gray-600 text-sm">
                        Skip repetitive and manual sales-marketing tasks. Get highly productive through automation and save tons of time!
                    </p>
                </div>
                
             

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Name Field -->
                    <div>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all outline-none"
                            value="{{ old('name') }}" 
                            required 
                            autofocus 
                            autocomplete="name"
                            placeholder="Name"
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Password Field -->
                    <div>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all outline-none"
                            required 
                            autocomplete="current-password"
                            placeholder="Password"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 cursor-pointer" 
                                name="remember"
                            >
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a 
                                href="{{ route('password.request') }}" 
                                class="text-sm text-gray-600 hover:text-gray-900 transition-colors"
                            >
                                Forget password? <span class="text-gray-900 font-medium">Click here</span>
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button 
                            type="submit" 
                            class="w-full bg-gray-900 hover:bg-gray-800 text-white font-medium py-3 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg"
                        >
                            Login Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
