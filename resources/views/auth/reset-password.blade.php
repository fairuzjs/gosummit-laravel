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
            padding: 20px;
            margin: 0;
        }

        .reset-container {
            width: 100%;
            max-width: 900px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            min-height: 550px;
        }

        /* Left Side - Info Panel */
        .info-panel {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .info-panel .icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            backdrop-filter: blur(10px);
        }

        .info-panel .icon svg {
            width: 40px;
            height: 40px;
        }

        .info-panel h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 12px 0;
            line-height: 1.2;
        }

        .info-panel p {
            font-size: 14px;
            line-height: 1.6;
            opacity: 0.95;
            margin: 0 0 24px 0;
        }

        .info-panel .features {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-panel .features li {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            font-size: 13px;
        }

        .info-panel .features li svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        /* Right Side - Form Panel */
        .form-panel {
            padding: 40px 35px;
            display: flex;
            flex-direction: column;
        }

        .form-panel h2 {
            font-size: 22px;
            font-weight: 700;
            color: #1a202c;
            margin: 0 0 8px 0;
        }

        .form-panel .subtitle {
            font-size: 13px;
            color: #718096;
            margin: 0 0 24px 0;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 6px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
        }

        .form-input {
            width: 100%;
            padding: 11px 14px 11px 42px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            color: #2d3748;
            background: #f7fafc;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #718096;
            cursor: pointer;
            padding: 4px;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        /* Password Requirements - Compact */
        .requirements-compact {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            margin-top: 8px;
        }

        .req-item {
            font-size: 11px;
            color: #718096;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .req-item.met {
            color: #48bb78;
        }

        .req-item svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }

        /* Password Strength */
        .strength-bar {
            height: 3px;
            background: #e2e8f0;
            border-radius: 2px;
            margin-top: 6px;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0;
            transition: all 0.3s;
            border-radius: 2px;
        }

        .strength-fill.weak { width: 33%; background: #fc8181; }
        .strength-fill.medium { width: 66%; background: #f6ad55; }
        .strength-fill.strong { width: 100%; background: #48bb78; }

        /* Button */
        .btn-submit {
            width: 100%;
            padding: 13px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            margin-top: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #667eea;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            margin-top: 16px;
            transition: gap 0.2s;
        }

        .back-link:hover {
            gap: 10px;
        }

        .back-link svg {
            width: 14px;
            height: 14px;
        }

        .error-message {
            display: block;
            margin-top: 4px;
            font-size: 12px;
            color: #fc8181;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 0;
                background: #ffffff;
            }

            .reset-container {
                grid-template-columns: 1fr;
                border-radius: 0;
                min-height: 100vh;
            }

            .info-panel {
                padding: 30px 24px;
            }

            .info-panel h1 {
                font-size: 24px;
            }

            .info-panel .features {
                display: none;
            }

            .form-panel {
                padding: 30px 24px;
            }
        }

        /* Loading state */
        .btn-submit.loading {
            position: relative;
            color: transparent;
        }

        .btn-submit.loading::after {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            top: 50%;
            left: 50%;
            margin: -9px 0 0 -9px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <!-- Left Panel - Info -->
        <div class="info-panel">
            <div class="icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h1>Reset Your Password</h1>
            <p>Create a new secure password for your account. Make sure it's strong and unique.</p>
            
            <ul class="features">
                <li>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Secure encryption
                </li>
                <li>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Password strength validation
                </li>
                <li>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Instant password reset
                </li>
            </ul>
        </div>

        <!-- Right Panel - Form -->
        <div class="form-panel">
            <h2>Create New Password</h2>
            <p class="subtitle">Enter your email and new password below</p>

            <form method="POST" action="{{ route('password.store') }}" id="resetForm">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </span>
                        <input 
                            type="email" 
                            name="email" 
                            class="form-input" 
                            value="{{ old('email', $request->email) }}" 
                            required 
                            autofocus
                            placeholder="your@email.com"
                        />
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="form-group">
                    <label class="form-label">New Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </span>
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            class="form-input" 
                            required
                            placeholder="Enter new password"
                        />
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="eye-open">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    
                    <!-- Strength Bar -->
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthBar"></div>
                    </div>

                    <!-- Requirements Compact -->
                    <div class="requirements-compact">
                        <div class="req-item" id="req-length">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            8+ characters
                        </div>
                        <div class="req-item" id="req-upper">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Uppercase
                        </div>
                        <div class="req-item" id="req-lower">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Lowercase
                        </div>
                        <div class="req-item" id="req-number">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Number
                        </div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </span>
                        <input 
                            type="password" 
                            id="password_confirmation"
                            name="password_confirmation" 
                            class="form-input" 
                            required
                            placeholder="Confirm new password"
                        />
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="eye-open">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">
                    Reset Password
                </button>

                <a href="{{ route('login') }}" class="back-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Login
                </a>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('strengthBar');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            
            // Check requirements
            const hasLength = password.length >= 8;
            const hasUpper = /[A-Z]/.test(password);
            const hasLower = /[a-z]/.test(password);
            const hasNumber = /\d/.test(password);
            
            updateReq('req-length', hasLength);
            updateReq('req-upper', hasUpper);
            updateReq('req-lower', hasLower);
            updateReq('req-number', hasNumber);
            
            // Calculate strength
            const checks = [hasLength, hasUpper, hasLower, hasNumber].filter(Boolean).length;
            strengthBar.className = 'strength-fill';
            if (checks <= 2) strengthBar.classList.add('weak');
            else if (checks === 3) strengthBar.classList.add('medium');
            else if (checks === 4) strengthBar.classList.add('strong');
        });

        function updateReq(id, met) {
            const el = document.getElementById(id);
            const svg = el.querySelector('svg');
            if (met) {
                el.classList.add('met');
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
            } else {
                el.classList.remove('met');
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
            }
        }

        document.getElementById('resetForm').addEventListener('submit', function() {
            document.getElementById('submitBtn').classList.add('loading');
            document.getElementById('submitBtn').disabled = true;
        });
    </script>
</body>
</html>