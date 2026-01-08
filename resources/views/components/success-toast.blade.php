{{-- Floating Success Notification --}}
@if(session('login_success') || session('register_success'))
<div id="successToast" 
     class="fixed top-6 right-6 z-50 transform translate-x-0 transition-all duration-500 ease-out"
     style="animation: slideInRight 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);">
    
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden max-w-md border-l-4 {{ session('login_success') ? 'border-blue-500' : 'border-green-500' }}">
        <div class="p-4 flex items-start gap-4">
            {{-- Icon --}}
            <div class="flex-shrink-0">
                @if(session('login_success'))
                    {{-- Login Icon (User Check) --}}
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                @else
                    {{-- Register Icon (Check Circle) --}}
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Content --}}
            <div class="flex-1 pt-0.5">
                <h4 class="text-sm font-bold text-gray-900 mb-1">
                    @if(session('login_success'))
                        Login Successful!
                    @else
                        Registration Successful!
                    @endif
                </h4>
                <p class="text-sm text-gray-600">
                    {{ session('login_success') ?? session('register_success') }}
                </p>
            </div>

            {{-- Close Button --}}
            <button onclick="closeToast()" 
                    class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Progress Bar --}}
        <div class="h-1 {{ session('login_success') ? 'bg-blue-500' : 'bg-green-500' }}" 
             id="progressBar"
             style="animation: shrink 5s linear forwards;"></div>
    </div>
</div>

<style>
    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        to {
            transform: translateX(450px);
            opacity: 0;
        }
    }

    @keyframes shrink {
        from {
            width: 100%;
        }
        to {
            width: 0%;
        }
    }

    .toast-exit {
        animation: slideOutRight 0.3s ease-in forwards;
    }
</style>

<script>
    // Auto close after 5 seconds
    setTimeout(() => {
        closeToast();
    }, 5000);

    function closeToast() {
        const toast = document.getElementById('successToast');
        if (toast) {
            toast.classList.add('toast-exit');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }
    }
</script>
@endif
