<!-- Custom Confirmation Modal -->
<div x-data="confirmModal()" 
     x-show="show" 
     x-cloak
     style="display: none;"
     class="fixed inset-0 z-50 overflow-y-auto"
     @keydown.escape.window="cancel()"
     @keydown.enter.window="show && confirm()">
    
    <!-- Backdrop -->
    <div x-show="show"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-md"
         @click="cancel()">
    </div>

    <!-- Modal Container -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div x-show="show"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @click.stop
             class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-purple-600 to-blue-600 p-5 rounded-t-2xl">
                <div class="flex items-center justify-center">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Confirm Action</h3>
                <p class="text-gray-600 text-center mb-6" x-text="message"></p>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button @click="cancel()"
                            type="button"
                            class="flex-1 px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl transition-colors">
                        Cancel
                    </button>
                    <button @click="confirm()"
                            type="button"
                            class="flex-1 px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold rounded-xl transition-all shadow-md hover:shadow-lg">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmModal() {
    return {
        show: false,
        message: '',
        form: null,
        
        init() {
            // Listen for show-confirm event
            window.addEventListener('show-confirm', (e) => {
                this.message = e.detail.message;
                this.form = e.detail.form;
                this.show = true;
                document.body.style.overflow = 'hidden';
            });
        },
        
        confirm() {
            if (this.form) {
                this.form.submit();
            }
            this.cancel();
        },
        
        cancel() {
            this.show = false;
            document.body.style.overflow = '';
            this.form = null;
            this.message = '';
        }
    }
}

// Global helper function
function confirmAction(message, form) {
    window.dispatchEvent(new CustomEvent('show-confirm', {
        detail: { message, form }
    }));
    return false; // Prevent default form submission
}
</script>
