@extends('layouts.admin')

@section('title', 'Add New Mountain')
@section('header-title', 'Add New Mountain')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <nav class="flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('admin.mountains.index') }}" class="hover:text-gray-700 transition-colors">Mountains</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-900 font-medium">Add New Mountain</span>
    </nav>

    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl p-5 shadow-sm">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div class="p-2 bg-blue-500 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Creating a New Mountain</h3>
                <p class="text-sm text-gray-700">Fill in all required fields to add a new mountain to the system. You can add trail routes after saving the mountain.</p>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-5 shadow-sm animate-shake">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-red-800 font-bold text-sm mb-2">Please fix the following errors:</h3>
                    <ul class="list-disc pl-5 space-y-1 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.mountains.store') }}" method="POST" class="space-y-6" id="createMountainForm" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Basic Information</h3>
                        <p class="text-sm text-gray-600">Essential details about the mountain</p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <div class="group">
                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        Mountain Name
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition-all duration-200 placeholder-gray-400"
                           placeholder="e.g., Mount Everest">
                    <p class="mt-1.5 text-xs text-gray-500">Enter the official name of the mountain</p>
                </div>

                <div class="group">
                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Location
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="location" value="{{ old('location') }}" required
                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition-all duration-200 placeholder-gray-400"
                           placeholder="e.g., Temanggung, Wonosobo">
                    <p class="mt-1.5 text-xs text-gray-500">City or region where the mountain is located</p>
                </div>

            <div>
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Featured Image</label>
                <div class="flex items-center justify-center w-full">
                    <label id="dropzone" for="image" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                        <input type="file" 
                               name="image" 
                               id="image"
                               accept="image/*"
                               class="hidden"
                               onchange="previewImage(event)">
                    </label>
                </div>
                
                {{-- Image Preview --}}
                <div id="imagePreview" class="mt-4 hidden">
                    <img id="preview" src="" alt="Preview" class="max-w-full h-auto rounded-xl shadow-md">
                </div>
                
                @error('image')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
                <div class="group">
                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        Description
                    </label>
                    <textarea name="description" rows="5" maxlength="1000"
                              class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-100 outline-none transition-all duration-200 resize-none placeholder-gray-400"
                              placeholder="Describe the mountain, its features, attractions, and important information for visitors..."
                              oninput="updateCharCount(this)">{{ old('description') }}</textarea>
                    <div class="flex justify-between items-center mt-1.5">
                        <p class="text-xs text-gray-500">Provide detailed information about the mountain</p>
                        <span id="charCount" class="text-xs text-gray-500">0/1000</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Pricing & Capacity</h3>
                        <p class="text-sm text-gray-600">Set ticket price and daily visitor limits</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <div class="group">
        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
            Ticket Price <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
            <input type="number" name="ticket_price" value="{{ old('ticket_price') }}" required min="0"
                   class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 outline-none transition-all">
        </div>
    </div>

    <div class="group">
        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
            Elevation
            <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input type="number" name="height" value="{{ old('height') }}" required min="0"
                   class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 outline-none transition-all"
                   placeholder="3676">
            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-semibold">MDPL</span>
        </div>
        <p class="mt-1.5 text-xs text-gray-500">Height in Meters Above Sea Level</p>
    </div>

    <div class="group">
        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
            Daily Quota <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input type="number" name="daily_quota" value="{{ old('daily_quota') }}" required min="1"
                   class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 outline-none transition-all">
            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm">visitors</span>
        </div>
    </div>
