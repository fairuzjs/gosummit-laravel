{{-- resources/views/admin/vouchers/report.blade.php --}}
@extends('layouts.admin')

@section('title', 'Voucher Usage Report')

@section('header-title', 'Vouchers Report')

@section('header-buttons')
    <div class="flex items-center gap-3">
        {{-- Search Bar (Hidden di mobile, tampil di tablet+) --}}
        <div class="hidden md:flex items-center r   elative">
            <input type="text"
                   id="searchVoucher"
                   placeholder="Search vouchers..."
                   class="w-64 px-4 py-2 pr-10 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:outline-none transition-all">
            <svg class="w-5 h-5 text-gray-400 absolute right-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        {{-- Mobile Search Button --}}
        <button class="md:hidden inline-flex items-center px-3 py-2 bg-gray-200 text-gray-800 font-bold rounded-xl hover:bg-gray-300 transition-all duration-200"
                onclick="document.getElementById('mobileSearch').classList.toggle('hidden')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </button>

        {{-- Export Button --}}
        <button class="hidden sm:inline-flex items-center px-4 py-2.5 bg-gray-200 text-gray-800 font-bold rounded-xl hover:bg-gray-300 transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export
        </button>

        {{-- Mobile Export Button --}}
        <button class="sm:hidden inline-flex items-center px-3 py-2 bg-gray-200 text-gray-800 font-bold rounded-xl hover:bg-gray-300 transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </button>
    </div>

    {{-- Mobile Search Bar (Collapsible) --}}
    <div id="mobileSearch" class="hidden md:hidden absolute top-full left-0 right-0 mt-2 px-4 z-10">
        <div class="relative">
            <input type="text"
                   placeholder="Search vouchers..."
                   class="w-full px-4 py-2 pr-10 rounded-xl border-2 border-gray-200 bg-white shadow-lg focus:border-purple-500 focus:outline-none transition-all">
            <svg class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>
@endsection

