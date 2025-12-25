@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <a href="{{ route('admin.vouchers.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-purple-600 transition-colors mb-3 group">
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Vouchers
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                        Create New Voucher
                    </h1>
                    <p class="text-gray-600 mt-1">Set up a new discount voucher for your customers</p>
                </div>
                <div class="hidden sm:block">
                    <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-2xl shadow-lg p-4">
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.vouchers.store') }}" method="POST">
            @csrf

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
                    <p class="text-purple-100 text-sm mt-1">Fill in all the required information below</p>
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
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none font-mono text-sm uppercase" 
                                    value="{{ old('code') }}" 
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
                            <input type="text" name="name" id="name" 
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none" 
                                value="{{ old('name') }}" 
                                required
                                placeholder="e.g., Summer Sale 2024">
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
                            <select name="type" id="type" 
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none appearance-none bg-white" 
                                required>
                                <option value="">-- Select Type --</option>
                                <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount (Rp)</option>
                            </select>
                            @error('type')
                                <p class="text-sm text-red-600 flex items-center mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Value -->
                        <div class="space-y-2">
                            <label for="value" class="block text-sm font-semibold text-gray-700">Discount Value</label>
                            <input type="number" step="0.01" name="value" id="value" 
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none" 
                                value="{{ old('value') }}" 
                                required
                                placeholder="e.g., 30">
                            @error('value')
                                <p class="text-sm text-red-600 flex items-center mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Valid From -->
                        <div class="space-y-2">
                            <label for="valid_from" class="block text-sm font-semibold text-gray-700">Valid From</label>
                            <input type="datetime-local" name="valid_from" id="valid_from" 
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none" 
                                value="{{ old('valid_from') }}">
                            <p class="text-xs text-gray-500 mt-1">Leave empty for immediate activation</p>
                        </div>

                        <!-- Valid Until -->
                        <div class="space-y-2">
                            <label for="valid_until" class="block text-sm font-semibold text-gray-700">Valid Until</label>
                            <input type="datetime-local" name="valid_until" id="valid_until" 
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none" 
                                value="{{ old('valid_until') }}">
                            <p class="text-xs text-gray-500 mt-1">Leave empty for no expiration</p>
                        </div>

                        <!-- Usage Limit -->
                        <div class="space-y-2">
                            <label for="usage_limit" class="block text-sm font-semibold text-gray-700">Usage Limit (Total)</label>
                            <input type="number" name="usage_limit" id="usage_limit" 
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none" 
                                value="{{ old('usage_limit', 0) }}"
                                placeholder="0 = Unlimited">
                        </div>

                        <!-- User Usage Limit -->
                        <div class="space-y-2">
                            <label for="user_usage_limit" class="block text-sm font-semibold text-gray-700">User Usage Limit</label>
                            <input type="number" name="user_usage_limit" id="user_usage_limit" 
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none" 
                                value="{{ old('user_usage_limit', 1) }}" 
                                min="1"
                                placeholder="e.g., 2">
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="bg-gray-50 px-8 py-6 border-t border-gray-100 flex justify-between items-center">
                    <div class="text-sm text-gray-500 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 9H7a2 2 0 01-2-2V7a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"/>
                        </svg>
                        Make sure all details are correct before saving
                    </div>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-transform transform hover:-translate-y-0.5">
                        Save Voucher
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto uppercase voucher code
    document.getElementById('code').addEventListener('input', function(e) {
        e.target.value = e.target.value.toUpperCase();
    });

    // Dynamic value placeholder based on type
    document.getElementById('type').addEventListener('change', function(e) {
        const valueInput = document.getElementById('value');
        if (e.target.value === 'percentage') {
            valueInput.placeholder = 'e.g., 30 (for 30%)';
        } else if (e.target.value === 'fixed') {
            valueInput.placeholder = 'e.g., 50000 (Rp 50,000)';
        } else {
            valueInput.placeholder = 'e.g., 30';
        }
    });
</script>
@endsection
