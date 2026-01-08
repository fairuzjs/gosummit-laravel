<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6" id="updatePasswordForm">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" oninput="checkPasswordStrength()" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            
            <!-- Password Strength Bar -->
            <div style="margin-top: 8px; height: 3px; background: #e2e8f0; border-radius: 2px; overflow: hidden;">
                <div id="strengthBar" style="height: 100%; width: 0; transition: all 0.3s; border-radius: 2px;"></div>
            </div>
            
            <!-- Password Requirements Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-top: 8px;">
                <div class="req-item" id="req-length" style="font-size: 11px; color: #718096; display: flex; align-items: center; gap: 6px;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink: 0;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    8+ characters
                </div>
                <div class="req-item" id="req-upper" style="font-size: 11px; color: #718096; display: flex; align-items: center; gap: 6px;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink: 0;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Uppercase
                </div>
                <div class="req-item" id="req-lower" style="font-size: 11px; color: #718096; display: flex; align-items: center; gap: 6px;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink: 0;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Lowercase
                </div>
                <div class="req-item" id="req-number" style="font-size: 11px; color: #718096; display: flex; align-items: center; gap: 6px;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink: 0;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Number
                </div>
            </div>
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
    
    <script>
        function checkPasswordStrength() {
            const password = document.getElementById('update_password_password').value;
            const strengthBar = document.getElementById('strengthBar');
            
            // Check requirements
            const hasLength = password.length >= 8;
            const hasUpper = /[A-Z]/.test(password);
            const hasLower = /[a-z]/.test(password);
            const hasNumber = /\d/.test(password);
            
            // Update requirement indicators
            updateReq('req-length', hasLength);
            updateReq('req-upper', hasUpper);
            updateReq('req-lower', hasLower);
            updateReq('req-number', hasNumber);
            
            // Calculate strength
            const checks = [hasLength, hasUpper, hasLower, hasNumber].filter(Boolean).length;
            
            strengthBar.style.width = '0';
            strengthBar.style.background = '';
            
            if (checks === 0) {
                strengthBar.style.width = '0';
            } else if (checks <= 2) {
                strengthBar.style.width = '33%';
                strengthBar.style.background = '#fc8181';
            } else if (checks === 3) {
                strengthBar.style.width = '66%';
                strengthBar.style.background = '#f6ad55';
            } else {
                strengthBar.style.width = '100%';
                strengthBar.style.background = '#48bb78';
            }
        }
        
        function updateReq(id, met) {
            const el = document.getElementById(id);
            if (!el) return;
            
            const svg = el.querySelector('svg path');
            if (met) {
                el.style.color = '#48bb78';
                svg.setAttribute('d', 'M5 13l4 4L19 7');
            } else {
                el.style.color = '#718096';
                svg.setAttribute('d', 'M6 18L18 6M6 6l12 12');
            }
        }
    </script>
</section>
