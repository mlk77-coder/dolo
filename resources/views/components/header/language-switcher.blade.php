@php
    use Illuminate\Support\Facades\Session;
    $currentLocale = Session::get('locale', app()->getLocale());
@endphp

<div class="relative" x-data="{
    dropdownOpen: false,
    toggleDropdown() {
        this.dropdownOpen = !this.dropdownOpen;
    },
    closeDropdown() {
        this.dropdownOpen = false;
    },
    switchLanguage(locale) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('language.switch') }}';
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        
        const localeInput = document.createElement('input');
        localeInput.type = 'hidden';
        localeInput.name = 'locale';
        localeInput.value = locale;
        form.appendChild(localeInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}" @click.away="closeDropdown()">
    <!-- Language Button -->
    <button
        class="relative flex items-center justify-center text-gray-500 transition-colors bg-white border border-gray-200 rounded-full hover:text-dark-900 h-11 w-11 hover:bg-gray-100 hover:text-gray-700"
        @click.prevent="toggleDropdown()"
        type="button"
        title="Switch Language"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
        </svg>
    </button>

    <!-- Dropdown -->
    <div
        x-show="dropdownOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute {{ $currentLocale === 'ar' ? 'left-0' : 'right-0' }} mt-2 w-40 rounded-lg border border-gray-200 bg-white shadow-lg z-50"
        style="display: none;"
    >
        <div class="py-1">
            <button
                @click="switchLanguage('en'); closeDropdown();"
                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 {{ $currentLocale === 'en' ? 'bg-gray-50 font-medium' : '' }}"
            >
                <span class="text-lg">🇬🇧</span>
                <span>English</span>
                @if($currentLocale === 'en')
                    <svg class="w-4 h-4 {{ $currentLocale === 'ar' ? 'mr-auto' : 'ml-auto' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                @endif
            </button>
            <button
                @click="switchLanguage('ar'); closeDropdown();"
                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 {{ $currentLocale === 'ar' ? 'bg-gray-50 font-medium' : '' }}"
            >
                <span class="text-lg">🇸🇦</span>
                <span>العربية</span>
                @if($currentLocale === 'ar')
                    <svg class="w-4 h-4 {{ $currentLocale === 'ar' ? 'mr-auto' : 'ml-auto' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                @endif
            </button>
        </div>
    </div>
</div>