</div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Mountain Status</h3>
                        <p class="text-sm text-gray-600">Set initial accessibility for visitors</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-3">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Initial Status
                    <span class="text-red-500">*</span>
                </label>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="status" value="open" {{ old('status', 'open') == 'open' ? 'checked' : '' }}
                               class="peer sr-only">
                        <div class="p-5 bg-gray-50 border-2 border-gray-200 rounded-xl peer-checked:bg-green-50 peer-checked:border-green-500 peer-checked:ring-4 peer-checked:ring-green-100 transition-all duration-200 hover:border-gray-300">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-green-100 rounded-lg peer-checked:bg-green-500 transition-colors">
                                        <svg class="w-5 h-5 text-green-600 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <span class="font-bold text-gray-900 text-lg">Open</span>
                                </div>
                                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-green-500 peer-checked:bg-green-500 flex items-center justify-center transition-all">
                                    <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="currentColor" viewBox="0 0 12 12">
                                        <path d="M10 3L4.5 8.5L2 6"/>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600">Mountain will be accessible for visitors and accepting bookings</p>
                        </div>
                    </label>

                    <label class="relative cursor-pointer group">
                        <input type="radio" name="status" value="closed" {{ old('status') == 'closed' ? 'checked' : '' }}
                               class="peer sr-only">
                        <div class="p-5 bg-gray-50 border-2 border-gray-200 rounded-xl peer-checked:bg-red-50 peer-checked:border-red-500 peer-checked:ring-4 peer-checked:ring-red-100 transition-all duration-200 hover:border-gray-300">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-red-100 rounded-lg peer-checked:bg-red-500 transition-colors">
                                        <svg class="w-5 h-5 text-red-600 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <span class="font-bold text-gray-900 text-lg">Closed</span>
                                </div>
                                <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-red-500 peer-checked:bg-red-500 flex items-center justify-center transition-all">
                                    <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="currentColor" viewBox="0 0 12 12">
                                        <path d="M10 3L4.5 8.5L2 6"/>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600">Mountain will be temporarily closed and not accepting bookings</p>
                        </div>
                    </label>
                </div>

                <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-blue-900 mb-1">Status Information</p>
                            <p class="text-xs text-blue-700">Choose "Open" to allow immediate bookings. You can change this status anytime after creating the mountain.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900">Trail Routes (Optional)</h3>
                        <p class="text-sm text-gray-600">Add hiking paths - you can also add these later</p>
                    </div>
                    <button type="button" onclick="toggleTrailRoutes()" 
                            class="px-4 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 font-semibold rounded-lg transition-all text-sm flex items-center gap-2">
                        <svg id="toggleIcon" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        <span id="toggleText">Show</span>
                    </button>
                </div>
            </div>

            <div id="trailRoutesSection" class="hidden">
                <div class="p-6 space-y-4">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                        <div class="flex gap-3">
                            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-yellow-900 mb-1">Optional Section</p>
                                <p class="text-xs text-yellow-800">Trail routes can be added now or later after creating the mountain. Click "Add Route" button to add multiple routes.</p>
                            </div>
                        </div>
                    </div>

                    <div id="trailRoutesContainer" class="space-y-3">
                        </div>

                    <button type="button" onclick="addTrailRouteField()" 
                            class="w-full py-3 px-4 border-2 border-dashed border-gray-300 hover:border-purple-400 bg-gray-50 hover:bg-purple-50 text-gray-600 hover:text-purple-700 font-semibold rounded-xl transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add Trail Route
                    </button>
                </div>
            </div>
        </div>

        <div class="sticky bottom-0 bg-white/95 backdrop-blur-sm border-t-2 border-gray-100 rounded-2xl shadow-2xl p-5 z-10">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2 text-sm text-gray-500 w-full sm:w-auto">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="hidden sm:inline">Fill all required fields to create mountain</span>
                </div>
                
                <div class="flex flex-col sm:flex-row w-full sm:w-auto gap-3">
                    <a href="{{ route('admin.mountains.index') }}"
                       class="w-full sm:w-auto px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl text-center transition-all duration-200 border-2 border-gray-200 hover:border-gray-300">
                        Cancel
                    </a>
                    <button type="submit"
                            class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-bold rounded-xl hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Mountain
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
let trailRouteCount = 0;

// Character counter for description textarea
function updateCharCount(textarea) {
    const charCount = document.getElementById('charCount');
    const currentLength = textarea.value.length;
    const maxLength = 1000;
    charCount.textContent = `${currentLength}/${maxLength}`;
    
    // Change color based on character count
    if (currentLength > maxLength * 0.9) {
        charCount.classList.add('text-red-500', 'font-bold');
        charCount.classList.remove('text-gray-500');
    } else if (currentLength > maxLength * 0.7) {
        charCount.classList.add('text-yellow-600', 'font-semibold');
        charCount.classList.remove('text-gray-500', 'text-red-500');
    } else {
        charCount.classList.add('text-gray-500');
        charCount.classList.remove('text-red-500', 'text-yellow-600', 'font-bold', 'font-semibold');
    }
}

// Toggle trail routes section
function toggleTrailRoutes() {
    const section = document.getElementById('trailRoutesSection');
    const icon = document.getElementById('toggleIcon');
    const text = document.getElementById('toggleText');
    
    section.classList.toggle('hidden');
    
    if (section.classList.contains('hidden')) {
        icon.style.transform = 'rotate(0deg)';
        text.textContent = 'Show';
    } else {
        icon.style.transform = 'rotate(180deg)';
        text.textContent = 'Hide';
    }
}

// Add trail route field
function addTrailRouteField() {
    trailRouteCount++;
    const container = document.getElementById('trailRoutesContainer');
    
    const routeField = document.createElement('div');
    routeField.className = 'bg-gray-50 border-2 border-gray-200 rounded-xl p-4 animate-slideIn';
    routeField.id = `trailRoute_${trailRouteCount}`;
    
    routeField.innerHTML = `
        <div class="flex items-start justify-between mb-3">
            <h4 class="font-bold text-gray-900 flex items-center gap-2">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                Trail Route #${trailRouteCount}
            </h4>
            <button type="button" onclick="removeTrailRoute(${trailRouteCount})" 
                    class="text-red-500 hover:text-red-700 hover:bg-red-100 p-1 rounded-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Route Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="trail_routes[${trailRouteCount}][name]" required
                       class="w-full px-4 py-2.5 bg-white border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-100 outline-none transition-all"
                       placeholder="e.g., Via Mawar">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Description (Optional)
                </label>
                <input type="text" name="trail_routes[${trailRouteCount}][description]"
                       class="w-full px-4 py-2.5 bg-white border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-100 outline-none transition-all"
                       placeholder="Brief route description">
            </div>
        </div>
        <div class="mt-3">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
            <div class="flex gap-3">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="trail_routes[${trailRouteCount}][status]" value="open" checked
                           class="w-4 h-4 text-green-600 focus:ring-green-500">
                    <span class="text-sm font-medium text-gray-700">Open</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="trail_routes[${trailRouteCount}][status]" value="closed"
                           class="w-4 h-4 text-red-600 focus:ring-red-500">
                    <span class="text-sm font-medium text-gray-700">Closed</span>
                </label>
            </div>
        </div>
    `;
    
    container.appendChild(routeField);
    
    // Scroll to the new field
    setTimeout(() => {
        routeField.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }, 100);
}

