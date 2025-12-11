@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <a href="{{ route('admin.vouchers.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-purple-600 transition-colors mb-3 group">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Vouchers
                </a>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                    Edit Voucher
                </h1>
                <p class="text-gray-600 mt-1">Update voucher details and settings</p>
            </div>
            <div class="hidden sm:block">
                <div class="bg-white rounded-2xl shadow-lg px-6 py-3 border border-purple-100">
                    <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">Voucher Code</div>
                    <div class="text-xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                        {{ $voucher->code }}
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.vouchers.update', $voucher) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Main Card -->
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-purple-600 to-blue-600 px-8 py-6">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                        Voucher Information
                    </h2>
                </div>

                <!-- Form Fields -->
                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Voucher Code -->
                        <div class="space-y-2">
                            <label for="code" class="block text-sm font-semibold text-gray-700 flex items-center">
                                Voucher Code
                            </label>
                            <div class="relative">
                                <input type="text" name="code" id="code" 
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none font-mono text-sm" 
                                    value="{{ old('code', $voucher->code) }}" 
                                    required
                                    placeholder="e.g., SUMMER2024">
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                    </svg>
                                </div>
                            </div>
                            @error('code')
                                <p class="text-sm text-red-600 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Voucher Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700 flex items-center">
                                Voucher Name
                            </label>
                            <div class="relative">
                                <input type="text" name="name" id="name" 
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none" 
                                    value="{{ old('name', $voucher->name) }}" 
                                    required
                                    placeholder="e.g., Summer Sale 2024">
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                            </div>
                            @error('name')
                                <p class="text-sm text-red-600 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div class="space-y-2">
                            <label for="type" class="block text-sm font-semibold text-gray-700 flex items-center">
                                Discount Type
                            </label>
                            <div class="relative">
                                <select name="type" id="type" 
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none appearance-none bg-white" 
                                    required>
                                    <option value="">-- Select Type --</option>
                                    <option value="percentage" {{ old('type', $voucher->type) == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                    <option value="fixed" {{ old('type', $voucher->type) == 'fixed' ? 'selected' : '' }}>Fixed Amount (Rp)</option>
                                </select>
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            @error('type')
                                <p class="text-sm text-red-600 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Value -->
                        <div class="space-y-2">
                            <label for="value" class="block text-sm font-semibold text-gray-700 flex items-center">
                                Discount Value
                            </label>
                            <div class="relative">
                                <input type="number" step="0.01" name="value" id="value" 
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none" 
                                    value="{{ old('value', $voucher->value) }}" 
                                    required
                                    placeholder="e.g., 30">
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            @error('value')
                                <p class="text-sm text-red-600 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Valid From -->
                        <div class="space-y-2">
                            <label for="valid_from" class="block text-sm font-semibold text-gray-700 flex items-center">
                                Valid From
                            </label>
                            <div class="relative">
                                <input type="datetime-local" name="valid_from" id="valid_from" 
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none" 
                                    value="{{ old('valid_from', $voucher->valid_from ? $voucher->valid_from->format('Y-m-d\TH:i') : '') }}">
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                </div>
                            </div>
                            @error('valid_from')
                                <p class="text-sm text-red-600 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Valid Until -->
                        <div class="space-y-2">
                            <label for="valid_until" class="block text-sm font-semibold text-gray-700 flex items-center">
                                Valid Until
                            </label>
                            <div class="relative">
                                <input type="datetime-local" name="valid_until" id="valid_until" 
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none" 
                                    value="{{ old('valid_until', $voucher->valid_until ? $voucher->valid_until->format('Y-m-d\TH:i') : '') }}">
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                </div>
                            </div>
                            @error('valid_until')
                                <p class="text-sm text-red-600 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Usage Limit -->
                        <div class="space-y-2">
                            <label for="usage_limit" class="block text-sm font-semibold text-gray-700 flex items-center">
                                Usage Limit (Total)
                            </label>
                            <div class="relative">
                                <input type="number" name="usage_limit" id="usage_limit" 
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none" 
                                    value="{{ old('usage_limit', $voucher->usage_limit) }}"
                                    placeholder="0 = Unlimited">
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 flex items-center mt-1">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Set to 0 for unlimited usage
                            </p>
                            @error('usage_limit')
                                <p class="text-sm text-red-600 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- User Usage Limit -->
                        <div class="space-y-2">
                            <label for="user_usage_limit" class="block text-sm font-semibold text-gray-700 flex items-center">
                                User Usage Limit
                            </label>
                            <div class="relative">
                                <input type="number" name="user_usage_limit" id="user_usage_limit" 
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none" 
                                    value="{{ old('user_usage_limit', $voucher->user_usage_limit) }}" 
                                    min="1"
                                    placeholder="e.g., 2">
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 flex items-center mt-1">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Max uses per user
                            </p>
                            @error('user_usage_limit')
                                <p class="text-sm text-red-600 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="bg-gray-50 px-8 py-6 border-t border-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            All fields are required unless specified
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.vouchers.index') }}" 
                                class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 rounded-xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all focus:outline-none focus:ring-4 focus:ring-gray-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" 
                                class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 transition-all focus:outline-none focus:ring-4 focus:ring-purple-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Info Cards -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl shadow-md p-5 border border-purple-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Status</p>
                        <p class="text-lg font-bold text-gray-900">Active</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-5 border border-blue-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Created</p>
                        <p class="text-lg font-bold text-gray-900">{{ $voucher->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-5 border border-green-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Last Updated</p>
                        <p class="text-lg font-bold text-gray-900">{{ $voucher->updated_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection