<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $user->name }} - {{ __('User Profile') }} | {{ config('app.name', 'GoSummit') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 min-h-screen">
    
    <!-- Header -->
    <x-modern-header />

    <!-- Top Banner Background -->
    <div class="relative h-48 md:h-64 w-full overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-violet-600 via-purple-600 to-indigo-600">
            <!-- Decorative Patterns -->
            <div class="absolute top-0 left-0 w-full h-full opacity-10" 
                 style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-slate-50 to-transparent"></div>
        </div>
        
        <!-- Breadcrumb & Back Button (Only show if viewing other user's profile) -->
        @if(!Auth::check() || Auth::id() !== $user->id)
            <div class="absolute top-4 md:top-8 left-0 w-full z-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <a href="{{ route('leaderboard.index') }}" class="inline-flex items-center gap-2 text-white/90 hover:text-white hover:bg-white/10 px-3 py-1.5 md:px-4 md:py-2 rounded-full transition-all duration-200 backdrop-blur-sm bg-black/5 md:bg-transparent">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="font-medium text-xs md:text-sm">{{ __('Back to Leaderboard') }}</span>
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Main Content Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 md:-mt-20 relative z-10 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Sidebar: Profile Card & Stats -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Profile Identity Card -->
                <div class="bg-white rounded-3xl shadow-xl border border-slate-100 relative">
                    <div class="p-6 pb-8 text-center">
                        <!-- Avatar -->
                        <div class="relative w-40 h-40 mx-auto -mt-20 mb-4 group">
                            <div class="absolute inset-0 bg-purple-600 rounded-3xl rotate-3 opacity-20 group-hover:rotate-6 transition-transform duration-300"></div>
                            @if($user->profile_picture)
                                <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                     alt="{{ $user->name }}" 
                                     class="relative w-full h-full rounded-3xl object-cover border-[6px] border-white shadow-lg bg-white">
                            @else
                                <div class="relative w-full h-full rounded-3xl bg-gradient-to-br from-violet-100 to-purple-100 border-[6px] border-white shadow-lg flex items-center justify-center">
                                    <span class="text-violet-600 text-5xl font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                            <!-- Verified Badge -->
                            <div class="absolute -bottom-2 -right-2 bg-white rounded-full p-1.5 shadow-md" title="Verified Member">
                                <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Name & Email -->
                        <h1 class="text-2xl font-bold text-slate-900 mb-1">{{ $user->name }}</h1>
                        @if($privacy['show_email'])
                            <p class="text-slate-500 text-sm flex items-center justify-center gap-1.5 mb-4">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ $user->email }}
                            </p>
                        @endif

                        <!-- Mini Action Buttons (Only show if viewing other user's profile) -->
                        @if(!Auth::check() || Auth::id() !== $user->id)
                            <div class="flex justify-center gap-3 mt-4">
                                <button class="px-6 py-2 bg-slate-900 text-white rounded-xl text-sm font-medium shadow-lg hover:bg-slate-800 transition-colors">
                                    Follow
                                </button>
                                <button class="p-2 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Key Stats Row -->
                    <div class="grid grid-cols-2 divide-x divide-slate-100 border-t border-slate-100 bg-slate-50/50 rounded-b-3xl">
                        <div class="p-4 text-center hover:bg-slate-50 transition-colors">
                            <span class="block text-2xl font-bold text-slate-900">{{ $statistic->total_bookings ?? 0 }}</span>
                            <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Bookings</span>
                        </div>
                        <div class="p-4 text-center hover:bg-slate-50 transition-colors">
                            <span class="block text-2xl font-bold text-emerald-600">{{ $statistic->completed_bookings ?? 0 }}</span>
                            <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Completed</span>
                        </div>
                    </div>
                </div>

                <!--  Financial Stats Card -->
                <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Total Spent
                    </h3>
                    
                    @if($privacy['show_total_spent'])
                        <div class="relative pt-2">
                            <span class="text-3xl font-bold text-slate-900 tracking-tight">
                                <span class="text-lg text-slate-400 align-top mr-1">Rp</span>{{ number_format($totalSpent, 0, ',', '.') }}
                            </span>
                            <div class="mt-2 text-xs text-slate-500">Lifetime expenditure on trips</div>
                        </div>
                    @else
                        <div class="bg-slate-50 rounded-xl p-4 border border-dashed border-slate-200 text-center">
                            <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <span class="text-sm text-slate-400 font-medium">Hidden by User</span>
                        </div>
                    @endif
                </div>

                @php
                    // Badge system - same as user-profile-card
                    $totalBookings = $statistic->total_bookings ?? 0;
                    $totalMountains = $uniqueMountains->count();
                    
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

                <!-- Achievements / Badge Card -->
                <div class="bg-gradient-to-br {{ $badge['gradient'] }} backdrop-blur-md rounded-3xl shadow-lg p-6 border border-white/30 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-sm font-bold {{ $badge['textColor'] }} uppercase tracking-wider mb-4 flex items-center gap-2">
                            Achievement Badge
                        </h3>
                        
                        <!-- Badge Display -->
                        <div class="flex items-center gap-3 mb-3">
                            <!-- Icon -->
                            @if($badge['icon'] === 'star')
                                <div class="bg-white/20 backdrop-blur-sm rounded-full p-2">
                                    <svg class="w-6 h-6 {{ $badge['iconColor'] }}" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                </div>
                            @elseif($badge['icon'] === 'fire')
                                <div class="bg-white/20 backdrop-blur-sm rounded-full p-2">
                                    <svg class="w-6 h-6 {{ $badge['iconColor'] }}" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 23C7.03 23 3 18.97 3 14c0-3.09 1.58-5.64 3.5-7.5C8.42 4.58 10.97 3 14 3c.34 0 .67.03 1 .08V1l6 4-6 4V6.09c-.33-.05-.66-.09-1-.09-2.03 0-3.92.78-5.34 2.2C7.28 9.62 6.5 11.51 6.5 14c0 3.03 2.47 5.5 5.5 5.5s5.5-2.47 5.5-5.5h3c0 4.97-4.03 9-9 9z"/>
                                    </svg>
                                </div>
                            @else
                                <div class="bg-white/20 backdrop-blur-sm rounded-full p-2">
                                    <svg class="w-6 h-6 {{ $badge['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Badge Title -->
                            <div class="flex-1">
                                <p class="text-lg font-bold {{ $badge['textColor'] }} leading-tight">{{ $badge['title'] }}</p>
                                <p class="text-xs {{ $badge['textColor'] }} opacity-80">Current Status</p>
                            </div>
                        </div>
                        
                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-2.5 border border-white/30">
                                <p class="text-xl font-bold {{ $badge['textColor'] }}">{{ $totalBookings }}</p>
                                <p class="text-xs {{ $badge['textColor'] }} opacity-80">Total Trips</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-2.5 border border-white/30">
                                <p class="text-xl font-bold {{ $badge['textColor'] }}">{{ $totalMountains }}</p>
                                <p class="text-xs {{ $badge['textColor'] }} opacity-80">Mountains</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Content: Activity Stream -->
            <div class="lg:col-span-8 space-y-8">
                
                <!-- Section: Photo Gallery -->
                <section x-data="{ 
                    showUploadModal: false,
                    showLightbox: false,
                    currentPhoto: null,
                    openLightbox(photo) {
                        this.currentPhoto = photo;
                        this.showLightbox = true;
                    },
                    closeLightbox() {
                        this.showLightbox = false;
                        setTimeout(() => this.currentPhoto = null, 300);
                    }
                }">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                            <span class="p-2 bg-blue-100 rounded-lg text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </span>
                            Photo Gallery
                        </h2>
                        @auth
                            @if(Auth::id() === $user->id)
                                <button @click="showUploadModal = true" class="text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Upload Photo
                                </button>
                            @endif
                        @endauth
                    </div>

                    @if($photos->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
                            @foreach($photos as $photo)
                                <div class="group relative rounded-xl overflow-hidden bg-slate-100 aspect-square cursor-pointer"
                                     @click="openLightbox({
                                         path: '{{ asset('storage/' . $photo->photo_path) }}',
                                         caption: '{{ addslashes($photo->caption ?? '') }}',
                                         location: '{{ addslashes($photo->location ?? '') }}',
                                         id: {{ $photo->id }}
                                     })">
                                    <img src="{{ asset('storage/' . $photo->photo_path) }}" 
                                         alt="{{ $photo->caption ?? 'User photo' }}" 
                                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                    
                                    <!-- Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <!-- View Icon -->
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="bg-white/20 backdrop-blur-sm rounded-full p-3">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        
                                        <div class="absolute bottom-0 left-0 right-0 p-3">
                                            @if($photo->caption)
                                                <p class="text-white text-xs font-medium mb-1 line-clamp-2">{{ $photo->caption }}</p>
                                            @endif
                                            @if($photo->location)
                                                <p class="text-white/80 text-xs flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    </svg>
                                                    {{ $photo->location }}
                                                </p>
                                            @endif
                                        </div>
                                        
                                        <!-- Delete Button (only for own profile) -->
                                        @auth
                                            @if(Auth::id() === $user->id)
                                                <form action="{{ route('profile.photos.delete', $photo) }}" method="POST" class="absolute top-2 right-2" 
                                                      @click.stop
                                                      onsubmit="return confirm('Are you sure you want to delete this photo?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-1.5 rounded-lg transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Lightbox Modal -->
                        <template x-teleport="body">
                            <div x-show="showLightbox"
                                 x-cloak
                                 @click="closeLightbox()"
                                 @keydown.escape.window="closeLightbox()"
                                 class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6 bg-black/90 backdrop-blur-sm"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0">
                                
                                <!-- Close Button -->
                                <button @click="closeLightbox()" 
                                        class="absolute top-4 right-4 z-10 p-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-full transition-all duration-200 group">
                                    <svg class="w-6 h-6 text-white group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>

                                <!-- Photo Container -->
                                <div @click.stop class="relative w-full max-w-4xl"
                                     x-transition:enter="transition ease-out duration-300 delay-100"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95">
                                    
                                    <template x-if="currentPhoto">
                                        <!-- 4:3 Aspect Ratio Container -->
                                        <div class="relative w-full" style="padding-bottom: 75%;">
                                            <!-- Image -->
                                            <img :src="currentPhoto.path" 
                                                 :alt="currentPhoto.caption || 'Photo'"
                                                 class="absolute inset-0 w-full h-full object-cover rounded-2xl shadow-2xl">
                                            
                                            <!-- Gradient Overlay for Text -->
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent rounded-2xl pointer-events-none"></div>
                                            
                                            <!-- Caption & Location Info -->
                                            <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6">
                                                <div class="space-y-2">
                                                    <h3 class="text-xl sm:text-2xl font-bold text-white drop-shadow-lg" 
                                                        x-show="currentPhoto.caption"
                                                        x-text="currentPhoto.caption"></h3>
                                                    
                                                    <p class="text-sm sm:text-base text-white/90 flex items-center gap-2 drop-shadow-lg" 
                                                       x-show="currentPhoto.location">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        </svg>
                                                        <span x-text="currentPhoto.location"></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    @else
                        <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-slate-300">
                            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-slate-500 mb-2">No photos yet</p>
                            @auth
                                @if(Auth::id() === $user->id)
                                    <button @click="showUploadModal = true" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                        Upload your first photo
                                    </button>
                                @endif
                            @endauth
                        </div>
                    @endif

                    <!-- Upload Modal -->
                    @auth
                        @if(Auth::id() === $user->id)
                            <template x-teleport="body">
                                <div x-show="showUploadModal" 
                                     x-cloak
                                     @click.away="showUploadModal = false"
                                     @keydown.escape.window="showUploadModal = false"
                                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0">
                                    
                                    <div @click.stop class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100 scale-100"
                                         x-transition:leave-end="opacity-0 scale-95">
                                        
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-xl font-bold text-slate-900">Upload Photo</h3>
                                            <button @click="showUploadModal = false" class="text-slate-400 hover:text-slate-600">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <form action="{{ route('profile.photos.upload') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 mb-2">Photo</label>
                                                    <input type="file" name="photo" accept="image/*" required
                                                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                                    <p class="text-xs text-slate-500 mt-1">Max 5MB (JPEG, PNG, JPG)</p>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 mb-2">Caption (Optional)</label>
                                                    <input type="text" name="caption" maxlength="255"
                                                           class="block w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                           placeholder="Describe your photo...">
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 mb-2">Location (Optional)</label>
                                                    <input type="text" name="location" maxlength="255"
                                                           class="block w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                           placeholder="Where was this taken?">
                                                </div>
                                            </div>

                                            <div class="flex gap-3 mt-6">
                                                <button type="button" @click="showUploadModal = false"
                                                        class="flex-1 px-4 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors">
                                                    Cancel
                                                </button>
                                                <button type="submit"
                                                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                                    Upload
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </template>
                        @endif
                    @endauth
                </section>
                
                <!-- Section: Mountains Collected -->
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                            <span class="p-2 bg-purple-100 rounded-lg text-purple-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            </span>
                            Conquered Mountains
                        </h2>
                        @if($privacy['show_mountain_history'])
                            <span class="text-sm font-medium text-slate-500 bg-slate-100 px-3 py-1 rounded-full">{{ $uniqueMountains->count() }} Peaks</span>
                        @endif
                    </div>

                    @if($privacy['show_mountain_history'])
                        @if($uniqueMountains->count() > 0)
                            <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 md:gap-5">
                                @foreach($uniqueMountains as $mountain)
                                    <div class="group relative rounded-2xl overflow-hidden bg-white shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                        <!-- Image -->
                                        <div class="h-32 md:h-40 overflow-hidden relative">
                                            @if($mountain->image_url)
                                                <img src="{{ asset('storage/' . $mountain->image_url) }}" 
                                                     alt="{{ $mountain->name }}" 
                                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                            @else
                                                <div class="w-full h-full bg-slate-200 flex items-center justify-center">
                                                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-90"></div>
                                            
                                            <div class="absolute bottom-3 left-3 right-3 text-white">
                                                <h3 class="font-bold text-sm md:text-lg leading-tight">{{ $mountain->name }}</h3>
                                                <p class="text-xs text-slate-300 flex items-center gap-1 mt-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    </svg>
                                                    {{ Str::limit($mountain->location, 20) }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <!-- Footer Info -->
                                        <div class="px-3 py-2 md:px-4 md:py-3 bg-white border-t border-slate-50 flex justify-between items-center">
                                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Elevation</span>
                                            <span class="text-xs md:text-sm font-bold text-indigo-600">{{ number_format($mountain->height) }} m</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-10 bg-white rounded-2xl border border-dashed border-slate-300">
                                <p class="text-slate-500">No mountains conquered yet.</p>
                            </div>
                        @endif
                    @else
                        <!-- Privacy Placeholder -->
                        <div class="bg-amber-50 rounded-2xl p-8 border border-amber-200 text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-amber-100 text-amber-500 mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <h3 class="text-amber-800 font-bold mb-1">Activity Hidden</h3>
                            <p class="text-amber-600/80 text-sm">This user has set their mountain history to private.</p>
                        </div>
                    @endif
                </section>

                <!-- Section: History Timeline -->
                @if($privacy['show_mountain_history'] && $mountainHistory && $mountainHistory->count() > 0)
                    <section>
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                                <span class="p-2 bg-blue-100 rounded-lg text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </span>
                                Hiking Timeline
                            </h2>
                        </div>

                        <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                            @foreach($mountainHistory as $booking)
                                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                    
                                    <!-- Icon Marker -->
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-slate-50 bg-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                                        @if($booking->status === 'completed')
                                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3"></path>
                                            </svg>
                                        @endif
                                    </div>

                                    <!-- Card Content -->
                                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d F Y') }}
                                            </span>
                                            <span class="text-xs font-semibold {{ $booking->status === 'completed' ? 'text-emerald-600 bg-emerald-50' : 'text-blue-600 bg-blue-50' }} px-2 py-0.5 rounded-full">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                        
                                        <div class="flex gap-3">
                                            @if($booking->mountain->image_url)
                                                <img src="{{ asset('storage/' . $booking->mountain->image_url) }}" 
                                                     class="w-12 h-12 rounded-lg object-cover bg-slate-100 shrink-0">
                                            @endif
                                            <div>
                                                <h3 class="font-bold text-slate-800 text-sm leading-tight">{{ $booking->mountain->name }}</h3>
                                                <p class="text-xs text-slate-500 mt-0.5">{{ $booking->trailRoute->name ?? 'Standard Route' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
                
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <x-modern-footer />
    
</body>
</html>