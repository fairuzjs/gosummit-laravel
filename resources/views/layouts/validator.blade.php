<!-- resources/views/layouts/validator.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Validator')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        .animate-slide-in {
            animation: slideInRight 0.4s ease-out;
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{ profileDropdownOpen: false }">
    <div class="min-h-screen flex flex-col">

        <!-- Navbar Validator -->
        <nav class="bg-gradient-to-r from-green-600 to-emerald-600 shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    
                    <!-- Logo & Brand -->
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <div class="hidden sm:block">
                            <h1 class="text-white font-bold text-lg">Validator Panel</h1>
                            <p class="text-green-100 text-xs">Field Check-in System</p>
                        </div>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('validator.bookings.index') }}" 
                           class="px-4 py-2 rounded-lg text-white hover:bg-white/20 transition-all duration-200 {{ request()->routeIs('validator.bookings.index') ? 'bg-white/20 font-semibold' : '' }}">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Bookings
                        </a>
                        
                        <a href="{{ route('validator.bookings.scanner') }}" 
                           class="px-4 py-2 rounded-lg text-white hover:bg-white/20 transition-all duration-200 {{ request()->routeIs('validator.bookings.scanner') ? 'bg-white/20 font-semibold' : '' }}">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                            QR Scanner
                        </a>
                    </div>

                    <!-- Right Side: Profile Dropdown & Mobile Menu -->
                    <div class="flex items-center space-x-3">
                        
                        <!-- Profile Dropdown (Desktop & Mobile) -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="flex items-center space-x-2 bg-white/10 hover:bg-white/20 px-3 py-2 rounded-xl backdrop-blur-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-white/50">
                                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div class="hidden sm:block text-left">
                                    <p class="text-white font-semibold text-sm leading-tight">{{ auth()->guard('validator')->user()->name }}</p>
                                    <p class="text-green-100 text-xs">Validator</p>
                                </div>
                                <svg class="w-4 h-4 text-white transition-transform duration-200" 
                                     :class="{ 'rotate-180': open }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-95"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl overflow-hidden z-50"
                                 style="display: none;">
                                
                                <!-- User Info -->
                                <div class="px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white">
                                    <p class="text-sm font-semibold">{{ auth()->guard('validator')->user()->name }}</p>
                                    <p class="text-xs text-green-100 mt-1">{{ auth()->guard('validator')->user()->email }}</p>
                                    <span class="inline-block mt-2 px-2 py-1 bg-white/20 text-xs font-semibold rounded-full">Validator</span>
                                </div>

                                <!-- Logout -->
                                <div class="border-t border-gray-100">
                                    <form method="POST" action="{{ route('validator.logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors font-semibold">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile/Hamburger Menu Button -->
                        <div class="relative md:hidden" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="inline-flex items-center px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                                <span class="ml-2">Menu</span>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-56 rounded-xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 z-50"
                                 style="display: none;">
                                <div class="py-2">
                                    <a href="{{ route('validator.bookings.index') }}" 
                                       class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('validator.bookings.index') ? 'bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50' }} transition-all duration-200">
                                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('validator.bookings.index') ? 'text-green-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        Bookings
                                    </a>
                                    
                                    <a href="{{ route('validator.bookings.scanner') }}" 
                                       class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('validator.bookings.scanner') ? 'bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50' }} transition-all duration-200">
                                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('validator.bookings.scanner') ? 'text-green-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                        </svg>
                                        QR Scanner
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 p-4 sm:p-6 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                
                {{-- Main Content --}}
                @yield('content')

            </div>
        </main>

        {{-- Success Notification (Floating) --}}
        @if (session('success'))
            <div id="notification" class="fixed top-20 right-4 z-50 max-w-sm w-full px-4 sm:px-0">
                <div class="bg-white border-l-4 border-green-500 rounded-lg shadow-lg backdrop-blur-sm animate-slide-in">
                    <div class="flex items-start gap-3 p-3">
                        <div class="bg-green-100 rounded-full p-1.5 flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-gray-800 leading-tight">{{ session('success') }}</p>
                        </div>
                        <button onclick="document.getElementById('notification').remove()" class="text-gray-400 hover:text-gray-600 transition-colors flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Error Notification (Floating) --}}
        @if (session('error'))
            <div id="notification" class="fixed top-20 right-4 z-50 max-w-sm w-full px-4 sm:px-0">
                <div class="bg-white border-l-4 border-red-500 rounded-lg shadow-lg backdrop-blur-sm animate-slide-in">
                    <div class="flex items-start gap-3 p-3">
                        <div class="bg-red-100 rounded-full p-1.5 flex-shrink-0">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-gray-800 leading-tight">{{ session('error') }}</p>
                        </div>
                        <button onclick="document.getElementById('notification').remove()" class="text-gray-400 hover:text-gray-600 transition-colors flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
                <div class="text-center text-sm text-gray-600">
                    <p>&copy; {{ date('Y') }} GoSummit. Validator Panel - Field Check-in System.</p>
                </div>
            </div>
        </footer>
    </div>

    {{-- Auto-hide notification script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notification = document.getElementById('notification');

            if (notification) {
                setTimeout(function () {
                    notification.style.transition = 'opacity 0.5s ease-out';
                    notification.style.opacity = '0';
                    setTimeout(() => {
                        notification.remove();
                    }, 500);
                }, 3000);

                notification.addEventListener('click', function () {
                    this.style.transition = 'opacity 0.5s ease-out';
                    this.style.opacity = '0';
                    setTimeout(() => {
                        this.remove();
                    }, 500);
                });
            }
        });
    </script>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @stack('scripts')
</body>
</html>
