@props(['booking'])

<div class="bg-gradient-to-br from-white to-gray-50 overflow-hidden shadow-2xl rounded-2xl border border-gray-100">
    <!-- Header dengan Gradient & Mountain Image Overlay -->
    <div class="relative bg-gradient-to-br from-purple-600 via-indigo-600 to-blue-600 px-6 py-8 overflow-hidden">
        <!-- Decorative Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="mountains" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                        <path d="M0 100 L25 60 L50 80 L75 40 L100 70 L100 100 Z" fill="white" opacity="0.3"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#mountains)"/>
            </svg>
        </div>

        <!-- Header Content -->
        <div class="relative">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Pendakian Berikutnya
                </h3>
                <span class="bg-white bg-opacity-20 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1 rounded-full">
                    Upcoming
                </span>
            </div>

            <!-- Mountain Name & Date -->
            <div class="text-center space-y-3">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-2 drop-shadow-lg">
                        {{ $booking->mountain->name }}
                    </h2>
                    <div class="flex items-center justify-center text-purple-100">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-base font-medium">
                            {{ \Carbon\Carbon::parse($booking->check_in_date)->format('l, d F Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Countdown Timer -->
    <div class="p-6 bg-gradient-to-b from-gray-50 to-white">
        <div x-data="countdown('{{ $booking->check_in_date }}')" x-init="start()">
            <div class="grid grid-cols-4 gap-3 md:gap-4">
                <!-- Days -->
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-3 md:p-4 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1 flex flex-col items-center justify-center min-h-[80px]">
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl md:text-4xl font-bold bg-gradient-to-br from-purple-600 to-blue-600 bg-clip-text text-transparent mb-1" x-text="days">
                            00
                        </div>
                        <div class="text-xs md:text-sm font-semibold text-gray-500 uppercase tracking-wide">
                            Hari
                        </div>
                    </div>
                </div>

                <!-- Hours -->
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-3 md:p-4 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1 flex flex-col items-center justify-center min-h-[80px]">
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl md:text-4xl font-bold bg-gradient-to-br from-purple-600 to-blue-600 bg-clip-text text-transparent mb-1" x-text="hours">
                            00
                        </div>
                        <div class="text-xs md:text-sm font-semibold text-gray-500 uppercase tracking-wide">
                            Jam
                        </div>
                    </div>
                </div>

                <!-- Minutes -->
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-3 md:p-4 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1 flex flex-col items-center justify-center min-h-[80px]">
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl md:text-4xl font-bold bg-gradient-to-br from-purple-600 to-blue-600 bg-clip-text text-transparent mb-1" x-text="minutes">
                            00
                        </div>
                        <div class="text-xs md:text-sm font-semibold text-gray-500 uppercase tracking-wide">
                            Menit
                        </div>
                    </div>
                </div>

                <!-- Seconds -->
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-3 md:p-4 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1 flex flex-col items-center justify-center min-h-[80px]">
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl md:text-4xl font-bold bg-gradient-to-br from-purple-600 to-blue-600 bg-clip-text text-transparent mb-1" x-text="seconds">
                            00
                        </div>
                        <div class="text-xs md:text-sm font-semibold text-gray-500 uppercase tracking-wide">
                            Detik
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Info -->
        <div class="mt-6 grid grid-cols-2 gap-3">
            <div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-lg p-3 border border-purple-100">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Peserta</p>
                        <p class="text-sm font-bold text-gray-800">{{ $booking->number_of_people ?? 1 }} Orang</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-3 border border-green-100">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Status</p>
                        <p class="text-sm font-bold text-green-700">
                            @if($booking->status === 'checked_in')
                                Confirmed
                            @elseif($booking->status === 'confirmed')
                                Confirmed
                            @elseif($booking->status === 'pending')
                                Pending
                            @elseif($booking->status === 'cancelled')
                                Cancelled
                            @else
                                {{ ucfirst($booking->status) }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Button -->
        <div class="mt-4 flex items-center justify-center px-4 py-3 text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-purple-600 to-indigo-600 shadow-lg cursor-default">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Siap untuk Pendakian
        </div>
    </div>
</div>

<script>
    function countdown(targetDate) {
        return {
            days: '00',
            hours: '00',
            minutes: '00',
            seconds: '00',
            target: new Date(targetDate).getTime(),

            start() {
                const update = () => {
                    const now = new Date().getTime();
                    const distance = this.target - now;

                    if (distance < 0) {
                        this.days = '00';
                        this.hours = '00';
                        this.minutes = '00';
                        this.seconds = '00';
                        return;
                    }

                    this.days = Math.floor(distance / (1000 * 60 * 60 * 24)).toString().padStart(2, '0');
                    this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
                    this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
                    this.seconds = Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0');
                }

                update();
                setInterval(update, 1000);
            }
        }
    }
</script>