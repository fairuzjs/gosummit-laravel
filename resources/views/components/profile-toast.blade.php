{{-- Profile Success Notifications --}}
@if(session('profile_updated') || session('password_updated') || session('member_added') || session('member_deleted'))
<div id="profileToast" 
     class="fixed top-6 right-6 z-50 transform translate-x-0 transition-all duration-500 ease-out"
     style="animation: slideInRight 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);">
    
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden max-w-md border-l-4 
        @if(session('profile_updated')) border-blue-500
        @elseif(session('password_updated')) border-purple-500
        @elseif(session('member_added')) border-green-500
        @else border-red-500
        @endif">
        
        <div class="p-4 flex items-start gap-4">
            {{-- Icon --}}
            <div class="flex-shrink-0">
                @if(session('profile_updated'))
                    {{-- Profile Icon --}}
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                @elseif(session('password_updated'))
                    {{-- Password/Security Icon --}}
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                @elseif(session('member_added'))
                    {{-- Add Member Icon --}}
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                @else
                    {{-- Delete Member Icon --}}
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"></path>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Content --}}
            <div class="flex-1 pt-0.5">
                <h4 class="text-sm font-bold text-gray-900 mb-1">
                    @if(session('profile_updated'))
                        Profile Updated!
                    @elseif(session('password_updated'))
                        Password Changed!
                    @elseif(session('member_added'))
                        Member Added!
                    @else
                        Member Deleted!
                    @endif
                </h4>
                <p class="text-sm text-gray-600">
                    {{ session('profile_updated') ?? session('password_updated') ?? session('member_added') ?? session('member_deleted') }}
                </p>
            </div>

            {{-- Close Button --}}
            <button onclick="closeProfileToast()" 
                    class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Progress Bar --}}
        <div class="h-1 
            @if(session('profile_updated')) bg-blue-500
            @elseif(session('password_updated')) bg-purple-500
            @elseif(session('member_added')) bg-green-500
            @else bg-red-500
            @endif" 
             id="profileProgressBar"
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
        closeProfileToast();
    }, 5000);

    function closeProfileToast() {
        const toast = document.getElementById('profileToast');
        if (toast) {
            toast.classList.add('toast-exit');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }
    }
</script>
@endif
