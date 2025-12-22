@php
    use App\Helpers\MenuHelper;
    $menuGroups = MenuHelper::getMenuGroups();
    $currentPath = request()->path();
    $isRTL = app()->getLocale() === 'ar';
@endphp

<aside id="sidebar"
    class="fixed top-0 h-screen px-5 pt-0 pb-6 bg-white text-gray-900 border-gray-200 z-50 transition-transform duration-300 ease-in-out overflow-hidden"
    :class="{
        // widths
        'w-[290px]': $store.sidebar.isExpanded || $store.sidebar.isMobileOpen || $store.sidebar.isHovered,
        'w-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen,
        // position anchor (RTL vs LTR) — use Blade to set the anchor class
        '{{ $isRTL ? "right-0 border-l" : "left-0 border-r" }}': true,
        // show / hide transform for mobile: when mobile open show translate-x-0
        // for desktop hidden state we toggle depending on locale:
        // - LTR hide to left (-translate-x-full)
        // - RTL hide to right (translate-x-full)
        'translate-x-0': $store.sidebar.isMobileOpen,
        @if($isRTL)
            'translate-x-full xl:translate-x-0': !$store.sidebar.isMobileOpen
        @else
            '-translate-x-full xl:translate-x-0': !$store.sidebar.isMobileOpen
        @endif
    }"
    x-data="{
        openSubmenus: {},
        init() {
            this.initializeActiveMenus();
        },
        initializeActiveMenus() {
            const currentPath = '{{ $currentPath }}';
            @foreach ($menuGroups as $groupIndex => $menuGroup)
                @foreach ($menuGroup['items'] as $itemIndex => $item)
                    @if (isset($item['subItems']))
                        @foreach ($item['subItems'] as $subItem)
                            if (currentPath === '{{ ltrim($subItem['path'], '/') }}' ||
                                window.location.pathname === '{{ $subItem['path'] }}') {
                                this.openSubmenus['{{ $groupIndex }}-{{ $itemIndex }}'] = true;
                            }
                        @endforeach
                    @endif
                @endforeach
            @endforeach
        },
        toggleSubmenu(groupIndex, itemIndex) {
            const key = groupIndex + '-' + itemIndex;
            const newState = !this.openSubmenus[key];

            if (newState) {
                // close others (optional)
                this.openSubmenus = {};
            }
            this.openSubmenus[key] = newState;
        },
        isSubmenuOpen(groupIndex, itemIndex) {
            const key = groupIndex + '-' + itemIndex;
            return this.openSubmenus[key] || false;
        },
        isActive(path) {
            return window.location.pathname === path || '{{ $currentPath }}' === path.replace(/^\//, '');
        }
    }"
    @mouseenter="if (window.innerWidth >= 1280 && !$store.sidebar.isExpanded) $store.sidebar.setHovered(true)"
    @mouseleave="if (window.innerWidth >= 1280) $store.sidebar.setHovered(false)">

    {{-- Logo / Top --}}
    <div class="flex items-center pb-6 pt-8"
        :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'justify-center' : 'justify-start'">
        <a href="/" class="flex items-center">
            <h1 x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                class="text-2xl font-bold text-brand-600 dark:text-brand-400 transition-opacity duration-200">Doli</h1>
            <span x-show="!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen"
                class="text-xl font-bold text-brand-600 dark:text-brand-400">D</span>
        </a>
    </div>

    {{-- Nav --}}
    <div class="flex flex-col h-full overflow-y-auto no-scrollbar">
        <nav class="mb-6">
            <div class="flex flex-col gap-4">
                @foreach ($menuGroups as $groupIndex => $menuGroup)
                    <div>
                        <h2 class="mb-4 text-xs uppercase leading-[20px] text-gray-400"
                            :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'flex justify-center' : 'flex justify-start'">
                            <template x-if="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                                <span>{{ $menuGroup['title'] }}</span>
                            </template>
                            <template x-if="!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen">
                                {{-- small icon placeholder when collapsed --}}
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z" fill="currentColor"/>
                                </svg>
                            </template>
                        </h2>

                        <ul class="flex flex-col gap-1">
                            @foreach ($menuGroup['items'] as $itemIndex => $item)
                                <li>
                                    @if (isset($item['subItems']))
                                        <button @click="toggleSubmenu({{ $groupIndex }}, {{ $itemIndex }})"
                                            class="menu-item group w-full flex items-center px-2 py-2 rounded-md transition-colors"
                                            :class="[
                                                isSubmenuOpen({{ $groupIndex }}, {{ $itemIndex }}) ? 'bg-gray-100 text-brand-600' : 'text-gray-700',
                                                (!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'justify-center' : 'justify-start'
                                            ]">

                                            {{-- Chevron (position depends on locale) --}}
                                            @if($isRTL)
                                                <svg x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                    class="w-5 h-5 transition-transform duration-200 mr-2"
                                                    :class="{'rotate-180 text-brand-500': isSubmenuOpen({{ $groupIndex }}, {{ $itemIndex }})}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            @endif

                                            {{-- Icon --}}
                                            <span :class="isSubmenuOpen({{ $groupIndex }}, {{ $itemIndex }}) ? 'text-brand-600' : ''">
                                                {!! MenuHelper::getIconSvg($item['icon']) !!}
                                            </span>

                                            {{-- Text --}}
                                            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="ml-3 flex-1 text-sm">
                                                {{ $item['name'] }}
                                            </span>

                                            @if(!$isRTL)
                                                <svg x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                    class="w-5 h-5 transition-transform duration-200 ml-auto"
                                                    :class="{'rotate-180 text-brand-500': isSubmenuOpen({{ $groupIndex }}, {{ $itemIndex }})}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            @endif
                                        </button>

                                        {{-- Submenu --}}
                                        <div x-show="isSubmenuOpen({{ $groupIndex }}, {{ $itemIndex }}) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)"
                                            x-collapse>
                                            <ul class="mt-2 space-y-1 px-3">
                                                @foreach ($item['subItems'] as $subItem)
                                                    <li>
                                                        <a href="{{ $subItem['path'] }}" class="flex items-center rounded-md px-2 py-2 text-sm"
                                                            :class="isActive('{{ $subItem['path'] }}') ? 'bg-brand-50 text-brand-600' : 'text-gray-600 hover:bg-gray-50'">
                                                            <span class="flex-1">{{ $subItem['name'] }}</span>
                                                            @if(!empty($subItem['new']))
                                                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-brand-500 text-white">new</span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <a href="{{ $item['path'] }}" class="menu-item group flex items-center px-2 py-2 rounded-md transition-colors"
                                            :class="[
                                                isActive('{{ $item['path'] }}') ? 'bg-brand-50 text-brand-600' : 'text-gray-700',
                                                (!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'justify-center' : 'justify-start'
                                            ]">

                                            <span :class="isActive('{{ $item['path'] }}') ? 'text-brand-600' : ''">
                                                {!! MenuHelper::getIconSvg($item['icon']) !!}
                                            </span>

                                            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="ml-3 text-sm">
                                                {{ $item['name'] }}
                                                @if (!empty($item['new']))
                                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-brand-500 text-white">new</span>
                                                @endif
                                            </span>
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </nav>

        {{-- Sidebar widget shown only when expanded --}}
        <div x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="mt-auto px-2" x-transition>
            @include('layouts.sidebar-widget')
        </div>
    </div>
</aside>

{{-- Mobile overlay (for small screens) --}}
<div x-show="$store.sidebar.isMobileOpen" @click="$store.sidebar.setMobileOpen(false)"
     class="fixed inset-0 z-40 bg-black/50 xl:hidden"></div>