// Remove trail route field
function removeTrailRoute(id) {
    const element = document.getElementById(`trailRoute_${id}`);
    if (element) {
        element.classList.add('animate-slideOut');
        setTimeout(() => {
            element.remove();
            // Renumber remaining routes
            renumberTrailRoutes();
        }, 300);
    }
}

// Renumber trail routes after deletion
function renumberTrailRoutes() {
    const routes = document.querySelectorAll('[id^="trailRoute_"]');
    routes.forEach((route, index) => {
        const title = route.querySelector('h4');
        if (title) {
            const svg = title.querySelector('svg');
            title.innerHTML = '';
            title.appendChild(svg);
            title.appendChild(document.createTextNode(`Trail Route #${index + 1}`));
        }
    });
}

// Form validation before submit
document.getElementById('createMountainForm').addEventListener('submit', function(e) {
    const requiredFields = this.querySelectorAll('[required]');
    let isValid = true;
    let firstInvalidField = null;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.classList.add('border-red-500', 'ring-4', 'ring-red-100');
            
            if (!firstInvalidField) {
                firstInvalidField = field;
            }
            
            setTimeout(() => {
                field.classList.remove('border-red-500', 'ring-4', 'ring-red-100');
            }, 3000);
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('⚠️ Please fill in all required fields marked with *');
        
        if (firstInvalidField) {
            firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstInvalidField.focus();
        }
    }
});

// Smooth scroll to error messages
window.addEventListener('load', function() {
    const errorAlert = document.querySelector('.bg-red-50');
    if (errorAlert) {
        errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});

// Add animations
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    .animate-shake {
        animation: shake 0.5s ease-in-out;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-slideIn {
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(-20px);
        }
    }
    .animate-slideOut {
        animation: slideOut 0.3s ease-out;
    }
    
    /* Smooth transitions for collapsible sections */
    #trailRoutesSection {
        transition: all 0.3s ease-in-out;
        overflow: hidden;
    }
    
    #trailRoutesSection.hidden {
        max-height: 0;
        opacity: 0;
    }
    
    #trailRoutesSection:not(.hidden) {
        max-height: 5000px;
        opacity: 1;
    }
`;
document.head.appendChild(style);

// Auto-save to localStorage (optional - helps prevent data loss)
const form = document.getElementById('createMountainForm');
const formInputs = form.querySelectorAll('input[type="text"], input[type="number"], textarea, select, input[type="radio"]:checked');

// Load saved data on page load
window.addEventListener('load', function() {
    formInputs.forEach(input => {
        const savedValue = localStorage.getItem(`mountain_form_${input.name}`);
        if (savedValue && !input.value) {
            if (input.type === 'radio') {
                if (input.value === savedValue) {
                    input.checked = true;
                }
            } else {
                input.value = savedValue;
                if (input.tagName === 'TEXTAREA' && input.oninput) {
                    input.oninput({ target: input });
                }
            }
        }
    });
});

// Save data on input change
form.addEventListener('input', function(e) {
    if (e.target.name) {
        localStorage.setItem(`mountain_form_${e.target.name}`, e.target.value);
    }
});

// Clear localStorage on successful submit
form.addEventListener('submit', function() {
    if (this.checkValidity()) {
        formInputs.forEach(input => {
            localStorage.removeItem(`mountain_form_${input.name}`);
        });
    }
});

// Warn user about unsaved changes
let formChanged = false;
form.addEventListener('change', function() {
    formChanged = true;
});

window.addEventListener('beforeunload', function(e) {
    if (formChanged) {
        e.preventDefault();
        e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
        return e.returnValue;
    }
});

// Remove warning when form is submitted
form.addEventListener('submit', function() {
    formChanged = false;
});

// Image preview function
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

// Drag and Drop functionality
const dropZone = document.getElementById('dropzone');
const fileInput = document.getElementById('image');

if (dropZone && fileInput) {
    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Highlight drop zone when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('border-purple-500', 'bg-purple-50');
        dropZone.classList.remove('border-gray-300', 'bg-gray-50');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-purple-500', 'bg-purple-50');
        dropZone.classList.add('border-gray-300', 'bg-gray-50');
    }

    // Handle dropped files
    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length > 0) {
            // Set the file to the input element
            fileInput.files = files;
            
            // Trigger preview
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
            
            // Call preview function directly
            previewImage({ target: { files: files } });
        }
    }
}
</script>
@endsection