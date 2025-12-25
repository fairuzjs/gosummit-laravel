<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Reset Password') }} - {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #ffffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            margin: 0;
        }

        .reset-password-container {
            width: 100%;
            max-width: 800px; /* Lebih lebar untuk desktop */
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        /* Header Section with Icon */
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 32px 24px; /* Lebih kompak */
            text-align: center;
            color: #ffffff;
        }

        .icon-wrapper {
            width: 70px;
            height: 70px;
            margin: 0 auto 16px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .icon-wrapper svg {
            width: 35px;
            height: 35px;
            color: #ffffff;
        }

        .card-header h1 {
            font-size: 26px;
            font-weight: 700;
            margin: 0 0 8px 0;
        }

        .card-header p {
            font-size: 14px;
            margin: 0;
            opacity: 0.95;
            line-height: 1.5;
        }

        /* Form Section */
        .card-body {
            padding: 32px 24px; /* Lebih kompak */
        }

        .info-text {
            font-size: 13px;
            color: #718096;
            line-height: 1.6;
            margin: 0 0 24px 0;
            text-align: center;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 18px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px 12px 48px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            color: #2d3748;
            background: #f7fafc;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-input.error {
            border-color: #fc8181;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #718096;
            cursor: pointer;
            padding: 4px;
            font-size: 18px;
            line-height: 1;
            z-index: 10;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        .error-message {
            display: block;
            margin-top: 6px;
            font-size: 13px;
            color: #fc8181;
            font-weight: 500;
        }

        /* Password Strength Indicator */
        .password-strength {
            margin-top: 8px;
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .password-strength-bar.weak {
            width: 33%;
            background: #fc8181;
        }

        .password-strength-bar.medium {
            width: 66%;
            background: #f6ad55;
        }

        .password-strength-bar.strong {
            width: 100%;
            background: #48bb78;
        }

        .password-hint {
            font-size: 12px;
            color: #718096;
            margin-top: 6px;
        }

        /* Password Requirements */
        .password-requirements {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 16px;
            margin-top: 12px;
        }

        .password-requirements h4 {
            font-size: 13px;
            font-weight: 600;
            color: #2d3748;
            margin: 0 0 8px 0;
        }

        .requirement-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .requirement-item {
            font-size: 12px;
            color: #718096;
            padding: 4px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .requirement-item.met {
            color: #48bb78;
        }

        .requirement-icon {
            width: 16px;
            height: 16px;
            display: inline-flex;
        }

        /* Button */
        .btn-primary {
            width: 100%;
            padding: 14px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            margin-top: 20px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.5);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Back Link */
        .back-link-wrapper {
            margin-top: 20px;
            text-align: center;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #667eea;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .back-link:hover {
            color: #5a67d8;
            gap: 12px;
        }

        .back-link svg {
            width: 16px;
            height: 16px;
            transition: transform 0.2s ease;
        }

        .back-link:hover svg {
            transform: translateX(-4px);
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            top: 24px;
            right: 24px;
            background: #48bb78;
            color: #ffffff;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            font-size: 14px;
            font-weight: 600;
            z-index: 1000;
            animation: slideIn 0.3s ease;
            max-width: 400px;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Loading State */
        .btn-primary.loading {
            position: relative;
            color: transparent;
        }

        .btn-primary.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 3px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive Design for Mobile */
        @media (max-width: 640px) {
            body {
                padding: 0;
                background: #ffffff;
            }

            .reset-password-container {
                border-radius: 0;
                box-shadow: none;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .card-header {
                padding: 24px 20px;
            }

            .icon-wrapper {
                width: 60px;
                height: 60px;
            }

            .icon-wrapper svg {
                width: 30px;
                height: 30px;
            }

            .card-header h1 {
                font-size: 22px;
            }

            .card-header p {
                font-size: 13px;
            }

            .card-body {
                padding: 24px 20px;
                flex: 1;
            }

            .info-text {
                font-size: 12px;
                margin-bottom: 20px;
            }

            .btn-primary {
                padding: 12px 20px;
                font-size: 14px;
            }
        }

        /* Focus visible for accessibility */
        *:focus-visible {
            outline: 2px solid #667eea;
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div class="reset-password-container">
        <!-- Header with Icon -->
        <div class="card-header">
            <div class="icon-wrapper">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h1>Reset Password</h1>
            <p>Create a new secure password for your account</p>
        </div>

        <!-- Form Body -->
        <div class="card-body">
            <p class="info-text">
                Your new password must be different from previously used passwords and meet the security requirements below.
            </p>

            <form method="POST" action="{{ route('password.store') }}" id="resetPasswordForm">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </span>
                        <input 
                            type="email" 
                            id="email"
                            name="email" 
                            class="form-input @error('email') error @enderror" 
                            value="{{ old('email', $request->email) }}" 
                            required 
                            autofocus 
                            autocomplete="username"
                            placeholder="Enter your email"
                            aria-describedby="email-error"
                        />
                    </div>
                    @error('email')
                        <span class="error-message" id="email-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </span>
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            class="form-input @error('password') error @enderror" 
                            required 
                            autocomplete="new-password"
                            placeholder="Create a new password"
                            aria-describedby="password-error password-strength-description"
                        />
                        <button type="button" class="password-toggle" aria-label="Toggle password visibility">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="show-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="hide-icon" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message" id="password-error" role="alert">{{ $message }}</span>
                    @enderror
                    
                    <!-- Password Strength Indicator -->
                    <div class="password-strength" aria-hidden="true">
                        <div class="password-strength-bar" id="password-strength-bar"></div>
                    </div>
                    <div id="password-strength-description" class="password-hint" aria-live="polite">
                        Password strength will be displayed here
                    </div>

                    <!-- Password Requirements -->
                    <div class="password-requirements">
                        <h4>Password Requirements:</h4>
                        <ul class="requirement-list">
                            <li class="requirement-item" id="length-req">
                                <span class="requirement-icon">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </span>
                                At least 8 characters
                            </li>
                            <li class="requirement-item" id="uppercase-req">
                                <span class="requirement-icon">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </span>
                                Contains uppercase letter
                            </li>
                            <li class="requirement-item" id="lowercase-req">
                                <span class="requirement-icon">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </span>
                                Contains lowercase letter
                            </li>
                            <li class="requirement-item" id="number-req">
                                <span class="requirement-icon">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </span>
                                Contains number
                            </li>
                            <li class="requirement-item" id="special-req">
                                <span class="requirement-icon">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </span>
                                Contains special character
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </span>
                        <input 
                            type="password" 
                            id="password_confirmation"
                            name="password_confirmation" 
                            class="form-input" 
                            required 
                            autocomplete="new-password"
                            placeholder="Confirm your new password"
                            aria-describedby="password-confirmation-error"
                        />
                        <button type="button" class="password-toggle" aria-label="Toggle confirm password visibility">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="show-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="hide-icon" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    <span class="error-message" id="password-confirmation-error" role="alert" style="display: none;"></span>
                </div>

                <button type="submit" class="btn-primary" id="resetButton">
                    Reset Password
                </button>
            </form>

            <div class="back-link-wrapper">
                <a href="{{ route('login') }}" class="back-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Login
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password visibility toggle
            const passwordToggles = document.querySelectorAll('.password-toggle');
            passwordToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    const showIcon = this.querySelector('.show-icon');
                    const hideIcon = this.querySelector('.hide-icon');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        showIcon.style.display = 'none';
                        hideIcon.style.display = 'inline';
                    } else {
                        input.type = 'password';
                        showIcon.style.display = 'inline';
                        hideIcon.style.display = 'none';
                    }
                });
            });

            // Password strength validation
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthDesc = document.getElementById('password-strength-description');
            const resetButton = document.getElementById('resetButton');
            
            // Requirement elements
            const lengthReq = document.getElementById('length-req');
            const uppercaseReq = document.getElementById('uppercase-req');
            const lowercaseReq = document.getElementById('lowercase-req');
            const numberReq = document.getElementById('number-req');
            const specialReq = document.getElementById('special-req');

            function checkPasswordStrength() {
                const password = passwordInput.value;
                let strength = 0;
                let feedback = '';

                // Check length
                const lengthOk = password.length >= 8;
                updateRequirement(lengthReq, lengthOk);

                // Check for uppercase
                const uppercaseOk = /[A-Z]/.test(password);
                updateRequirement(uppercaseReq, uppercaseOk);

                // Check for lowercase
                const lowercaseOk = /[a-z]/.test(password);
                updateRequirement(lowercaseReq, lowercaseOk);

                // Check for number
                const numberOk = /\d/.test(password);
                updateRequirement(numberReq, numberOk);

                // Check for special character
                const specialOk = /[!@#$%^&*(),.?":{}|<>]/.test(password);
                updateRequirement(specialReq, specialOk);

                // Calculate strength
                const checks = [lengthOk, uppercaseOk, lowercaseOk, numberOk, specialOk];
                const passed = checks.filter(check => check).length;

                if (passed === 0) {
                    strength = 0;
                    feedback = 'Enter a password to see strength';
                } else if (passed <= 2) {
                    strength = 33;
                    feedback = 'Weak password';
                } else if (passed <= 3) {
                    strength = 66;
                    feedback = 'Medium password';
                } else {
                    strength = 100;
                    feedback = 'Strong password';
                }

                // Update strength bar
                strengthBar.className = 'password-strength-bar';
                if (strength > 0) {
                    strengthBar.classList.add(
                        strength <= 33 ? 'weak' : 
                        strength <= 66 ? 'medium' : 'strong'
                    );
                }
                
                strengthDesc.textContent = feedback;
            }

            function updateRequirement(element, isValid) {
                const icon = element.querySelector('.requirement-icon svg');
                if (isValid) {
                    element.classList.add('met');
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
                } else {
                    element.classList.remove('met');
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
                }
            }

            passwordInput.addEventListener('input', checkPasswordStrength);

            // Confirm password validation
            function validatePasswordConfirmation() {
                const errorElement = document.getElementById('password-confirmation-error');
                if (confirmPasswordInput.value !== '' && passwordInput.value !== confirmPasswordInput.value) {
                    errorElement.textContent = 'Passwords do not match';
                    errorElement.style.display = 'block';
                    return false;
                } else {
                    errorElement.style.display = 'none';
                    return true;
                }
            }

            confirmPasswordInput.addEventListener('input', validatePasswordConfirmation);

            // Form validation on submit
            const form = document.getElementById('resetPasswordForm');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const isPasswordValid = passwordInput.value.length >= 8 && 
                    /[A-Z]/.test(passwordInput.value) && 
                    /[a-z]/.test(passwordInput.value) && 
                    /\d/.test(passwordInput.value) && 
                    /[!@#$%^&*(),.?":{}|<>]/.test(passwordInput.value);
                
                const isConfirmed = passwordInput.value === confirmPasswordInput.value;
                
                if (!isPasswordValid || !isConfirmed) {
                    if (!isPasswordValid) {
                        alert('Please ensure your password meets all requirements.');
                    }
                    if (!isConfirmed) {
                        validatePasswordConfirmation();
                    }
                    return;
                }

                // Show loading state
                resetButton.classList.add('loading');
                resetButton.disabled = true;

                // Submit the form
                this.submit();
            });

            // Initialize password requirements display
            updateRequirement(lengthReq, false);
            updateRequirement(uppercaseReq, false);
            updateRequirement(lowercaseReq, false);
            updateRequirement(numberReq, false);
            updateRequirement(specialReq, false);
        });
    </script>
</body>
</html>