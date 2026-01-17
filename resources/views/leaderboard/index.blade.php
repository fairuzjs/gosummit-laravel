<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Leaderboard') }} - {{ config('app.name') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Animasi Trophy */
        .trophy-glow {
            animation: trophy-pulse 2s ease-in-out infinite;
        }
        
        @keyframes trophy-pulse {
            0%, 100% {
                transform: scale(1);
                filter: drop-shadow(0 0 10px rgba(234, 179, 8, 0.5));
            }
            50% {
                transform: scale(1.05);
                filter: drop-shadow(0 0 20px rgba(234, 179, 8, 0.8));
            }
        }
        
        /* Efek Hover Card */
        .leaderboard-card {
            transition: background-color 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .leaderboard-card:hover {
            background-color: rgba(248, 250, 252, 0.9);
        }
        
        /* Glassmorphism Utilities */
        .stat-card {
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.7);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        /* Rank Gradients & Podium Colors */
        .rank-1 { background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%); box-shadow: 0 10px 20px -5px rgba(255, 215, 0, 0.4); border: 2px solid #FFF8D6; }
        .rank-2 { background: linear-gradient(135deg, #E0E0E0 0%, #BDBDBD 100%); box-shadow: 0 10px 20px -5px rgba(158, 158, 158, 0.4); border: 2px solid #F5F5F5; }
        .rank-3 { background: linear-gradient(135deg, #E6A570 0%, #BF895A 100%); box-shadow: 0 10px 20px -5px rgba(191, 137, 90, 0.4); border: 2px solid #F2D4C2; }
        
        /* Crown Animation */
        .crown-float { animation: float 3s ease-in-out infinite; }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-purple-50 to-blue-50 min-h-screen font-sans text-slate-800 antialiased overflow-x-hidden">
    
    <!-- Header -->
    <x-modern-header />
    
    <!-- Main Content -->
    <main class="py-6 sm:py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            
            {{-- Hero Section --}}
            <div class="text-center mb-8 sm:mb-10">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 text-white font-bold text-[10px] sm:text-xs uppercase tracking-wider mb-4 sm:mb-6 shadow-lg trophy-glow ring-2 ring-white/50">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    {{ __('Hall of Fame') }}
                </div>
                
                <h1 class="text-3xl sm:text-5xl md:text-6xl font-extrabold text-slate-900 mb-3 sm:mb-4 tracking-tight leading-tight">
                    {{ __('Top Climbers') }}
                </h1>
                <p class="text-sm sm:text-lg text-slate-600 max-w-4xl mx-auto leading-relaxed px-2">
                    {{ __('Para penakluk puncak terbaik kami. Bergabunglah dengan mereka dan ukir namamu di puncak tertinggi.') }}
                </p>
            </div>

            {{-- User Rank Info (if logged in) --}}
            @auth
                @php
                    $currentUserRank = $userRank ?? null;
                    $currentUserStat = auth()->user()->userStatistic;
                @endphp
                @if($currentUserStat)
                    <div class="mb-8 transform transition-transform duration-300">
                        <div class="glass-effect rounded-2xl p-4 sm:p-5 shadow-xl border border-white/60 relative overflow-hidden group">
                            <!-- Background Decoration -->
                            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-purple-500/10 to-blue-500/10 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
                            
                            <div class="relative flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-6">
                                <div class="flex items-center gap-4 w-full sm:w-auto">
                                    @if(auth()->user()->profile_picture)
                                        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="{{ auth()->user()->name }}" class="flex-shrink-0 w-12 h-12 sm:w-14 sm:h-14 rounded-full object-cover shadow-lg ring-4 ring-white">
                                    @else
                                        <div class="flex-shrink-0 w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center text-white font-bold text-lg sm:text-xl shadow-lg ring-4 ring-white">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-900 text-base sm:text-lg truncate">{{ auth()->user()->name }}</div>
                                        <div class="text-xs sm:text-sm font-medium text-purple-600 bg-purple-50 px-2 py-0.5 rounded-md inline-block mt-1">{{ __('Ranking Kamu Saat Ini') }}</div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center w-full sm:w-auto justify-between sm:justify-end gap-2 sm:gap-8 bg-white/50 sm:bg-transparent p-3 sm:p-0 rounded-xl">
                                    <div class="text-center px-2 sm:px-0 flex-1 sm:flex-none">
                                        <div class="text-2xl sm:text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">
                                            @if($currentUserRank)
                                                <span class="text-sm sm:text-lg align-top text-slate-400 mr-0.5">#</span>{{ $currentUserRank }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                        <div class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">{{ __('Rank') }}</div>
                                    </div>
                                    
                                    <div class="w-px h-8 sm:h-10 bg-slate-300/50"></div>
                                    
                                    <div class="text-center px-2 sm:px-0 flex-1 sm:flex-none">
                                        <div class="text-xl sm:text-3xl font-bold text-slate-800">
                                            @if($type === 'monthly')
                                                {{ $currentUserStat->monthly_completed ?? 0 }}
                                            @else
                                                {{ $currentUserStat->completed_bookings ?? 0 }}
                                            @endif
                                        </div>
                                        <div class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">{{ __('Pendakian') }}</div>
                                    </div>

                                    <div class="w-px h-8 sm:h-10 bg-slate-300/50 hidden sm:block"></div>

                                    <div class="text-center hidden sm:block">
                                        <div class="text-xl sm:text-3xl font-bold text-slate-800">
                                             Rp {{ number_format($type === 'monthly' ? ($currentUserStat->monthly_spent ?? 0) : ($currentUserStat->total_spent ?? 0), 0, ',', '.') }}
                                        </div>
                                        <div class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">{{ __('Kontribusi') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5 mb-10">
                @php
                    $stats = [
                        ['label' => 'Total Pendaki', 'value' => $statistics['total_climbers'], 'color' => 'purple', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                        ['label' => 'Aktif Bulan Ini', 'value' => $statistics['active_this_month'], 'color' => 'green', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'],
                        ['label' => 'Total Pendakian', 'value' => $statistics['total_hikes_completed'], 'color' => 'orange', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                        ['label' => 'Bulan Ini', 'value' => $statistics['total_hikes_this_month'], 'color' => 'blue', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ];
                @endphp

                @foreach($stats as $stat)
                <div class="stat-card rounded-2xl p-3 sm:p-5 shadow-sm hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-start justify-between mb-2">
                        <div class="p-1.5 sm:p-2 rounded-lg bg-{{ $stat['color'] }}-100 text-{{ $stat['color'] }}-600 group-hover:bg-{{ $stat['color'] }}-600 group-hover:text-white transition-colors">
                            <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"></path></svg>
                        </div>
                    </div>
                    <div class="text-lg sm:text-3xl font-bold text-slate-900 mb-0.5 sm:mb-1">
                        {{ number_format($stat['value']) }}
                    </div>
                    <div class="text-[10px] sm:text-xs md:text-sm text-slate-500 font-medium truncate">{{ __($stat['label']) }}</div>
                </div>
                @endforeach
            </div>

            {{-- Tab Switcher --}}
            <div class="flex justify-center mb-10 sm:mb-12">
                <div class="inline-flex rounded-xl bg-white p-1 shadow-sm border border-slate-200">
                    <a href="{{ route('leaderboard.index', ['type' => 'monthly']) }}" 
                       class="px-6 sm:px-10 py-2 sm:py-2.5 rounded-lg font-bold text-xs sm:text-sm transition-all duration-300 {{ $type === 'monthly' ? 'bg-slate-900 text-white shadow-md' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                        {{ __('Bulan Ini') }}
                    </a>
                    <a href="{{ route('leaderboard.index', ['type' => 'alltime']) }}" 
                       class="px-6 sm:px-10 py-2 sm:py-2.5 rounded-lg font-bold text-xs sm:text-sm transition-all duration-300 {{ $type === 'alltime' ? 'bg-slate-900 text-white shadow-md' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                        {{ __('Sepanjang Masa') }}
                    </a>
                </div>
            </div>

            {{-- PODIUM SECTION (Top 3) --}}
            @if($leaderboard->count() > 0)
            <div class="mb-10 sm:mb-16 relative z-10">
                {{-- Responsive Grid: Mobile uses reduced gaps --}}
                <div class="grid grid-cols-2 md:flex md:flex-row items-end justify-center gap-3 sm:gap-6 md:gap-8">
                    
                    {{-- Juara 2 (Left Desktop, Bottom Left Mobile) --}}
                    @if(isset($leaderboard[1]))
                    <div class="col-span-1 order-2 md:order-1 w-full md:w-1/3 md:max-w-[280px] group cursor-pointer" onclick="openUserModal({{ $leaderboard[1]->id }})">
                        <!-- Added h-full and justify-between to force equal height on mobile -->
                        <div class="relative h-full justify-between bg-white/40 backdrop-blur-md rounded-2xl p-3 sm:p-6 border border-white/60 shadow-xl flex flex-col items-center transform transition-all duration-300 hover:-translate-y-2 hover:bg-white/60 min-h-[200px] sm:min-h-0">
                            <!-- Rank Badge -->
                            <div class="absolute -top-3 sm:-top-4 left-1/2 -translate-x-1/2 bg-slate-200 text-slate-600 px-2 sm:px-4 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold shadow-sm border border-white whitespace-nowrap z-10">
                                {{ __('Runner Up') }}
                            </div>
                            
                            <!-- Avatar Ring -->
                            <div class="relative mb-2 sm:mb-4 mt-3 sm:mt-2">
                                <div class="w-12 h-12 sm:w-20 sm:h-20 rounded-full rank-2 flex items-center justify-center p-1">
                                    @if($leaderboard[1]->profile_picture)
                                        <img src="{{ asset('storage/' . $leaderboard[1]->profile_picture) }}" alt="{{ $leaderboard[1]->name }}" class="w-full h-full rounded-full object-cover">
                                    @else
                                        <div class="w-full h-full rounded-full bg-slate-100 flex items-center justify-center text-lg sm:text-2xl font-bold text-slate-500">
                                            {{ strtoupper(substr($leaderboard[1]->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="absolute -bottom-1 sm:-bottom-2 -right-1 sm:-right-2 w-5 h-5 sm:w-8 sm:h-8 bg-slate-300 rounded-full flex items-center justify-center text-slate-700 font-bold border-2 border-white shadow-md text-[10px] sm:text-base">2</div>
                            </div>
                            
                            <div class="flex flex-col items-center w-full">
                                <h3 class="font-bold text-slate-900 text-xs sm:text-lg truncate w-full text-center px-1">{{ $leaderboard[1]->name }}</h3>
                                <p class="text-slate-600 text-[10px] sm:text-sm font-medium mt-1">{{ $type == 'monthly' ? $leaderboard[1]->userStatistic->monthly_completed : $leaderboard[1]->userStatistic->completed_bookings }} {{ __('Hikes') }}</p>
                            </div>
                            
                            <div class="mt-2 sm:mt-3 text-[10px] sm:text-xs font-bold uppercase tracking-wide {{ ($type == 'monthly' ? $leaderboard[1]->userStatistic->monthly_spent : $leaderboard[1]->userStatistic->total_spent) === null ? 'text-gray-400 italic' : 'text-slate-400' }}">
                                @if(($type == 'monthly' ? $leaderboard[1]->userStatistic->monthly_spent : $leaderboard[1]->userStatistic->total_spent) === null)
                                    Private
                                @else
                                    Rp {{ number_format($type == 'monthly' ? $leaderboard[1]->userStatistic->monthly_spent : $leaderboard[1]->userStatistic->total_spent, 0, ',', '.') }}
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Juara 1 (Center Desktop, Top Mobile) --}}
                    @if(isset($leaderboard[0]))
                    <div class="col-span-2 order-1 md:order-2 w-full md:w-1/3 max-w-[320px] mx-auto md:mx-0 relative z-20 group cursor-pointer mb-4 md:mb-0" onclick="openUserModal({{ $leaderboard[0]->id }})">
                        
                        <div class="relative bg-gradient-to-b from-white/80 to-white/40 backdrop-blur-xl rounded-2xl p-6 sm:p-8 border-t-4 border-yellow-400 shadow-2xl flex flex-col items-center transform transition-all duration-300 md:-translate-y-4 hover:-translate-y-6">
                            <!-- Shine Effect -->
                            <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/30 to-white/0 opacity-0 group-hover:opacity-100 transition-opacity duration-700 rounded-2xl pointer-events-none"></div>

                            <!-- Rank Badge -->
                            <div class="absolute -top-4 sm:-top-5 left-1/2 -translate-x-1/2 bg-yellow-400 text-yellow-900 px-4 sm:px-6 py-1 sm:py-1.5 rounded-full text-xs sm:text-sm font-bold shadow-lg border-2 border-white">
                                {{ __('CHAMPION') }}
                            </div>

                            <!-- Avatar Ring -->
                            <div class="relative mb-4 sm:mb-6 mt-3 sm:mt-4">
                                <div class="w-20 h-20 sm:w-28 sm:h-28 rounded-full rank-1 flex items-center justify-center p-1.5">
                                    @if($leaderboard[0]->profile_picture)
                                        <img src="{{ asset('storage/' . $leaderboard[0]->profile_picture) }}" alt="{{ $leaderboard[0]->name }}" class="w-full h-full rounded-full object-cover">
                                    @else
                                        <div class="w-full h-full rounded-full bg-yellow-50 flex items-center justify-center text-2xl sm:text-4xl font-bold text-yellow-600">
                                            {{ strtoupper(substr($leaderboard[0]->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="absolute -bottom-2 sm:-bottom-3 -right-1 sm:-right-2 w-8 h-8 sm:w-10 sm:h-10 bg-yellow-400 rounded-full flex items-center justify-center text-yellow-900 font-bold border-2 border-white shadow-md text-sm sm:text-lg">1</div>
                            </div>
                            
                            <h3 class="font-extrabold text-slate-900 text-lg sm:text-xl truncate w-full text-center mb-1">{{ $leaderboard[0]->name }}</h3>
                            <div class="flex items-center gap-2 mb-3 sm:mb-4">
                                <span class="bg-green-100 text-green-700 px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs sm:text-sm font-bold">
                                    {{ $type == 'monthly' ? $leaderboard[0]->userStatistic->monthly_completed : $leaderboard[0]->userStatistic->completed_bookings }} {{ __('Selesai') }}
                                </span>
                            </div>
                            <div class="w-full pt-3 sm:pt-4 border-t border-slate-200 text-center">
                                <div class="text-[10px] sm:text-xs text-slate-500 uppercase font-bold tracking-wider mb-1">{{ __('Total Spent') }}</div>
                                <div class="text-base sm:text-lg font-bold {{ ($type == 'monthly' ? $leaderboard[0]->userStatistic->monthly_spent : $leaderboard[0]->userStatistic->total_spent) === null ? 'text-gray-400 italic' : 'text-slate-900' }}">
                                    @if(($type == 'monthly' ? $leaderboard[0]->userStatistic->monthly_spent : $leaderboard[0]->userStatistic->total_spent) === null)
                                        Private
                                    @else
                                        Rp {{ number_format($type == 'monthly' ? $leaderboard[0]->userStatistic->monthly_spent : $leaderboard[0]->userStatistic->total_spent, 0, ',', '.') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Juara 3 (Right Desktop, Bottom Right Mobile) --}}
                    @if(isset($leaderboard[2]))
                    <div class="col-span-1 order-3 md:order-3 w-full md:w-1/3 md:max-w-[280px] group cursor-pointer" onclick="openUserModal({{ $leaderboard[2]->id }})">
                         <div class="relative h-full justify-between bg-white/40 backdrop-blur-md rounded-2xl p-3 sm:p-6 border border-white/60 shadow-xl flex flex-col items-center transform transition-all duration-300 hover:-translate-y-2 hover:bg-white/60 min-h-[200px] sm:min-h-0">
                            <!-- Rank Badge -->
                            <div class="absolute -top-3 sm:-top-4 left-1/2 -translate-x-1/2 bg-orange-200 text-orange-800 px-2 sm:px-4 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold shadow-sm border border-white whitespace-nowrap z-10">
                                {{ __('3rd Place') }}
                            </div>

                            <!-- Avatar Ring -->
                            <div class="relative mb-2 sm:mb-4 mt-3 sm:mt-2">
                                <div class="w-12 h-12 sm:w-20 sm:h-20 rounded-full rank-3 flex items-center justify-center p-1">
                                    @if($leaderboard[2]->profile_picture)
                                        <img src="{{ asset('storage/' . $leaderboard[2]->profile_picture) }}" alt="{{ $leaderboard[2]->name }}" class="w-full h-full rounded-full object-cover">
                                    @else
                                        <div class="w-full h-full rounded-full bg-orange-50 flex items-center justify-center text-lg sm:text-2xl font-bold text-orange-600">
                                            {{ strtoupper(substr($leaderboard[2]->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="absolute -bottom-1 sm:-bottom-2 -right-1 sm:-right-2 w-5 h-5 sm:w-8 sm:h-8 bg-orange-400 rounded-full flex items-center justify-center text-white font-bold border-2 border-white shadow-md text-[10px] sm:text-base">3</div>
                            </div>
                            
                            <div class="flex flex-col items-center w-full">
                                <h3 class="font-bold text-slate-900 text-xs sm:text-lg truncate w-full text-center px-1">{{ $leaderboard[2]->name }}</h3>
                                <p class="text-slate-600 text-[10px] sm:text-sm font-medium mt-1">{{ $type == 'monthly' ? $leaderboard[2]->userStatistic->monthly_completed : $leaderboard[2]->userStatistic->completed_bookings }} {{ __('Hikes') }}</p>
                            </div>

                            <div class="mt-2 sm:mt-3 text-[10px] sm:text-xs font-bold uppercase tracking-wide {{ ($type == 'monthly' ? $leaderboard[2]->userStatistic->monthly_spent : $leaderboard[2]->userStatistic->total_spent) === null ? 'text-gray-400 italic' : 'text-slate-400' }}">
                                @if(($type == 'monthly' ? $leaderboard[2]->userStatistic->monthly_spent : $leaderboard[2]->userStatistic->total_spent) === null)
                                    Private
                                @else
                                    Rp {{ number_format($type == 'monthly' ? $leaderboard[2]->userStatistic->monthly_spent : $leaderboard[2]->userStatistic->total_spent, 0, ',', '.') }}
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
            @endif

            {{-- Leaderboard Content (Table Start from Rank 4) --}}
            <div class="glass-effect rounded-3xl shadow-2xl overflow-hidden ring-1 ring-white/60">
                {{-- Header --}}
                <div class="bg-slate-900/95 backdrop-blur-md px-4 sm:px-8 py-4 sm:py-6 border-b border-slate-800 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500 rounded-full blur-3xl opacity-20 -mr-10 -mt-10"></div>
                    <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                        <h2 class="text-lg sm:text-2xl font-bold text-white flex items-center gap-3">
                            {{ __('Runner Ups & Contenders') }}
                        </h2>
                        @if($type === 'monthly')
                             <span class="px-3 py-1 bg-slate-800 rounded-full text-xs font-semibold text-purple-300 border border-slate-700">{{ now()->format('F Y') }}</span>
                        @endif
                    </div>
                </div>

                {{-- Desktop Table View --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider pl-8">{{ __('Rank') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Pendaki') }}</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Pendakian') }}</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Total Pengeluaran') }}</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Detail') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white/50">
                            {{-- Skip top 3 because they are on podium --}}
                            @forelse($leaderboard->skip(3) as $index => $user)
                                <tr class="leaderboard-card group {{ auth()->check() && auth()->id() === $user->id ? 'bg-purple-50/80 ring-1 ring-inset ring-purple-100' : '' }}">
                                    {{-- Rank --}}
                                    <td class="px-6 py-4 whitespace-nowrap pl-8">
                                        <div class="flex items-center">
                                            <span class="text-base font-bold text-slate-500 w-9 text-center">#{{ $loop->iteration + 3 }}</span>
                                        </div>
                                    </td>

                                    {{-- User Info --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="relative">
                                                @if($user->profile_picture)
                                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover shadow-inner">
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold text-sm shadow-inner overflow-hidden">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                                    {{ $user->name }}
                                                    @if(auth()->check() && auth()->id() === $user->id)
                                                        <span class="px-2 py-0.5 bg-purple-600 text-white text-[10px] font-bold rounded-full uppercase tracking-wide">{{ __('You') }}</span>
                                                    @endif
                                                </div>
                                                <div class="text-xs text-slate-500 truncate">{{ $user->masked_email ?? mask_email($user->email) }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Completed Hikes --}}
                                    <td class="px-6 py-4 text-center">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-700 rounded-full font-bold text-sm group-hover:bg-white group-hover:shadow-sm transition-all">
                                            {{ $type === 'monthly' ? $user->userStatistic->monthly_completed ?? 0 : $user->userStatistic->completed_bookings ?? 0 }}
                                            <span class="text-[10px] text-slate-400 font-normal uppercase">Hikes</span>
                                        </div>
                                    </td>

                                    {{-- Total Spent --}}
                                    <td class="px-6 py-4 text-right">
                                        <div class="font-bold text-sm {{ ($type === 'monthly' ? $user->userStatistic->monthly_spent : $user->userStatistic->total_spent) === null ? 'text-gray-400 italic' : 'text-slate-700' }}">
                                            @if(($type === 'monthly' ? $user->userStatistic->monthly_spent : $user->userStatistic->total_spent) === null)
                                                Private
                                            @else
                                                Rp {{ number_format($type === 'monthly' ? ($user->userStatistic->monthly_spent ?? 0) : ($user->userStatistic->total_spent ?? 0), 0, ',', '.') }}
                                            @endif
                                        </div>
                                    </td>
                                    
                                    {{-- Detail Button --}}
                                    <td class="px-6 py-4 text-center">
                                        <button onclick="openUserModal({{ $user->id }})" class="text-slate-400 hover:text-purple-600 hover:bg-purple-50 p-2 rounded-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                @if($leaderboard->count() <= 3)
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                            {{ __('Hanya ada juara di podium saat ini!') }}
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="5" class="px-6 py-16 text-center">
                                            <div class="text-slate-400 flex flex-col items-center">
                                                <svg class="w-16 h-16 mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <p class="text-lg font-bold text-slate-500 mb-1">{{ __('Belum ada data') }}</p>
                                                <p class="text-sm text-slate-400">{{ __('Jadilah yang pertama mendaki!') }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Card View (Improved) --}}
                <div class="md:hidden divide-y divide-slate-100 bg-white/50">
                    @forelse($leaderboard->skip(3) as $index => $user)
                        <div class="p-4 {{ auth()->check() && auth()->id() === $user->id ? 'bg-purple-50/80' : '' }} active:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-4">
                                {{-- Rank --}}
                                <div class="flex-shrink-0">
                                    <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                                        #{{ $loop->iteration + 3 }}
                                    </div>
                                </div>

                                {{-- User Info & Stats --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start mb-1.5">
                                        <div class="min-w-0 pr-2">
                                            <div class="font-bold text-slate-900 text-sm truncate flex items-center gap-1.5">
                                                {{ $user->name }}
                                                @if(auth()->check() && auth()->id() === $user->id)
                                                    <span class="w-2 h-2 rounded-full bg-purple-500 flex-shrink-0"></span>
                                                @endif
                                            </div>
                                            <div class="text-[10px] text-slate-500 truncate leading-tight">{{ $user->masked_email ?? mask_email($user->email) }}</div>
                                        </div>
                                        <div class="text-right flex-shrink-0">
                                             <div class="font-bold text-slate-900 text-sm">
                                                {{ $type === 'monthly' ? $user->userStatistic->monthly_completed ?? 0 : $user->userStatistic->completed_bookings ?? 0 }}
                                                <span class="text-[10px] text-slate-400 font-normal ml-0.5">Hikes</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-xs font-medium {{ ($type === 'monthly' ? $user->userStatistic->monthly_spent : $user->userStatistic->total_spent) === null ? 'text-gray-400 italic' : 'text-slate-500' }}">
                                        @if(($type === 'monthly' ? $user->userStatistic->monthly_spent : $user->userStatistic->total_spent) === null)
                                            Private
                                        @else
                                            Rp {{ number_format($type === 'monthly' ? ($user->userStatistic->monthly_spent ?? 0) : ($user->userStatistic->total_spent ?? 0), 0, ',', '.') }}
                                        @endif
                                    </div>
                                    <button onclick="openUserModal({{ $user->id }})" class="px-3 py-1 bg-slate-50 text-slate-600 rounded-full text-[10px] font-bold hover:bg-purple-50 hover:text-purple-600 transition-colors">
                                        {{ __('Detail') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                         <div class="p-8 text-center text-slate-400 text-sm">
                            {{ $leaderboard->count() <= 3 ? __('Hanya ada juara di podium saat ini!') : __('Belum ada data lainnya.') }}
                        </div>
                    @endforelse
                </div>

                {{-- Your Rank Footer --}}
                @auth
                    @if($userRank && $userRank > 50)
                        <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-4 py-3 border-t border-slate-700 sticky bottom-0 z-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    @if(auth()->user()->profile_picture)
                                        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-white font-bold text-xs">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-white text-sm">{{ __('Posisi Kamu') }}</div>
                                    </div>
                                </div>
                                <div class="text-right flex items-center gap-3">
                                    <div class="text-xs text-slate-400">{{ __('Ranking') }}</div>
                                    <div class="text-xl font-bold text-white">#{{ $userRank }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>

            {{-- CTA Section --}}
            <div class="mt-20 mb-12 relative text-center px-4">
                <!-- Decorative background elements -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-[500px] h-[300px] bg-gradient-to-r from-purple-200/50 to-blue-200/50 rounded-full blur-3xl -z-10 pointer-events-none"></div>
                
                <h3 class="text-2xl sm:text-4xl font-black text-slate-900 mb-4 tracking-tight">
                    {{ __('Siap Menjadi') }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">{{ __('Legenda?') }}</span>
                </h3>
                
                <p class="text-slate-600 text-sm sm:text-lg mb-8 max-w-6xl mx-auto leading-relaxed">
                    {{ __('Setiap langkah membawamu lebih dekat ke puncak. Mulai petualanganmu sekarang dan raih posisi teratas di leaderboard!') }}
                </p>
                
                <a href="{{ route('mountains.list') }}" class="inline-flex items-center justify-center px-8 py-4 bg-slate-900 text-white font-bold rounded-full hover:bg-slate-800 hover:scale-105 transition-all duration-300 shadow-xl shadow-purple-900/10 group text-sm sm:text-base w-full sm:w-auto">
                    <span>{{ __('Mulai Mendaki Sekarang') }}</span>
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>

        </div>
    </main>
    
    {{-- Modal Popup for User Details --}}
    <div id="userDetailsModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300">
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl transform transition-all scale-100 overflow-hidden">
            
            {{-- Modal Header --}}
            <div class="relative h-28 bg-gradient-to-r from-purple-600 to-blue-600">
                 <button onclick="closeUserModal()" class="absolute top-4 right-4 z-10 bg-black/20 hover:bg-black/40 text-white rounded-full p-2 transition-all backdrop-blur-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <!-- Decorative Circle -->
                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 w-24 h-24 bg-white rounded-full flex items-center justify-center p-1.5 shadow-xl">
                     <div id="userAvatar" class="w-full h-full rounded-full bg-slate-100 flex items-center justify-center text-slate-700 text-3xl font-bold overflow-hidden">
                        <!-- JS fills this -->
                     </div>
                </div>
            </div>

            {{-- Modal Content --}}
            <div class="pt-14 pb-8 px-6">
                {{-- User Info --}}
                <div class="text-center mb-8">
                    <a id="userNameLink" href="#" class="group inline-block">
                        <h3 class="text-xl font-bold text-slate-900 mb-1 group-hover:text-purple-600 transition-colors duration-200" id="userName">Loading...</h3>
                        <div class="flex items-center justify-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        </div>
                    </a>
                    <p class="text-sm text-slate-500 mt-1" id="userEmail">...</p>
                </div>

                <div id="modalLoading" class="text-center py-6">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-slate-200 border-t-purple-600"></div>
                    <p class="mt-3 text-xs text-slate-400">Mengambil data...</p>
                </div>

                <div id="modalData" class="hidden">
                    {{-- Stats Grid --}}
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-green-50 rounded-2xl p-4 border border-green-100 text-center">
                            <div class="text-2xl font-bold text-green-700 mb-1" id="userCompleted">-</div>
                            <div class="text-[10px] font-bold text-green-600 uppercase tracking-wide">{{ __('Pendakian') }}</div>
                        </div>
                        <div class="bg-blue-50 rounded-2xl p-4 border border-blue-100 text-center">
                            <div class="text-lg font-bold text-blue-700 mb-1" id="userSpent">-</div>
                            <div class="text-[10px] font-bold text-blue-600 uppercase tracking-wide">{{ __('Total Pengeluaran') }}</div>
                        </div>
                    </div>

                    {{-- Mountains List --}}
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                            {{ __('Riwayat Gunung') }}
                            <span class="h-px bg-slate-200 flex-1"></span>
                            <span id="mountainCount" class="text-xs font-semibold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full"></span>
                        </h4>
                        <div id="mountainsListWrapper" class="relative">
                            <div id="mountainsList" class="transition-all duration-300">
                                <!-- JS fills this -->
                            </div>
                            
                            {{-- Show More Text Link --}}
                            <div id="showMoreLink" class="hidden mt-2 text-center">
                                <button onclick="toggleMountainsList()" class="text-sm font-semibold text-purple-600 hover:text-purple-800 transition-colors duration-200 inline-flex items-center gap-1">
                                    <span id="btnText">{{ __('Selengkapnya') }}</span>
                                    <svg id="btnIcon" class="w-3 h-3 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        {{-- Empty State --}}
                        <div id="emptyMountains" class="hidden text-center py-6 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            <p class="text-sm text-slate-400">{{ __('Belum ada riwayat pendakian.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openUserModal(userId) {
            const modal = document.getElementById('userDetailsModal');
            const loading = document.getElementById('modalLoading');
            const data = document.getElementById('modalData');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            loading.classList.remove('hidden');
            data.classList.add('hidden');
            
            // Animation reset
            const modalContainer = modal.querySelector('div');
            modalContainer.classList.remove('scale-100', 'opacity-100');
            modalContainer.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modalContainer.classList.remove('scale-95', 'opacity-0');
                modalContainer.classList.add('scale-100', 'opacity-100');
            }, 10);

            fetch(`/leaderboard/user/${userId}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(result => {
                    if (result.success) {
                        const userAvatar = document.getElementById('userAvatar');
                        if (result.user.profile_picture) {
                            userAvatar.innerHTML = `<img src="/storage/${result.user.profile_picture}" alt="${result.user.name}" class="w-full h-full object-cover">`;
                        } else {
                            userAvatar.textContent = result.user.name.charAt(0).toUpperCase();
                        }
                        document.getElementById('userName').textContent = result.user.name;
                        document.getElementById('userEmail').textContent = result.user.email;
                        document.getElementById('userCompleted').textContent = result.user.completed_bookings;
                        
                        // Check if viewing own profile
                        const userNameLink = document.getElementById('userNameLink');
                        const currentUserId = {{ Auth::check() ? Auth::id() : 'null' }};
                        
                        if (currentUserId && userId == currentUserId) {
                            // Hide link if viewing own profile (make it non-clickable)
                            userNameLink.href = '#';
                            userNameLink.classList.add('pointer-events-none');
                            userNameLink.querySelector('div').classList.add('hidden');
                        } else {
                            // Show link and set href for other users
                            userNameLink.href = `/profile/${userId}`;
                            userNameLink.classList.remove('pointer-events-none');
                            userNameLink.querySelector('div').classList.remove('hidden');
                        }
                        
                        // Check if total spent is visible
                        const spentElement = document.getElementById('userSpent');
                        if (result.user.show_total_spent && result.user.total_spent !== null) {
                            spentElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID', { notation: "compact", maximumFractionDigits: 1 }).format(result.user.total_spent);
                            spentElement.classList.remove('text-gray-400', 'italic');
                            spentElement.classList.add('text-blue-700');
                        } else {
                            spentElement.textContent = 'Private';
                            spentElement.classList.remove('text-blue-700');
                            spentElement.classList.add('text-gray-400', 'italic');
                        }
                        
                        const mountainsList = document.getElementById('mountainsList');
                        const emptyMountains = document.getElementById('emptyMountains');
                        const showMoreLink = document.getElementById('showMoreLink');
                        const mountainCount = document.getElementById('mountainCount');
                        const mountainsSection = document.getElementById('mountainsListWrapper').parentElement;
                        
                        // Check if mountain history is visible
                        if (!result.user.show_mountain_history) {
                            // Hide mountains section and show private message
                            mountainsList.classList.add('hidden');
                            showMoreLink.classList.add('hidden');
                            mountainCount.textContent = '';
                            emptyMountains.classList.remove('hidden');
                            emptyMountains.innerHTML = `
                                <div class="text-center py-6 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    <p class="text-sm text-gray-400 italic">{{ __('Riwayat gunung bersifat privat') }}</p>
                                </div>
                            `;
                        } else if (result.mountains.length > 0) {
                            const sortedMountains = result.mountains.sort((a, b) => b.count - a.count);
                            
                            // Store all mountains data globally
                            window.allMountains = sortedMountains;
                            window.isExpanded = false;
                            
                            // Update mountain count badge
                            mountainCount.textContent = `${sortedMountains.length} Gunung`;
                            
                            // Determine layout: grid if 4+ mountains, single column if less
                            const useGridLayout = sortedMountains.length >= 4;
                            
                            // Show only first 4 initially if using grid, otherwise 3
                            const initialCount = useGridLayout ? 4 : 3;
                            const displayMountains = sortedMountains.slice(0, initialCount);
                            
                            // Apply grid layout class if needed
                            if (useGridLayout) {
                                mountainsList.className = 'grid grid-cols-2 gap-3 transition-all duration-300';
                            } else {
                                mountainsList.className = 'space-y-3 transition-all duration-300';
                            }
                            
                            mountainsList.innerHTML = displayMountains.map(mountain => `
                                <div class="mountain-item flex items-center gap-2 p-2 bg-white border border-slate-100 rounded-xl hover:shadow-sm transition-shadow">
                                    <img src="/storage/${mountain.image}" class="w-10 h-10 rounded-lg object-cover bg-slate-200 flex-shrink-0" onerror="this.src='https://via.placeholder.com/40'">
                                    <div class="flex-1 min-w-0">
                                        <div class="font-bold text-slate-900 text-xs truncate leading-tight">${mountain.name}</div>
                                        <div class="text-[10px] text-slate-500 truncate">${mountain.location}</div>
                                        <div class="text-[9px] ${mountain.status === 'completed' ? 'text-green-600' : 'text-slate-400'} mt-0.5 font-medium">
                                            ${mountain.status === 'completed' ? '✓ Completed' : 'Checked In'}
                                        </div>
                                    </div>
                                    <span class="px-2 py-0.5 bg-purple-100 text-purple-700 text-[10px] font-bold rounded-lg whitespace-nowrap">
                                        ${mountain.count}x
                                    </span>
                                </div>
                            `).join('');
                            
                            // Show 'Show More' link if more than initial count
                            if (sortedMountains.length > initialCount) {
                                showMoreLink.classList.remove('hidden');
                            } else {
                                showMoreLink.classList.add('hidden');
                            }
                            
                            mountainsList.classList.remove('hidden');
                            emptyMountains.classList.add('hidden');
                        } else {
                            mountainsList.classList.add('hidden');
                            emptyMountains.classList.remove('hidden');
                            showMoreLink.classList.add('hidden');
                        }
                        
                        loading.classList.add('hidden');
                        data.classList.remove('hidden');
                    } else {
                        throw new Error(result.message || 'Unknown error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memuat data. Silakan coba lagi.');
                    closeUserModal();
                });
        }
        
        function toggleMountainsList() {
            const mountainsList = document.getElementById('mountainsList');
            const btnText = document.getElementById('btnText');
            const btnIcon = document.getElementById('btnIcon');
            
            window.isExpanded = !window.isExpanded;
            
            // Determine layout based on total mountains
            const useGridLayout = window.allMountains.length >= 4;
            const initialCount = useGridLayout ? 4 : 3;
            
            // Apply appropriate layout class
            if (useGridLayout) {
                mountainsList.className = 'grid grid-cols-2 gap-3 transition-all duration-300';
            } else {
                mountainsList.className = 'space-y-3 transition-all duration-300';
            }
            
            if (window.isExpanded) {
                // Show all mountains
                mountainsList.innerHTML = window.allMountains.map(mountain => `
                    <div class="mountain-item flex items-center gap-2 p-2 bg-white border border-slate-100 rounded-xl hover:shadow-sm transition-shadow">
                        <img src="/storage/${mountain.image}" class="w-10 h-10 rounded-lg object-cover bg-slate-200 flex-shrink-0" onerror="this.src='https://via.placeholder.com/40'">
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-slate-900 text-xs truncate leading-tight">${mountain.name}</div>
                            <div class="text-[10px] text-slate-500 truncate">${mountain.location}</div>
                            <div class="text-[9px] ${mountain.status === 'completed' ? 'text-green-600' : 'text-slate-400'} mt-0.5 font-medium">
                                ${mountain.status === 'completed' ? '✓ Completed' : 'Checked In'}
                            </div>
                        </div>
                        <span class="px-2 py-0.5 bg-purple-100 text-purple-700 text-[10px] font-bold rounded-lg whitespace-nowrap">
                            ${mountain.count}x
                        </span>
                    </div>
                `).join('');
                btnText.textContent = '{{ __("Sembunyikan") }}';
                btnIcon.style.transform = 'rotate(180deg)';
            } else {
                // Show only initial count
                const displayMountains = window.allMountains.slice(0, initialCount);
                mountainsList.innerHTML = displayMountains.map(mountain => `
                    <div class="mountain-item flex items-center gap-2 p-2 bg-white border border-slate-100 rounded-xl hover:shadow-sm transition-shadow">
                        <img src="/storage/${mountain.image}" class="w-10 h-10 rounded-lg object-cover bg-slate-200 flex-shrink-0" onerror="this.src='https://via.placeholder.com/40'">
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-slate-900 text-xs truncate leading-tight">${mountain.name}</div>
                            <div class="text-[10px] text-slate-500 truncate">${mountain.location}</div>
                            <div class="text-[9px] ${mountain.status === 'completed' ? 'text-green-600' : 'text-slate-400'} mt-0.5 font-medium">
                                ${mountain.status === 'completed' ? '✓ Completed' : 'Checked In'}
                            </div>
                        </div>
                        <span class="px-2 py-0.5 bg-purple-100 text-purple-700 text-[10px] font-bold rounded-lg whitespace-nowrap">
                            ${mountain.count}x
                        </span>
                    </div>
                `).join('');
                btnText.textContent = '{{ __("Selengkapnya") }}';
                btnIcon.style.transform = 'rotate(0deg)';
            }
        }
        
        function closeUserModal() {
            const modal = document.getElementById('userDetailsModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        
        document.getElementById('userDetailsModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeUserModal();
        });
    </script>
    
    <!-- Footer -->
    <x-modern-footer />
    
</body>
</html>