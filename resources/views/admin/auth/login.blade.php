<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Admin Login') }} - {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background Grid */
        body::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(99, 102, 241, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99, 102, 241, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
            pointer-events: none;
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* Floating Particles */
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(99, 102, 241, 0.5);
            border-radius: 50%;
            animation: float 15s infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) translateX(50px); opacity: 0; }
        }

        .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 30%; animation-delay: 2s; }
        .particle:nth-child(3) { left: 50%; animation-delay: 4s; }
        .particle:nth-child(4) { left: 70%; animation-delay: 6s; }
        .particle:nth-child(5) { left: 90%; animation-delay: 8s; }

        .login-container {
            width: 100%;
            max-width: 1000px;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 600px;
        }

        /* Left Side - Branding */
        .branding-side {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #6366f1 100%);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .branding-side::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            animation: brandingMove 30s linear infinite;
        }

        @keyframes brandingMove {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .brand-content {
            position: relative;
            z-index: 1;
        }

        .brand-logo {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            backdrop-filter: blur(10px);
            border: 3px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .brand-logo svg {
            width: 56px;
            height: 56px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .brand-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .brand-subtitle {
            font-size: 16px;
            opacity: 0.95;
            margin-bottom: 32px;
            font-weight: 500;
        }

        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .security-badge svg {
            width: 20px;
            height: 20px;
        }

        /* Right Side - Form */
        .form-side {
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
        }

        .form-header {
            margin-bottom: 32px;
        }

        .form-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .form-header p {
            font-size: 15px;
            color: #64748b;
        }

        /* Alert Box */
        .alert-box {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 13px;
            color: #92400e;
            line-height: 1.5;
        }

        .alert-box svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            color: #f59e0b;
            margin-top: 2px;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            color: #1e293b;
            background: #f8fafc;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #6366f1;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-input.error {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .password-toggle:hover {
            color: #6366f1;
            background: #f1f5f9;
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
        }

        .eye-closed {
            display: none;
        }

        .error-message {
            display: flex;
            align-items: center;
            margin-top: 8px;
            padding: 8px 12px;
            background: #fef2f2;
            border-left: 3px solid #ef4444;
            border-radius: 6px;
            font-size: 13px;
            color: #dc2626;
            font-weight: 500;
            animation: slideDown 0.3s ease;
        }

        .error-message::before {
            content: '⚠';
            margin-right: 8px;
            font-size: 14px;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Checkbox */
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin: 0 8px 0 0;
            cursor: pointer;
            accent-color: #6366f1;
        }

        .checkbox-group label {
            font-size: 14px;
            color: #475569;
            margin: 0;
            cursor: pointer;
        }

        /* Button */
        .btn-primary {
            width: 100%;
            padding: 14px 24px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.5);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Back Link */
        .back-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .back-link a {
            color: #6366f1;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .back-link a:hover {
            color: #4f46e5;
        }

        .back-link svg {
            width: 16px;
            height: 16px;
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
            to { transform: rotate(360deg); }
        }

        /* Toast */
        .toast {
            position: fixed;
            top: 24px;
            right: 24px;
            background: #10b981;
            color: #ffffff;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            font-size: 14px;
            font-weight: 600;
            z-index: 1000;
            animation: slideIn 0.3s ease;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 0;
            }

            .login-container {
                grid-template-columns: 1fr;
                border-radius: 0;
                min-height: 100vh;
                max-width: 100%;
            }

            .branding-side {
                padding: 40px 24px;
                min-height: auto;
            }

            .brand-logo {
                width: 80px;
                height: 80px;
            }

            .brand-logo svg {
                width: 44px;
                height: 44px;
            }

            .brand-title {
                font-size: 26px;
            }

            .brand-subtitle {
                font-size: 14px;
                margin-bottom: 24px;
            }

            .form-side {
                padding: 40px 24px;
            }

            .form-header h2 {
                font-size: 24px;
            }

            .form-header p {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .form-side {
                padding: 32px 20px;
            }

            .branding-side {
                padding: 32px 20px;
            }

            .btn-primary {
                padding: 12px 20px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Particles -->
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>

    <div class="login-container">
        <!-- Left Side - Branding -->
        <div class="branding-side">
            <div class="brand-content">
                <div class="brand-logo">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/>
                    </svg>
                </div>
                <h1 class="brand-title">GoSummit Admin</h1>
                <p class="brand-subtitle">{{ __('Secure Access to Admin Dashboard') }}</p>
                <div class="security-badge">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    {{ __('Secure Access') }}
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="form-side">
            <div class="form-header">
                <h2>{{ __('Admin Panel Login') }}</h2>
                <p>{{ __('Enter your credentials to access the admin dashboard') }}</p>
            </div>

            <!-- Security Notice -->
            <div class="alert-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>{{ __('This area is restricted to authorized personnel only') }}</span>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('admin.login') }}" id="loginForm">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input 
                        type="email" 
                        id="email"
                        name="email" 
                        class="form-input @error('email') error @enderror" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        autocomplete="username"
                        placeholder="{{ __('Enter your admin email') }}"
                    />
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            class="form-input @error('password') error @enderror" 
                            required 
                            autocomplete="current-password"
                            placeholder="{{ __('Enter your password') }}"
                        />
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <svg class="eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg class="eye-closed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">{{ __('Remember me') }}</label>
                </div>

                <button type="submit" class="btn-primary" id="submitBtn">
                    {{ __('Sign In to Admin Panel') }}
                </button>
            </form>
        </div>
    </div>

    @if(session('status'))
        <div class="toast">
            {{ session('status') }}
        </div>
    @endif

    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.querySelector('.password-toggle');
            const eyeOpen = toggleBtn.querySelector('.eye-open');
            const eyeClosed = toggleBtn.querySelector('.eye-closed');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                eyeOpen.style.display = 'block';
                eyeClosed.style.display = 'none';
            }
        }

        // Form Submit Loading State
        document.getElementById('loginForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });

        // Auto-hide toast after 5 seconds
        const toast = document.querySelector('.toast');
        if (toast) {
            setTimeout(() => {
                toast.style.animation = 'slideIn 0.3s ease reverse';
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }
    </script>
</body>
</html>
