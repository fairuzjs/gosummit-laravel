{{-- Modern Premium Header Component --}}
<nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
    {{-- Logo --}}
    <div class="flex items-center space-x-2">
        <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
            <svg class="w-8 h-8 text-purple-600 group-hover:scale-110 transition-transform duration-200" fill="currentColor" viewBox="0 0 24 24">
                <path d="M14 6l-4.22 5.63 1.25 1.67L14 9.33 19 16h-8.46l-4.01-5.37L1 18h22L14 6zM5 16l1.52-2.03L8.04 16H5z"/>
            </svg>
            <span class="text-xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                GoSummit
            </span>
        </a>
    </div>

    {{-- Navigation di Tengah --}}
    <div class="hidden md:flex flex-1 justify-center items-center space-x-1">
        <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-all {{ request()->routeIs('home') ? 'text-purple-600 bg-purple-50' : '' }}">
            Home
        </a>
        <a href="{{ route('mountains.list') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-all {{ request()->routeIs('mountains.*') ? 'text-purple-600 bg-purple-50' : '' }}">
            Explore Mountains
        </a>
        <a href="{{ route('news.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-all {{ request()->routeIs('news.*') ? 'text-purple-600 bg-purple-50' : '' }}">
            News
        </a>
        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-all {{ request()->routeIs('dashboard') ? 'text-purple-600 bg-purple-50' : '' }}">
            Dashboard
        </a>
    </div>

            {{-- Right Section --}}
            <div class="flex items-center space-x-3">
                {{-- Language Switcher --}}
                <x-language-switcher />
                
                @auth
                    {{-- User Menu --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover ring-2 ring-purple-100">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-600 to-blue-600 flex items-center justify-center text-white font-bold text-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <span class="hidden sm:block text-sm font-medium text-gray-700">{{ Str::limit(Auth::user()->name, 15) }}</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 py-1 z-50" style="display: none;">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Profile Settings</span>
                            </a>
                            <a href="{{ route('bookings.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span>My Bookings</span>
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center space-x-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors w-full text-left">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    {{-- Guest Actions --}}
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:text-purple-600 transition-colors">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                        Get Started
                    </a>
                @endauth

                {{-- Mobile Menu Button --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
<div 
        x-show="mobileMenuOpen" 
        x-transition:enter="transition ease-out duration-200" 
        x-transition:enter-start="transform opacity-0 scale-95" 
        x-transition:enter-end="transform opacity-100 scale-100" 
        x-transition:leave="transition ease-in duration-150" 
        x-transition:leave-start="transform opacity-100 scale-100" 
        x-transition:leave-end="transform opacity-0 scale-95"
        @click.away="mobileMenuOpen = false"
        class="md:hidden absolute top-full right-4 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden z-50"
        style="display: none;"
    >    
        <nav class="py-1.5">
            <div class="space-y-0.5">
                <!-- Home -->
                <a href="{{ route('home') }}" 
                   class="group flex items-center gap-2.5 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-indigo-50 hover:text-purple-600 transition-all duration-200 active:scale-[0.98]">
                    Home
                </a>

                <!-- Explore Mountains -->
                <a href="{{ route('mountains.list') }}" 
                   class="group flex items-center gap-2.5 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-indigo-50 hover:text-purple-600 transition-all duration-200 active:scale-[0.98]">
                    Explore Mountains
                </a>

                <!-- News -->
                <a href="{{ route('news.index') }}" 
                   class="group flex items-center gap-2.5 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-indigo-50 hover:text-purple-600 transition-all duration-200 active:scale-[0.98]">
                    News
                </a>

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   class="group flex items-center gap-2.5 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-indigo-50 hover:text-purple-600 transition-all duration-200 active:scale-[0.98]">
                    Dashboard
                </a>

                @guest
                    <!-- Divider -->
                    <div class="my-1 border-t border-gray-200"></div>
                    
                    <!-- Sign In -->
                    <a href="{{ route('login') }}" 
                       class="group flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-purple-600 hover:bg-gradient-to-r hover:from-purple-50 hover:to-indigo-50 transition-all duration-200 active:scale-[0.98]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span>Sign In</span>
                    </a>
                @endguest
            </div>
        </nav>
    </div>
</nav>
