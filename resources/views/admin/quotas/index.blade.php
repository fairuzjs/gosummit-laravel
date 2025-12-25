@extends('layouts.admin')

@section('title', 'Manage Quotas : ' . $mountain->name)
@section('header-title', 'Manage Quotas : ' . $mountain->name)

@section('content')
<!-- Form Set Quota -->
<div class="p-4 sm:p-6 lg:p-8 bg-white overflow-hidden shadow-xl sm:rounded-2xl">
    <h3 class="text-xl font-bold text-gray-900 mb-6">Set Quota for a Date Range</h3>
    <form action="{{ route('admin.mountains.quotas.store', $mountain) }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
            <div>
                <label for="start_date" class="block text-gray-700 font-semibold mb-2">Start Date</label>
                <input 
                    id="start_date" 
                    name="start_date" 
                    type="date" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    required
                >
            </div>
            <div>
                <label for="end_date" class="block text-gray-700 font-semibold mb-2">End Date</label>
                <input 
                    id="end_date" 
                    name="end_date" 
                    type="date" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    required
                >
            </div>
            <div>
                <label for="daily_quota" class="block text-gray-700 font-semibold mb-2">Daily Quota</label>
                <input 
                    id="daily_quota" 
                    name="daily_quota" 
                    type="number" 
                    min="0"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    required
                >
            </div>
        </div>
        <div class="pt-4 flex justify-end">
            <button 
                type="submit" 
                class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold rounded-xl hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200"
            >
                Set Quotas
            </button>
        </div>
    </form>
</div>

<!-- Existing Quotas -->
<div class="p-4 sm:p-6 lg:p-8 bg-white overflow-hidden shadow-xl sm:rounded-2xl mt-6">
    <h3 class="text-xl font-bold text-gray-900 mb-6">Existing Quotas (Next 3 Months)</h3>
    <div class="overflow-x-auto -mx-4 sm:mx-0 px-4 sm:px-0">
        <ul class="divide-y divide-gray-200">
            @forelse ($availableDates as $dateData)
                <li class="py-4 sm:py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center mb-2 sm:mb-0">
                        <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900">
                            {{ \Carbon\Carbon::parse($dateData['date'])->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                        </span>
                    </div>
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-sm">
                        {{ $dateData['quota'] }}
                    </span>
                </li>
            @empty
                <li class="py-8 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-500 text-lg font-medium mb-2">No quotas set.</p>
                        <p class="text-gray-400 text-sm">Use the form above to set quotas for upcoming dates.</p>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>
</div>
@endsection