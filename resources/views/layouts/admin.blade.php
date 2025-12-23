<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="h-full">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $title ?? 'Dashboard' }} | {{ config('app.name') }}</title>

    {{-- Vite / Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                theme: 'light',
                init() {
                    const saved = localStorage.getItem('theme');
                    const system = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                    this.theme = saved || system;
                    this.updateTheme();
                },
                toggle() {
                    this.theme = this.theme === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', this.theme);
                    this.updateTheme();
                },
                updateTheme() {
                    if (this.theme === 'dark') {
                        document.documentElement.classList.add('dark');
                        document.body.classList.add('dark', 'bg-gray-900');
                    } else {
                        document.documentElement.classList.remove('dark');
                        document.body.classList.remove('dark', 'bg-gray-900');
                    }
                }
            });

            Alpine.store('sidebar', {
                // default for desktop
                isExpanded: window.innerWidth >= 1280,
                isMobileOpen: false,
                isHovered: false,

                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    this.isMobileOpen = false;
                },
                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;
                },
                setMobileOpen(val) {
                    this.isMobileOpen = val;
                },
                setHovered(val) {
                    if (window.innerWidth >= 1280 && !this.isExpanded) {
                        this.isHovered = val;
                    } else {
                        this.isHovered = false;
                    }
                }
            });
        });
    </script>

    {{-- Prevent flash of theme --}}
    <script>
        (function(){
            const saved = localStorage.getItem('theme');
            const system = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = saved || system;
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark', 'bg-gray-900');
            } else {
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('dark', 'bg-gray-900');
            }
        })();
    </script>

    <style>
        /* Minimal helpers to ensure RTL flipped spacing when dir=rtl
           We avoid heavy overrides. Tailwind handles most cases.
           Keep this tiny snippet only if you want a couple of small directional helpers. */
        [dir="rtl"] .rtl\:ml-auto { margin-left: 0 !important; margin-right: auto !important; }
        [dir="rtl"] .rtl\:mr-auto { margin-right: 0 !important; margin-left: auto !important; }
    </style>
</head>
<body class="h-full" x-data x-init="$store.sidebar.isExpanded = window.innerWidth >= 1280;
    const checkMobile = () => {
        if (window.innerWidth < 1280) {
            $store.sidebar.setMobileOpen(false);
            $store.sidebar.isExpanded = false;
        } else {
            $store.sidebar.isMobileOpen = false;
            $store.sidebar.isExpanded = true;
        }
    };
    window.addEventListener('resize', checkMobile);
">

    {{-- Preloader --}}
    <x-common.preloader />
    {{-- End preloader --}}

    <div class="flex h-screen overflow-hidden bg-gray-100 dark:bg-gray-900">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Content area: adjust margin depending on sidebar expanded/collapsed and locale --}}
        @php $isRTL = app()->getLocale() === 'ar'; @endphp
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden transition-all duration-300"
             :class="{
                @if($isRTL)
                    'xl:mr-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
                    'xl:mr-[290px]': $store.sidebar.isExpanded || $store.sidebar.isHovered
                @else
                    'xl:ml-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
                    'xl:ml-[290px]': $store.sidebar.isExpanded || $store.sidebar.isHovered
                @endif
             }">

            {{-- Header --}}
            @include('layouts.app-header')

            {{-- Main content --}}
            <main class="p-4 md:p-6 xl:p-10">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Mobile overlay for when sidebar open --}}
    <div x-show="$store.sidebar.isMobileOpen" @click="$store.sidebar.setMobileOpen(false)" class="fixed inset-0 z-40 bg-black/50 xl:hidden"></div>

</body>

@stack('scripts')
</html>