@section('content')
    {{-- Back Button --}}
    <a href="{{ route('admin.vouchers.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-purple-600 transition-colors mb-3 group">
        <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Vouchers
    </a>
    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mb-6 sm:mb-8">
        {{-- Total Vouchers --}}
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-3 sm:mb-0">
                    <p class="text-gray-600 font-medium text-xs sm:text-sm mb-1">Total Vouchers</p>
                    <div class="flex items-center gap-2">
                        <p class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                            {{ $totalVouchers }}
                        </p>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full hidden sm:inline-flex items-center">
                            <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 11-2 0V9.414l-3.293 3.293a1 1 0 01-1.414 0L9 10.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0L11 9.586 13.586 7H12z" clip-rule="evenodd"></path>
                            </svg>
                            0%
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">vs last month</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl flex items-center justify-center self-end sm:self-auto">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Usage --}}
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-3 sm:mb-0">
                    <p class="text-gray-600 font-medium text-xs sm:text-sm mb-1">Total Usage</p>
                    <div class="flex items-center gap-2">
                        <p class="text-2xl sm:text-3xl font-bold text-green-600">
                            {{ $totalUsage }}
                        </p>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full hidden sm:inline-flex items-center">
                            <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 11-2 0V9.414l-3.293 3.293a1 1 0 01-1.414 0L9 10.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0L11 9.586 13.586 7H12z" clip-rule="evenodd"></path>
                            </svg>
                            0%
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">vs last month</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-green-500 rounded-xl flex items-center justify-center self-end sm:self-auto">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Discount Given --}}
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-3 sm:mb-0">
                    <p class="text-gray-600 font-medium text-xs sm:text-sm mb-1">Total Discount</p>
                    <div class="flex items-center gap-2">
                        <p class="text-lg sm:text-2xl font-bold text-blue-600">
                            Rp {{ number_format($totalDiscountGiven / 1000, 0) }}K
                        </p>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full hidden sm:inline-flex items-center">
                            <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 11-2 0V9.414l-3.293 3.293a1 1 0 01-1.414 0L9 10.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0L11 9.586 13.586 7H12z" clip-rule="evenodd"></path>
                            </svg>
                            5%
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">vs last month</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-blue-500 rounded-xl flex items-center justify-center self-end sm:self-auto">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Avg Redemption Rate --}}
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-3 sm:mb-0">
                    <p class="text-gray-600 font-medium text-xs sm:text-sm mb-1">Avg. Redemption</p>
                    <div class="flex items-center gap-2">
                        <p class="text-2xl sm:text-3xl font-bold text-amber-600">
                            {{ $totalVouchers > 0 ? number_format(($totalUsage / $totalVouchers) * 100, 0) : 0 }}%
                        </p>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full hidden sm:inline-flex items-center">
                            <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 11-2 0V9.414l-3.293 3.293a1 1 0 01-1.414 0L9 10.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0L11 9.586 13.586 7H12z" clip-rule="evenodd"></path>
                            </svg>
                            10%
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">vs last month</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl flex items-center justify-center self-end sm:self-auto">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Vouchers Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 sm:mb-8">
        {{-- Top 5 by Usage --}}
        <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
            <div class="p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 flex items-center">
                        Top 5 by Usage
                    </h3>
                    <a href="#all-vouchers" class="text-xs sm:text-sm text-purple-600 hover:text-purple-800 font-semibold">View All →</a>
                </div>

                {{-- Desktop Table --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-purple-50 to-blue-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Code</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">Times Used</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php $rank = 1; @endphp
                            @forelse($topVouchersByUsage as $voucher)
                                <tr class="hover:bg-gradient-to-r hover:from-purple-50 hover:to-blue-50 transition-all duration-200">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="text-lg mr-2">
                                                @if($rank == 1) 🥇
                                                @elseif($rank == 2) 🥈
                                                @elseif($rank == 3) 🥉
                                                @else <span class="text-gray-400 font-bold">{{ $rank }}</span>
                                                @endif
                                            </span>
                                            <span class="font-mono text-sm font-semibold text-gray-700">{{ $voucher->code }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm font-bold text-gray-900">{{ $voucher->name }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-medium text-gray-900">{{ $voucher->voucher_usages_count }}</span>
                                            <div class="flex-1 bg-gray-200 rounded-full h-2 max-w-[80px]">
                                                <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-2 rounded-full"
                                                     style="width: {{ $totalUsage > 0 ? ($voucher->voucher_usages_count / $totalUsage * 100) : 0 }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @php $rank++; @endphp
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <p class="text-sm font-medium">No usage data yet</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            @if($topVouchersByUsage->count() > 0 && $topVouchersByUsage->count() < 5)
                                @for($i = $topVouchersByUsage->count() + 1; $i <= 5; $i++)
                                    <tr class="opacity-40">
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span class="text-lg mr-2">
                                                    @if($i == 2) 🥈
                                                    @elseif($i == 3) 🥉
                                                    @else <span class="text-gray-400 font-bold">{{ $i }}</span>
                                                    @endif
                                                </span>
                                                <span class="text-sm text-gray-400">No data yet</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="h-2 bg-gray-200 rounded w-20"></div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="h-2 bg-gray-200 rounded w-16"></div>
                                        </td>
                                    </tr>
                                @endfor
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Card View --}}
                <div class="block md:hidden space-y-3">
                    @php $rank = 1; @endphp
                    @forelse($topVouchersByUsage as $voucher)
                        <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-2xl">
                                        @if($rank == 1) 🥇
                                        @elseif($rank == 2) 🥈
                                        @elseif($rank == 3) 🥉
                                        @else <span class="text-gray-500 font-bold text-lg">#{{ $rank }}</span>
                                        @endif
                                    </span>
                                    <div>
                                        <p class="font-mono text-sm font-semibold text-gray-700">{{ $voucher->code }}</p>
                                        <p class="text-xs text-gray-600">{{ $voucher->name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-purple-600">{{ $voucher->voucher_usages_count }}</p>
                                    <p class="text-xs text-gray-500">uses</p>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-2 rounded-full transition-all duration-500"
                                     style="width: {{ $totalUsage > 0 ? ($voucher->voucher_usages_count / $totalUsage * 100) : 0 }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 text-right">
                                {{ $totalUsage > 0 ? number_format(($voucher->voucher_usages_count / $totalUsage * 100), 1) : 0 }}% of total usage
                            </p>
                        </div>
                        @php $rank++; @endphp
                    @empty
                        <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                            <svg class="w-16 h-16 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="text-sm font-medium">No usage data yet</p>
                            <p class="text-xs mt-1">Start using vouchers to see rankings</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Top 5 by Discount --}}
        <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
            <div class="p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 flex items-center">
                        Top 5 by Discount
                    </h3>
                    <a href="#all-vouchers" class="text-xs sm:text-sm text-green-600 hover:text-green-800 font-semibold">View All →</a>
                </div>

                {{-- Desktop Table --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-green-50 to-teal-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Code</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Total Discount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php $rank = 1; @endphp
                            @forelse($topVouchersByDiscount as $usage)
                                <tr class="hover:bg-gradient-to-r hover:from-green-50 hover:to-teal-50 transition-all duration-200">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="text-lg mr-2">
                                                @if($rank == 1) 🥇
                                                @elseif($rank == 2) 🥈
                                                @elseif($rank == 3) 🥉
                                                @else <span class="text-gray-400 font-bold">{{ $rank }}</span>
                                                @endif
                                            </span>
                                            <span class="font-mono text-sm font-semibold text-gray-700">{{ $usage->voucher->code ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm font-bold text-gray-900">{{ $usage->voucher->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-medium text-gray-900">Rp {{ number_format($usage->total_discount, 0, ',', '.') }}</span>
                                            <div class="flex-1 bg-gray-200 rounded-full h-2 max-w-[80px]">
                                                <div class="bg-gradient-to-r from-green-500 to-teal-500 h-2 rounded-full"
                                                     style="width: {{ $totalDiscountGiven > 0 ? ($usage->total_discount / $totalDiscountGiven * 100) : 0 }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @php $rank++; @endphp
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <p class="text-sm font-medium">No discount data yet</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            @if($topVouchersByDiscount->count() > 0 && $topVouchersByDiscount->count() < 5)
                                @for($i = $topVouchersByDiscount->count() + 1; $i <= 5; $i++)
                                    <tr class="opacity-40">
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span class="text-lg mr-2">
                                                    @if($i == 2) 🥈
                                                    @elseif($i == 3) 🥉
                                                    @else <span class="text-gray-400 font-bold">{{ $i }}</span>
                                                    @endif
                                                </span>
                                                <span class="text-sm text-gray-400">No data yet</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="h-2 bg-gray-200 rounded w-20"></div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="h-2 bg-gray-200 rounded w-16"></div>
                                        </td>
                                    </tr>
                                @endfor
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Card View --}}
                <div class="block md:hidden space-y-3">
                    @php $rank = 1; @endphp
                    @forelse($topVouchersByDiscount as $usage)
                        <div class="bg-gradient-to-r from-green-50 to-teal-50 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-2xl">
                                        @if($rank == 1) 🥇
                                        @elseif($rank == 2) 🥈
                                        @elseif($rank == 3) 🥉
                                        @else <span class="text-gray-500 font-bold text-lg">#{{ $rank }}</span>
                                        @endif
                                    </span>
                                    <div>
                                        <p class="font-mono text-sm font-semibold text-gray-700">{{ $usage->voucher->code ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-600">{{ $usage->voucher->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-green-600">Rp {{ number_format($usage->total_discount / 1000, 0) }}K</p>
                                    <p class="text-xs text-gray-500">discount</p>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-green-500 to-teal-500 h-2 rounded-full transition-all duration-500"
                                     style="width: {{ $totalDiscountGiven > 0 ? ($usage->total_discount / $totalDiscountGiven * 100) : 0 }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 text-right">
                                {{ $totalDiscountGiven > 0 ? number_format(($usage->total_discount / $totalDiscountGiven * 100), 1) : 0 }}% of total discount
                            </p>
                        </div>
                        @php $rank++; @endphp
                    @empty
                        <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                            <svg class="w-16 h-16 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm font-medium">No discount data yet</p>
                            <p class="text-xs mt-1">Discounts will appear here when vouchers are used</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- All Vouchers List --}}
    <div id="all-vouchers" class="bg-white overflow-hidden shadow-xl rounded-2xl">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6">
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900">All Vouchers</h3>
                <div class="mt-2 sm:mt-0 flex items-center gap-2">
                    <span class="text-xs sm:text-sm text-gray-500">Total: {{ $vouchers->count() }} vouchers</span>
                    <select class="hidden sm:block text-xs border-2 border-gray-200 rounded-lg px-3 py-1.5 focus:outline-none focus:border-purple-500">
                        <option>All Types</option>
                        <option>Percentage</option>
                        <option>Fixed Amount</option>
                    </select>
                </div>
            </div>

            @if($vouchers->count() > 0)
                {{-- Mobile Card View --}}
                <div class="block lg:hidden space-y-4">
                    @foreach ($vouchers as $voucher)
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 shadow-md hover:shadow-lg transition-all duration-200">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-start flex-1 min-w-0">
                                    <div class="w-2 h-2 bg-purple-600 rounded-full mr-3 mt-2 flex-shrink-0"></div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <h4 class="font-mono text-sm font-bold text-gray-900">{{ $voucher->code }}</h4>
                                            @if($voucher->type == 'percentage')
                                                <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-blue-100 text-blue-700 border border-blue-200">
                                                    Percentage
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-green-100 text-green-700 border border-green-200">
                                                    Fixed
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-600 truncate">{{ $voucher->name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-3 mb-3 pt-3 border-t border-gray-200">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Value</p>
                                    <p class="text-sm font-bold text-blue-600">
                                        @if($voucher->type == 'percentage')
                                            {{ $voucher->value }}%
                                        @else
                                            Rp {{ number_format($voucher->value / 1000, 0) }}K
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Used</p>
                                    <p class="text-sm font-semibold text-gray-700">{{ $voucher->voucher_usages_count }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Limit</p>
                                    <p class="text-sm font-semibold text-gray-700">{{ $voucher->usage_limit ?: '∞' }}</p>
                                </div>
                            </div>
                            @if($voucher->usage_limit)
                                <div class="mb-3">
                                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                                        <span>Usage Progress</span>
                                        <span>{{ number_format(($voucher->voucher_usages_count / $voucher->usage_limit) * 100, 0) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        @php
                                            $percentage = ($voucher->voucher_usages_count / $voucher->usage_limit) * 100;
                                            $colorClass = $percentage < 30 ? 'from-red-400 to-red-500' :
                                                         ($percentage < 70 ? 'from-amber-400 to-amber-500' : 'from-green-400 to-green-500');
                                        @endphp
                                        <div class="bg-gradient-to-r {{ $colorClass }} h-2 rounded-full transition-all duration-500"
                                             style="width: {{ min($percentage, 100) }}%"></div>
                                    </div>
                                </div>
                            @endif
                            <div class="text-xs text-gray-500 space-y-1 pt-3 border-t border-gray-200">
                                <p>Per User Limit: <span class="font-semibold text-gray-700">{{ $voucher->user_usage_limit }}</span></p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Desktop Table View --}}
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Code</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Value</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Usage</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Limit</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($vouchers as $voucher)
                                <tr class="hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap align-middle">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 bg-purple-600 rounded-full mr-3"></div>
                                            <span class="font-mono text-sm font-semibold text-gray-900">{{ $voucher->code }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 align-middle">
                                        {{ $voucher->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap align-middle">
                                        @if($voucher->type == 'percentage')
                                            <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-700 border border-blue-200 shadow-sm">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                                                </svg>
                                                Percentage
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-full bg-green-100 text-green-700 border border-green-200 shadow-sm">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                                </svg>
                                                Fixed Amount
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600 align-middle">
                                        @if($voucher->type == 'percentage')
                                            {{ $voucher->value }}%
                                        @else
                                            Rp {{ number_format($voucher->value, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap align-middle">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-medium text-gray-900">{{ $voucher->voucher_usages_count }}</span>
                                            @if($voucher->usage_limit)
                                                <span class="text-xs text-gray-500">/ {{ $voucher->usage_limit }}</span>
                                                <div class="flex-1 max-w-[60px]">
                                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                        @php
                                                            $percentage = ($voucher->voucher_usages_count / $voucher->usage_limit) * 100;
                                                            $colorClass = $percentage < 30 ? 'bg-red-500' :
                                                                         ($percentage < 70 ? 'bg-amber-500' : 'bg-green-500');
                                                        @endphp
                                                        <div class="{{ $colorClass }} h-1.5 rounded-full transition-all duration-500"
                                                             style="width: {{ min($percentage, 100) }}%"></div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm align-middle">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-gray-900">{{ $voucher->usage_limit ?: '∞' }}</span>
                                            <span class="text-xs text-gray-500">per user: {{ $voucher->user_usage_limit }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No vouchers found</h3>
                    <p class="mt-2 text-sm text-gray-500">Get started by creating your first voucher.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.vouchers.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold rounded-xl hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Voucher
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Simple search functionality
    document.getElementById('searchVoucher')?.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Close mobile search when clicking outside
    document.addEventListener('click', function(e) {
        const mobileSearch = document.getElementById('mobileSearch');
        const searchButton = e.target.closest('button');
        if (mobileSearch && !mobileSearch.contains(e.target) && !searchButton) {
            mobileSearch.classList.add('hidden');
        }
    });
</script>
@endpush