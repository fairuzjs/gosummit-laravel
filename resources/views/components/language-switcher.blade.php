{{-- Language Switcher Component --}}
<div class="relative" x-data="{ open: false }">
    <button 
        @click="open = !open" 
        class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors"
        aria-label="Change Language"
    >
        {{-- Globe Icon --}}
        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
        </svg>
        
        {{-- Current Language --}}
        <span class="hidden sm:block text-sm font-medium text-gray-700">
            {{ app()->getLocale() == 'id' ? 'ID' : 'EN' }}
        </span>
        
        {{-- Dropdown Arrow --}}
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    {{-- Dropdown Menu --}}
    <div 
        x-show="open" 
        @click.away="open = false" 
        x-transition:enter="transition ease-out duration-100" 
        x-transition:enter-start="transform opacity-0 scale-95" 
        x-transition:enter-end="transform opacity-100 scale-100" 
        x-transition:leave="transition ease-in duration-75" 
        x-transition:leave-start="transform opacity-100 scale-100" 
        x-transition:leave-end="transform opacity-0 scale-95" 
        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 py-1 z-50" 
        style="display: none;"
    >
        {{-- Indonesian --}}
        <a 
            href="{{ route('language.switch', 'id') }}" 
            class="flex items-center space-x-3 px-4 py-2.5 text-sm hover:bg-purple-50 transition-colors {{ app()->getLocale() == 'id' ? 'bg-purple-50 text-purple-600' : 'text-gray-700' }}"
        >
            <span class="text-2xl">🇮🇩</span>
            <div class="flex-1">
                <div class="font-medium">Indonesia</div>
                <div class="text-xs text-gray-500">Bahasa Indonesia</div>
            </div>
            @if(app()->getLocale() == 'id')
                <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            @endif
        </a>

        {{-- English --}}
        <a 
            href="{{ route('language.switch', 'en') }}" 
            class="flex items-center space-x-3 px-4 py-2.5 text-sm hover:bg-purple-50 transition-colors {{ app()->getLocale() == 'en' ? 'bg-purple-50 text-purple-600' : 'text-gray-700' }}"
        >
            <span class="text-2xl">🇬🇧</span>
            <div class="flex-1">
                <div class="font-medium">English</div>
                <div class="text-xs text-gray-500">English (US)</div>
            </div>
            @if(app()->getLocale() == 'en')
                <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            @endif
        </a>
    </div>
</div>
