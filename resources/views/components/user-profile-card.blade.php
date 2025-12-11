@php
    $user = auth()->user();

    $totalBookings = $user->bookings()
                          ->whereIn('status', ['paid', 'checked_in', 'completed'])
                          ->count();

    $totalMountains = $user->bookings()
                           ->where('status', 'completed')
                           ->distinct('mountain_id')
                           ->count();

    // Avatar integration - same as profile page
    $avatarUrl = $user->profile_picture 
        ? asset('storage/' . $user->profile_picture)
        : "https://ui-avatars.com/api/?name=" . urlencode($user->name) . "&color=FFFFFF&background=8B5CF6&bold=true&size=200";

    // Simplified badge system - Premium Glass Morphism
    $badge = [
        'title' => 'Pendaki Pemula',
        'icon' => 'sparkles',
        'gradient' => 'from-slate-400/80 to-gray-400/80',
        'textColor' => 'text-white',
        'iconColor' => 'text-slate-200'
    ];

    if ($totalBookings >= 20 || $totalMountains >= 10) {
        $badge = [
            'title' => 'Pendaki Legendaris',
            'icon' => 'star',
            'gradient' => 'from-purple-500/80 to-fuchsia-500/80',
            'textColor' => 'text-white',
            'iconColor' => 'text-purple-200'
        ];
    } elseif ($totalBookings >= 10 || $totalMountains >= 5) {
        $badge = [
            'title' => 'Pendaki Profesional',
            'icon' => 'star',
            'gradient' => 'from-amber-400/80 to-yellow-400/80',
            'textColor' => 'text-amber-900',
            'iconColor' => 'text-amber-600'
        ];
    } elseif ($totalBookings >= 5 || $totalMountains >= 3) {
        $badge = [
            'title' => 'Pendaki Berpengalaman',
            'icon' => 'star',
            'gradient' => 'from-gray-300/80 to-slate-300/80',
            'textColor' => 'text-gray-800',
            'iconColor' => 'text-gray-600'
        ];
    } elseif ($totalBookings >= 1) {
        $badge = [
            'title' => 'Pendaki Aktif',
            'icon' => 'fire',
            'gradient' => 'from-orange-400/80 to-amber-500/80',
            'textColor' => 'text-orange-900',
            'iconColor' => 'text-orange-600'
        ];
    }
@endphp

<!-- Premium Glass Morphism Profile Card -->
<div class="w-full bg-gradient-to-br from-white/95 to-gray-50/95 backdrop-blur-xl overflow-hidden shadow-2xl rounded-2xl border border-white/20">
    <!-- Glass Header with Gradient Overlay -->
    <div class="relative h-32 overflow-hidden">
        <!-- Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-purple-600/90 via-blue-600/90 to-indigo-600/90"></div>
        
        <!-- Glass Overlay -->
        <div class="absolute inset-0 backdrop-blur-sm bg-white/5"></div>
        
        <!-- Subtle Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-purple-300 rounded-full blur-2xl"></div>
        </div>

        <!-- Avatar (Overlapping) -->
        <div class="absolute left-4 sm:left-6 top-1/2 transform -translate-y-1/2 z-10">
            <div class="relative">
                <img class="h-16 w-16 sm:h-20 sm:w-20 rounded-full object-cover border-4 border-white/30 shadow-2xl backdrop-blur-md ring-2 ring-white/10"
                     src="{{ $avatarUrl }}"
                     alt="{{ $user->name }}">
                <!-- Online Status -->
                <div class="absolute -bottom-1 -right-1 bg-green-500 h-4 w-4 sm:h-5 sm:w-5 rounded-full border-4 border-white/40 shadow-lg"></div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="pt-6 px-4 sm:px-6 pb-6">
        <div class="flex flex-col gap-4">
            <!-- User Info -->
            <div class="flex-1 min-w-0">
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-1 truncate">{{ $user->name }}</h3>
                <p class="text-xs text-gray-500 mb-3 flex items-center truncate">
                    <svg class="w-3.5 h-3.5 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="truncate">{{ $user->email }}</span>
                </p>

                <!-- Glass Badge - Compact & Elegant -->
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-gradient-to-r {{ $badge['gradient'] }} backdrop-blur-md border border-white/30 shadow-lg hover:scale-105 transition-transform duration-300">
                    <!-- Icon -->
                    @if($badge['icon'] === 'star')
                        <svg class="w-4 h-4 {{ $badge['iconColor'] }}" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    @elseif($badge['icon'] === 'fire')
                        <svg class="w-4 h-4 {{ $badge['iconColor'] }}" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 23C7.03 23 3 18.97 3 14c0-3.09 1.58-5.64 3.5-7.5C8.42 4.58 10.97 3 14 3c.34 0 .67.03 1 .08V1l6 4-6 4V6.09c-.33-.05-.66-.09-1-.09-2.03 0-3.92.78-5.34 2.2C7.28 9.62 6.5 11.51 6.5 14c0 3.03 2.47 5.5 5.5 5.5s5.5-2.47 5.5-5.5h3c0 4.97-4.03 9-9 9z"/>
                        </svg>
                    @else
                        <svg class="w-4 h-4 {{ $badge['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    @endif
                    
                    <!-- Badge Text -->
                    <span class="text-sm font-bold {{ $badge['textColor'] }} whitespace-nowrap">{{ $badge['title'] }}</span>
                </div>
            </div>
        </div>

        <!-- Glass Stats Cards -->
        <div class="mt-6 grid grid-cols-2 gap-3 sm:gap-4">
            <!-- Total Trips -->
            <div class="bg-white/40 backdrop-blur-md rounded-xl p-4 border border-white/30 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $totalBookings }}</p>
                        <p class="text-xs text-gray-600 mt-1">Total Trips</p>
                    </div>
                    <div class="bg-blue-500/20 backdrop-blur-sm rounded-full p-2.5">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Mountains Conquered -->
            <div class="bg-white/40 backdrop-blur-md rounded-xl p-4 border border-white/30 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $totalMountains }}</p>
                        <p class="text-xs text-gray-600 mt-1">Mountains</p>
                    </div>
                    <div class="bg-green-500/20 backdrop-blur-sm rounded-full p-2.5">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Glass Action Button -->
        <a href="{{ route('profile.edit') }}"
           class="mt-5 w-full flex items-center justify-center px-4 py-3 border border-white/30 text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-purple-600/90 to-indigo-600/90 backdrop-blur-md hover:from-purple-700/90 hover:to-indigo-700/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Profile
        </a>
    </div>
</div>