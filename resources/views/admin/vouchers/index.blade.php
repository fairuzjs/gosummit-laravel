{{-- resources/views/admin/vouchers/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manage Vouchers')
@section('header-title', 'Manage Vouchers')
@section('header-buttons')
    <a href="{{ route('admin.analytics.index') }}"
       class="inline-flex items-center px-4 py-2.5 bg-gray-200 text-gray-800 font-bold rounded-xl hover:bg-gray-300 transition-all duration-200">
        <span class="hidden sm:inline">Back to Dashboard</span>
        <span class="sm:hidden">Back</span>
    </a>
@endsection

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl space-y-8">

    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-2">
                    Voucher Management
                </h1>
                <p class="text-gray-600">Create and manage discount vouchers for your customers</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.vouchers.create') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold rounded-xl hover:shadow-xl hover:shadow-purple-500/50 transform hover:scale-105 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Voucher
                </a>

                <a href="{{ route('admin.vouchers.report') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-teal-600 text-white font-semibold rounded-xl hover:shadow-xl hover:shadow-green-500/50 transform hover:scale-105 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Vouchers Report
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 sm:p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-xs font-medium mb-1">Total Vouchers</p>
                    <p class="text-xl sm:text-2xl font-bold">{{ $vouchers->total() }}</p>
                </div>
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 sm:p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-xs font-medium mb-1">Active Vouchers</p>
                    <p class="text-xl sm:text-2xl font-bold">{{ $vouchers->where('valid_until', '>=', now())->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-teal-600 rounded-xl p-4 sm:p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-xs font-medium mb-1">Total Usage</p>
                    <p class="text-xl sm:text-2xl font-bold">{{ $vouchers->sum('used_count') }}</p>
                </div>
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Vouchers List -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="p-4 sm:p-6">

            @if($vouchers->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-12 sm:py-16">
                    <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-gradient-to-br from-purple-100 to-blue-100 mb-4 sm:mb-6">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">No Vouchers Yet</h3>
                    <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6">Get started by creating your first voucher</p>
                    <a href="{{ route('admin.vouchers.create') }}" 
                       class="inline-flex items-center px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white text-sm font-semibold rounded-xl hover:shadow-xl hover:shadow-purple-500/50 transform hover:scale-105 transition-all duration-300">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Your First Voucher
                    </a>
                </div>
            @else
                <!-- Desktop Table -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gradient-to-r from-purple-50 to-blue-50">
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Code</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Value</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Valid Period</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Usage</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-purple-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($vouchers as $voucher)
                                <tr class="hover:bg-purple-50/50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg bg-gradient-to-r from-purple-100 to-blue-100 border border-purple-200">
                                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                                </svg>
                                                <span class="font-mono text-sm font-bold text-purple-700">{{ $voucher->code }}</span>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-semibold text-gray-900">{{ $voucher->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                            @if($voucher->type == 'percentage') 
                                                bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-300
                                            @else 
                                                bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300
                                            @endif">
                                            {{ ucfirst($voucher->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-bold text-gray-900">
                                            @if($voucher->type == 'percentage')
                                                <span class="text-blue-600">{{ $voucher->value }}%</span>
                                            @else
                                                <span class="text-green-600">Rp {{ number_format($voucher->value, 0, ',', '.') }}</span>
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-gray-600 space-y-1">
                                            <div class="flex items-center">
                                                <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span>{{ $voucher->valid_from ? $voucher->valid_from->format('d M Y') : '-' }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-3 h-3 mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span>{{ $voucher->valid_until ? $voucher->valid_until->format('d M Y') : '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-1">
                                                <div class="text-xs text-gray-600 mb-1">
                                                    <span class="font-bold text-purple-600">{{ $voucher->used_count }}</span> / 
                                                    <span class="font-semibold">{{ $voucher->usage_limit ?: '∞' }}</span>
                                                </div>
                                                @if($voucher->usage_limit)
                                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                        <div class="bg-gradient-to-r from-purple-600 to-blue-600 h-1.5 rounded-full transition-all duration-300" 
                                                             style="width: {{ min(($voucher->used_count / $voucher->usage_limit) * 100, 100) }}%"></div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.vouchers.edit', $voucher) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.vouchers.destroy', $voucher) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this voucher?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="lg:hidden space-y-4">
                    @foreach($vouchers as $voucher)
                        <div class="bg-white border-2 border-gray-200 rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
                            <!-- Card Header -->
                            <div class="bg-gradient-to-r from-purple-50 to-blue-50 px-4 py-3 border-b border-gray-200">
                                <div class="flex items-center justify-between gap-3 mb-2">
                                    <div class="inline-flex items-center px-2.5 py-1 rounded-lg bg-purple-100 border border-purple-200">
                                        <svg class="w-3.5 h-3.5 mr-1.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                        </svg>
                                        <span class="font-mono text-xs font-bold text-purple-700">{{ $voucher->code }}</span>
                                    </div>
                                    
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full 
                                        @if($voucher->type == 'percentage') 
                                            bg-blue-100 text-blue-800 border border-blue-300
                                        @else 
                                            bg-green-100 text-green-800 border border-green-300
                                        @endif">
                                        {{ ucfirst($voucher->type) }}
                                    </span>
                                </div>

                                <h3 class="text-base font-bold text-gray-900">{{ $voucher->name }}</h3>
                            </div>

                            <!-- Card Body -->
                            <div class="p-4 space-y-3">
                                <!-- Value -->
                                <div class="p-3 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg border border-gray-200">
                                    <p class="text-xs text-gray-600 mb-1">Value</p>
                                    <p class="text-xl font-bold 
                                        @if($voucher->type == 'percentage') text-blue-600 
                                        @else text-green-600 @endif">
                                        @if($voucher->type == 'percentage')
                                            {{ $voucher->value }}%
                                        @else
                                            Rp {{ number_format($voucher->value, 0, ',', '.') }}
                                        @endif
                                    </p>
                                </div>

                                <!-- Valid Period -->
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="p-2.5 bg-gray-50 rounded-lg border border-gray-200">
                                        <p class="text-xs text-gray-600 mb-1 flex items-center">
                                            <svg class="w-3 h-3 mr-1 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>From</span>
                                        </p>
                                        <p class="text-xs font-semibold text-gray-900">
                                            {{ $voucher->valid_from ? $voucher->valid_from->format('d M Y') : '-' }}
                                        </p>
                                    </div>
                                    <div class="p-2.5 bg-gray-50 rounded-lg border border-gray-200">
                                        <p class="text-xs text-gray-600 mb-1 flex items-center">
                                            <svg class="w-3 h-3 mr-1 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>Until</span>
                                        </p>
                                        <p class="text-xs font-semibold text-gray-900">
                                            {{ $voucher->valid_until ? $voucher->valid_until->format('d M Y') : '-' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Usage Stats -->
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="text-xs text-gray-600">Used</p>
                                        <p class="text-xs font-bold text-gray-900">
                                            <span class="text-purple-600">{{ $voucher->used_count }}</span> / 
                                            <span>{{ $voucher->usage_limit ?: '∞' }}</span>
                                        </p>
                                    </div>
                                    @if($voucher->usage_limit)
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-purple-600 to-blue-600 h-2 rounded-full transition-all duration-300" 
                                                 style="width: {{ min(($voucher->used_count / $voucher->usage_limit) * 100, 100) }}%"></div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.vouchers.edit', $voucher) }}" 
                                       class="flex-1 inline-flex items-center justify-center px-3 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 text-sm font-medium">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.vouchers.destroy', $voucher) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this voucher?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($vouchers->hasPages())
                <div class="mt-6 pt-4 border-t border-gray-200">
                    {{ $vouchers->links() }}
                </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection