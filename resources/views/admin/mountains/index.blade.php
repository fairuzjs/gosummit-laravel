@extends('layouts.admin')

@section('title', 'Manage Mountains')
@section('header-title', 'Manage Mountains')

@section('header-buttons')
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.analytics.index') }}"
           class="inline-flex items-center px-4 py-2.5 bg-gray-200 text-gray-800 font-bold rounded-xl hover:bg-gray-300 transition-all duration-200">
            <span class="hidden sm:inline">Back to Dashboard</span>
            <span class="sm:hidden">Back</span>
        </a>

        <!-- Tombol Add New Mountain -->
        <a href="{{ route('admin.mountains.create') }}"
           class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold rounded-xl hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span class="hidden sm:inline">Add New Mountain</span>
            <span class="sm:hidden">Add</span>
        </a>
    </div>
@endsection

@section('content')
    <!-- Stats Cards - Responsive Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mb-6 sm:mb-8">
        <!-- Total Mountains -->
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 hover:shadow-xl transform hover:scale-[1.02] transition">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-2 sm:mb-0">
                    <p class="text-gray-600 font-medium text-xs sm:text-sm mb-1">Total Mountains</p>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                        {{ $mountains->count() }}
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl flex items-center justify-center self-end sm:self-auto">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-7 lg:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Open -->
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 hover:shadow-xl transform hover:scale-[1.02] transition">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-2 sm:mb-0">
                    <p class="text-gray-600 font-medium text-xs sm:text-sm mb-1">Open</p>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-green-600">
                        {{ $mountains->where('status', 'open')->count() }}
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-green-500 rounded-xl flex items-center justify-center self-end sm:self-auto">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-7 lg:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Closed -->
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 hover:shadow-xl transform hover:scale-[1.02] transition">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-2 sm:mb-0">
                    <p class="text-gray-600 font-medium text-xs sm:text-sm mb-1">Closed</p>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-red-600">
                        {{ $mountains->where('status', 'closed')->count() }}
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-red-500 rounded-xl flex items-center justify-center self-end sm:self-auto">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-7 lg:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Avg Price -->
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 hover:shadow-xl transform hover:scale-[1.02] transition">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-2 sm:mb-0">
                    <p class="text-gray-600 font-medium text-xs sm:text-sm mb-1">Avg. Price</p>
                    <p class="text-base sm:text-lg lg:text-2xl font-bold text-blue-600">
                        Rp {{ number_format($mountains->avg('ticket_price'), 0, ',', '.') }}
                    </p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-blue-500 rounded-xl flex items-center justify-center self-end sm:self-auto">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-7 lg:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 mb-6">
        <form method="GET" action="{{ route('admin.mountains.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <!-- Search Bar with Autocomplete -->
                <div class="md:col-span-7 relative">
                    <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Search Mountains
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               id="searchInput"
                               value="{{ request('search') }}"
                               class="w-full px-4 py-3 pl-11 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-100 outline-none transition-all"
                               placeholder="Search by mountain name or location..."
                               autocomplete="off">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        
                        <!-- Autocomplete Dropdown -->
                        <div id="autocompleteResults" class="hidden absolute z-50 w-full mt-2 bg-white border-2 border-purple-200 rounded-xl shadow-2xl max-h-64 overflow-y-auto">
                            <!-- Results will be inserted here by JavaScript -->
                        </div>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="md:col-span-3">
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Status Filter
                    </label>
                    <select name="status" 
                            id="statusFilter"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-100 outline-none transition-all">
                        <option value="">All Status</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="md:col-span-2 flex flex-col justify-end">
                    <div class="flex gap-2">
                        <button type="submit" 
                                class="flex-1 px-4 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold rounded-xl hover:shadow-lg transform hover:scale-[1.02] transition-all flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                        @if(request('search') || request('status'))
                            <a href="{{ route('admin.mountains.index') }}" 
                               class="flex-1 px-4 py-3 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition-all flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Active Filters Display -->
            @if(request('search') || request('status'))
                <div class="flex flex-wrap items-center gap-2 pt-3 border-t border-gray-200">
                    <span class="text-sm font-semibold text-gray-600">Active Filters:</span>
                    @if(request('search'))
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-purple-100 text-purple-800 text-sm font-semibold rounded-full">
                            Search: "{{ request('search') }}"
                            <a href="{{ route('admin.mountains.index', array_filter(['status' => request('status')])) }}" class="hover:text-purple-900">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        </span>
                    @endif
                    @if(request('status'))
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">
                            Status: {{ ucfirst(request('status')) }}
                            <a href="{{ route('admin.mountains.index', array_filter(['search' => request('search')])) }}" class="hover:text-blue-900">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        </span>
                    @endif
                </div>
            @endif
        </form>
    </div>

    <!-- Mountains List -->
    <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6">
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900">Mountains List</h3>
                <span class="mt-2 sm:mt-0 text-xs sm:text-sm text-gray-500">Total: {{ $mountains->count() }} mountains</span>
            </div>

            @if($mountains->count() > 0)
                
                <!-- Mobile Card View (Hidden on Desktop) -->
                <div class="block lg:hidden space-y-4">
                    @foreach ($mountains as $mountain)
                    <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl p-4 shadow-md hover:shadow-lg transition-all duration-200">
                        <!-- Header Card -->
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center flex-1">
                                <div class="w-2 h-2 bg-purple-600 rounded-full mr-3 flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-base font-bold text-gray-900 truncate">{{ $mountain->name }}</h4>
                                    <div class="flex items-center text-xs text-gray-600 mt-1">
                                        <svg class="w-3 h-3 text-gray-400 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="truncate">{{ $mountain->location }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Status Badge -->
                            @if($mountain->status == 'open')
                                <span class="px-2 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-green-400 to-green-600 text-white shadow-sm ml-2 flex-shrink-0">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Open
                                </span>
                            @else
                                <span class="px-2 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-red-400 to-red-600 text-white shadow-sm ml-2 flex-shrink-0">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 001.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Closed
                                </span>
                            @endif
                        </div>

                        <!-- Info Grid -->
                        <div class="grid grid-cols-2 gap-3 mb-3 pt-3 border-t border-purple-200">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Price</p>
                                <p class="text-sm font-bold text-blue-600">Rp {{ number_format($mountain->ticket_price, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Daily Quota</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $mountain->daily_quota }} / day</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2 pt-3 border-t border-purple-200">
                            <a href="{{ route('admin.mountains.edit', $mountain) }}" 
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-bold bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-lg hover:shadow-md transition-all duration-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>

                            <form action="{{ route('admin.mountains.destroy', $mountain) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center px-3 py-2 text-xs font-bold bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:shadow-md transition-all duration-200" 
                                        onclick="return confirm('Are you sure you want to delete this mountain?')">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </button>
                            </form>

                            <a href="{{ route('admin.mountains.quotas.index', $mountain) }}" 
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-bold bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:shadow-md transition-all duration-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Quotas
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Desktop Table View (Hidden on Mobile) -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-purple-50 to-blue-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Mountain Name</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Location</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Daily Quota</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-purple-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($mountains as $mountain)
                            <tr class="hover:bg-gradient-to-r hover:from-purple-50 hover:to-blue-50 transition-all duration-200">
                                <td class="px-6 py-4 whitespace-nowrap align-middle">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-purple-600 rounded-full mr-3"></div>
                                        <span class="text-sm font-bold text-gray-900">{{ $mountain->name }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 align-middle">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $mountain->location }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600 align-middle">
                                    Rp {{ number_format($mountain->ticket_price, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 align-middle">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        {{ $mountain->daily_quota }} / day
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap align-middle">
                                    @if($mountain->status == 'open')
                                        <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-green-400 to-green-600 text-white shadow-sm">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Open
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-red-400 to-red-600 text-white shadow-sm">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 001.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Closed
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.mountains.edit', $mountain) }}" 
                                           class="inline-flex items-center px-3 py-1.5 text-sm bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-bold rounded-lg hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.mountains.destroy', $mountain) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-1.5 text-sm bg-gradient-to-r from-red-500 to-red-600 text-white font-bold rounded-lg hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200" 
                                                    onclick="return confirm('Are you sure you want to delete this mountain?')">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>

                                        <a href="{{ route('admin.mountains.quotas.index', $mountain) }}" 
                                           class="inline-flex items-center px-3 py-1.5 text-sm bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-lg hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200">
                                            Manage Quotas
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No mountains found</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by adding a new mountain.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.mountains.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold rounded-xl hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add New Mountain
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

@push('scripts')
<script>
// Autocomplete functionality
const searchInput = document.getElementById('searchInput');
const autocompleteResults = document.getElementById('autocompleteResults');
let debounceTimer;
let selectedIndex = -1;

// Debounce function
function debounce(func, delay) {
    return function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(func, delay);
    };
}

// Fetch autocomplete results
async function fetchAutocomplete(query) {
    if (query.length < 2) {
        autocompleteResults.classList.add('hidden');
        return;
    }

    try {
        console.log('Fetching autocomplete for:', query);
        const url = `{{ route('admin.mountains.autocomplete') }}?query=${encodeURIComponent(query)}`;
        console.log('Request URL:', url);
        
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        console.log('Response status:', response.status);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        console.log('Autocomplete data:', data);
        
        if (data.length > 0) {
            displayResults(data);
        } else {
            autocompleteResults.innerHTML = `
                <div class="p-4 text-center text-gray-500 text-sm">
                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    No mountains found
                </div>
            `;
            autocompleteResults.classList.remove('hidden');
        }
    } catch (error) {
        console.error('Autocomplete error:', error);
        autocompleteResults.innerHTML = `
            <div class="p-4 text-center text-red-500 text-sm">
                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Error loading suggestions
            </div>
        `;
        autocompleteResults.classList.remove('hidden');
    }
}

// Display autocomplete results
function displayResults(results) {
    autocompleteResults.innerHTML = results.map((mountain, index) => `
        <div class="autocomplete-item p-3 hover:bg-purple-50 cursor-pointer transition-colors border-b border-gray-100 last:border-b-0 ${index === selectedIndex ? 'bg-purple-50' : ''}"
             data-index="${index}"
             data-name="${mountain.name}"
             onclick="selectMountain('${mountain.name}')">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="font-semibold text-gray-900">${mountain.name}</div>
                    <div class="text-xs text-gray-600 mt-1 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        ${mountain.location}
                    </div>
                </div>
                <div class="ml-3">
                    ${mountain.status === 'open' 
                        ? '<span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">Open</span>'
                        : '<span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full">Closed</span>'
                    }
                </div>
            </div>
        </div>
    `).join('');
    
    autocompleteResults.classList.remove('hidden');
    selectedIndex = -1;
}

// Select mountain from autocomplete
function selectMountain(name) {
    searchInput.value = name;
    autocompleteResults.classList.add('hidden');
    searchInput.form.submit();
}

// Event listeners
searchInput.addEventListener('input', debounce(function() {
    const query = this.value.trim();
    fetchAutocomplete(query);
}, 300));

// Keyboard navigation
searchInput.addEventListener('keydown', function(e) {
    const items = autocompleteResults.querySelectorAll('.autocomplete-item');
    
    if (e.key === 'ArrowDown') {
        e.preventDefault();
        selectedIndex = Math.min(selectedIndex + 1, items.length - 1);
        updateSelection(items);
    } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        selectedIndex = Math.max(selectedIndex - 1, -1);
        updateSelection(items);
    } else if (e.key === 'Enter' && selectedIndex >= 0) {
        e.preventDefault();
        const selectedItem = items[selectedIndex];
        if (selectedItem) {
            selectMountain(selectedItem.dataset.name);
        }
    } else if (e.key === 'Escape') {
        autocompleteResults.classList.add('hidden');
        selectedIndex = -1;
    }
});

// Update selection highlighting
function updateSelection(items) {
    items.forEach((item, index) => {
        if (index === selectedIndex) {
            item.classList.add('bg-purple-50');
            item.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
        } else {
            item.classList.remove('bg-purple-50');
        }
    });
}

// Click outside to close
document.addEventListener('click', function(e) {
    if (!searchInput.contains(e.target) && !autocompleteResults.contains(e.target)) {
        autocompleteResults.classList.add('hidden');
        selectedIndex = -1;
    }
});

// Focus on search input with keyboard shortcut (Ctrl/Cmd + K)
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        searchInput.focus();
    }
});
</script>
@endpush
@endsection