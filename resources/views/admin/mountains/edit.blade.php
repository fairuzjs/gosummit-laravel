@extends('layouts.admin')

@section('title', 'Edit Mountain')
@section('header-title', 'Edit Mountain')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <nav class="flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('admin.mountains.index') }}" class="hover:text-gray-700 transition-colors">Mountains</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-900 font-medium">Edit: {{ $mountain->name }}</span>
    </nav>

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

    <form action="{{ route('admin.mountains.update', $mountain) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
                    <input type="text" name="name" value="{{ old('name', $mountain->name) }}" required
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
                    <input type="text" name="location" value="{{ old('location', $mountain->location) }}" required
                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition-all duration-200 placeholder-gray-400"
                           placeholder="e.g., Temanggung, Wonosobo">
                    <p class="mt-1.5 text-xs text-gray-500">City or region where the mountain is located</p>
                </div>

                <div class="group">
                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Mountain Image {{ $mountain->image_url ? '(Replace)' : '' }}
                    </label>
                    
                    @if ($mountain->image_url)
                        <div class="mb-3">
                            <p class="text-xs font-semibold text-gray-700 mb-2">Current Image:</p>
                            <div class="relative inline-block">
                                <img src="{{ asset('storage/' . $mountain->image_url) }}" alt="Current Mountain Image" class="max-w-md w-full h-auto rounded-xl shadow-md">
                                <div class="absolute top-2 right-2">
                                    <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">Current</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    
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
                        <p class="text-sm font-semibold text-gray-700 mb-2">New Image Preview:</p>
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
                              oninput="updateCharCount(this)">{{ old('description', $mountain->description) }}</textarea>
                    <div class="flex justify-between items-center mt-1.5">
                        <p class="text-xs text-gray-500">Provide detailed information about the mountain</p>
                        <span id="charCount" class="text-xs text-gray-500">{{ strlen($mountain->description ?? '') }}/1000</span>
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
                        <h3 class="text-lg font-bold text-gray-900">Pricing, Height & Capacity</h3>
                        <p class="text-sm text-gray-600">Set ticket price, elevation, and daily visitor limits</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="group">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a2 2 0 10-4 0v5a2 2 0 01-2 2h6m-6-4h4m8 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Ticket Price
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                            <input type="number" name="ticket_price" value="{{ old('ticket_price', $mountain->ticket_price) }}" required min="0"
                                   class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 outline-none transition-all duration-200"
                                   placeholder="30000">
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500">Price per person</p>
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
                            <input type="number" name="height" value="{{ old('height', $mountain->height) }}" required min="0"
                                   class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 outline-none transition-all duration-200"
                                   placeholder="3676">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-semibold">MDPL</span>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500">Height in Meters Above Sea Level</p>
                    </div>

                    <div class="group">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Daily Quota
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="daily_quota" value="{{ old('daily_quota', $mountain->daily_quota) }}" required min="1"
                                   class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 outline-none transition-all duration-200"
                                   placeholder="100">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm">visitors/day</span>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500">Max visitors per day</p>
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
                        <p class="text-sm text-gray-600">Control mountain accessibility for visitors</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-3">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Current Status
                    <span class="text-red-500">*</span>
                </label>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="status" value="open" {{ old('status', $mountain->status) == 'open' ? 'checked' : '' }}
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
                            <p class="text-sm text-gray-600">Mountain is accessible for visitors and accepting bookings</p>
                        </div>
                    </label>

                    <label class="relative cursor-pointer group">
                        <input type="radio" name="status" value="closed" {{ old('status', $mountain->status) == 'closed' ? 'checked' : '' }}
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
                            <p class="text-sm text-gray-600">Mountain is temporarily closed and not accepting bookings</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="sticky bottom-0 bg-white/95 backdrop-blur-sm border-t-2 border-gray-100 rounded-2xl shadow-2xl p-5 z-10">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2 text-sm text-gray-500 w-full sm:w-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="hidden sm:inline">Last updated: {{ $mountain->updated_at->diffForHumans() }}</span>
                </div>
                
                <div class="flex flex-col sm:flex-row w-full sm:w-auto gap-3">
                    <a href="{{ route('admin.mountains.index') }}"
                       class="w-full sm:w-auto px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl text-center transition-all duration-200 border-2 border-gray-200 hover:border-gray-300">
                        Cancel
                    </a>
                    <button type="submit"
                            class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-bold rounded-xl hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Mountain
                    </button>
                </div>
            </div>
        </div>
    </form>

    <div class="relative my-8">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t-2 border-gray-200"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="px-6 py-2 bg-gradient-to-r from-purple-50 to-pink-50 text-gray-700 font-bold rounded-full border-2 border-gray-200 shadow-sm">
                Trail Routes Management
            </span>
        </div>
    </div>

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="p-2 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                    </div>
                    Trail Routes
                </h3>
                <p class="text-gray-600 mt-1">Manage hiking paths and routes for {{ $mountain->name }}</p>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl shadow-lg border-2 border-green-200 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-green-500 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-gray-900">Add New Route</h4>
            </div>
            
            <form action="{{ route('admin.trail-routes.store', $mountain) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div>
                        <label for="new_route_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Route Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="new_route_name" required
                               class="w-full px-4 py-3 bg-white border-2 border-green-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 outline-none transition-all"
                               placeholder="e.g., Via Mawar">
                    </div>
                    <div>
                        <label for="new_route_description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Description (Optional)
                        </label>
                        <input type="text" name="description" id="new_route_description"
                               class="w-full px-4 py-3 bg-white border-2 border-green-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 outline-none transition-all"
                               placeholder="Brief route description">
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full py-3 px-6 bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add Route
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                    </svg>
                                    Route Name
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider hidden md:table-cell">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                    </svg>
                                    Description
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Status
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center justify-end gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                    </svg>
                                    Actions
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($mountain->trailRoutes as $route)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                {{-- PERBAIKAN 1: Hapus whitespace-nowrap dan tambahkan break-words --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-purple-100 rounded-lg">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                            </svg>
                                        </div>
                                        {{-- Tambahkan break-words untuk menghindari horizontal scroll pada nama panjang --}}
                                        <span class="text-sm font-bold text-gray-900 break-words">{{ $route->name }}</span> 
                                    </div>
                                </td>
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <span class="text-sm text-gray-600">{{ $route->description ?? '-' }}</span>
                                </td>
                                {{-- PERBAIKAN 2: Hapus whitespace-nowrap pada Status TD --}}
                                <td class="px-6 py-4"> 
                                    @if($route->status == 'open')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-100 text-green-800 text-xs font-bold rounded-full">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Open
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-100 text-red-800 text-xs font-bold rounded-full">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                            Closed
                                        </span>
                                    @endif
                                </td>
                                {{-- PERBAIKAN 3: Hapus whitespace-nowrap pada Actions TD dan tambahkan flex-wrap pada div aksi --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2 flex-wrap"> 
                                        <form action="{{ route('admin.trail-routes.toggle', [$mountain, $route]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg font-semibold text-xs transition-all duration-200 transform hover:scale-105 
                                                        @if($route->status == 'open') 
                                                            bg-yellow-500 hover:bg-yellow-600 text-white shadow-md hover:shadow-lg
                                                        @else 
                                                            bg-green-500 hover:bg-green-600 text-white shadow-md hover:shadow-lg
                                                        @endif">
                                                @if($route->status == 'open')
                                                    Close
                                                @else
                                                    Open
                                                @endif
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.trail-routes.destroy', [$mountain, $route]) }}" method="POST" class="inline"
                                              onsubmit="return confirm('⚠️ Are you sure you want to delete this route?\n\nRoute: {{ $route->name }}\n\nThis action cannot be undone!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center gap-1.5 px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold text-xs shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-4 bg-gray-100 rounded-full mb-4">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                            </svg>
                                        </div>
                                        <p class="text-gray-900 font-bold text-lg mb-1">No Trail Routes Yet</p>
                                        <p class="text-gray-500 text-sm">Add your first trail route using the form above</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($mountain->trailRoutes->count() > 0)
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between text-sm space-y-2 sm:space-y-0">
                        <span class="text-gray-600">
                            Total Routes: <span class="font-bold text-gray-900">{{ $mountain->trailRoutes->count() }}</span>
                        </span>
                        <div class="flex items-center gap-4">
                            <span class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                <span class="text-gray-600">Open: <span class="font-bold text-gray-900">{{ $mountain->trailRoutes->where('status', 'open')->count() }}</span></span>
                            </span>
                            <span class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                <span class="text-gray-600">Closed: <span class="font-bold text-gray-900">{{ $mountain->trailRoutes->where('status', 'closed')->count() }}</span></span>
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
// Character counter for description textarea
function updateCharCount(textarea) {
    const charCount = document.getElementById('charCount');
    const currentLength = textarea.value.length;
    const maxLength = 1000;
    charCount.textContent = `${currentLength}/${maxLength}`;
    
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

// Form validation before submit
document.querySelector('form[method="POST"]').addEventListener('submit', function(e) {
    const requiredFields = this.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.classList.add('border-red-500', 'ring-4', 'ring-red-100');
            
            setTimeout(() => {
                field.classList.remove('border-red-500', 'ring-4', 'ring-red-100');
            }, 3000);
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('⚠️ Please fill in all required fields marked with *');
    }
});

// Smooth scroll to error messages
window.addEventListener('load', function() {
    const errorAlert = document.querySelector('.bg-red-50');
    if (errorAlert) {
        errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});

// Add animation for shake effect on error
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
`;
document.head.appendChild(style);

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