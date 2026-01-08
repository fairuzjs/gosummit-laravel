<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Forgot Password') }} - {{ config('app.name', 'Laravel') }}</title>

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
            padding: 15px;
            margin: 0;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background Pattern */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
            animation: backgroundMove 20s linear infinite;
        }

        @keyframes backgroundMove {
            0% { background-position: 0 0; }
            100% { background-position: 60px 60px; }
        }

        .forgot-container {
            width: 100%;
            max-width: 480px;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header Section */
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 48px 40px;
            text-align: center;
            color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .icon-wrapper {
            width: 90px;
            height: 90px;
            margin: 0 auto 24px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 3px solid rgba(255, 255, 255, 0.3);
            position: relative;
            z-index: 1;
            animation: iconFloat 3s ease-in-out infinite;
        }

        @keyframes iconFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .icon-wrapper svg {
            width: 45px;
            height: 45px;
            color: #ffffff;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        .card-header h1 {
            font-size: 32px;
            font-weight: 700;
            margin: 0 0 12px 0;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .card-header p {
            font-size: 16px;
            margin: 0;
            opacity: 0.95;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        /* Form Section */
        .card-body {
            padding: 40px;
        }

        .info-box {
            background: linear-gradient(135deg, #f0f4ff 0%, #e8edff 100%);
            border-left: 4px solid #667eea;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 32px;
            display: flex;
            align-items: start;
            gap: 12px;
        }

        .info-box svg {
            width: 20px;
            height: 20px;
            color: #667eea;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .info-box p {
            font-size: 14px;
            color: #4a5568;
            line-height: 1.6;
            margin: 0;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 24px;
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
            z-index: 1;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            color: #2d3748;
            background: #f7fafc;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        .form-input.error {
            border-color: #fc8181;
            background: #fff5f5;
        }

        .error-message {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
            font-size: 13px;
            color: #e53e3e;
            font-weight: 500;
        }

        .error-message::before {
            content: '⚠';
            font-size: 14px;
        }

        /* Button */
        .btn-primary {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
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
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Loading State */
        .btn-primary.loading {
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
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Back Link */
        .back-link-wrapper {
            margin-top: 24px;
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
            transition: all 0.3s ease;
            padding: 8px 16px;
            border-radius: 8px;
        }

        .back-link:hover {
            background: rgba(102, 126, 234, 0.1);
            gap: 12px;
        }

        .back-link svg {
            width: 16px;
            height: 16px;
            transition: transform 0.3s ease;
        }

        .back-link:hover svg {
            transform: translateX(-4px);
        }

        /* Floating Toast Notification */
        .toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 9999;
            animation: slideInRight 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

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

        .toast {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: #ffffff;
            padding: 18px 24px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(72, 187, 120, 0.4);
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 320px;
            max-width: 450px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .toast-icon {
            width: 24px;
            height: 24px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .toast-icon svg {
            width: 14px;
            height: 14px;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-size: 15px;
            font-weight: 700;
            margin: 0 0 4px 0;
        }

        .toast-message {
            font-size: 13px;
            margin: 0;
            opacity: 0.95;
            line-height: 1.4;
        }

        .toast-close {
            background: none;
            border: none;
            color: #ffffff;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .toast-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .toast-close svg {
            width: 18px;
            height: 18px;
        }

        .toast-exit {
            animation: slideOutRight 0.3s ease-in forwards;
        }

        @keyframes slideOutRight {
            to {
                transform: translateX(450px);
                opacity: 0;
            }
        }

        /* Responsive Design */
        @media (max-width: 640px) {
            body {
                padding: 0;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .forgot-container {
                border-radius: 0;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .card-header {
                padding: 40px 24px;
            }

            .icon-wrapper {
                width: 75px;
                height: 75px;
            }

            .icon-wrapper svg {
                width: 38px;
                height: 38px;
            }

            .card-header h1 {
                font-size: 26px;
            }

            .card-header p {
                font-size: 14px;
            }

            .card-body {
                padding: 32px 24px;
                flex: 1;
            }

            .info-box {
                padding: 14px 16px;
                font-size: 13px;
            }

            .btn-primary {
                padding: 14px 20px;
                font-size: 15px;
            }

            .toast-container {
                top: 16px;
                right: 16px;
                left: 16px;
            }

            .toast {
                min-width: auto;
                max-width: none;
            }
        }

        @media (max-width: 480px) {
            .card-header {
                padding: 32px 20px;
            }

            .card-body {
                padding: 24px 20px;
            }

            .icon-wrapper {
                width: 65px;
                height: 65px;
                margin-bottom: 20px;
            }

            .icon-wrapper svg {
                width: 32px;
                height: 32px;
            }

            .card-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="forgot-container">
        <!-- Header with Animated Icon -->
        <div class="card-header">
            <div class="icon-wrapper">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
            </div>
            <h1>Forgot Password?</h1>
            <p>No worries, we'll send you reset instructions</p>
        </div>

        <!-- Form Body -->
        <div class="card-body">
            <div class="info-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p>Enter the email address associated with your account and we'll send you a link to reset your password.</p>
            </div>

            <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
                @csrf

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
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            autocomplete="username"
                            placeholder="your@email.com"
                            aria-describedby="email-error"
                        />
                    </div>
                    @error('email')
                        <span class="error-message" id="email-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-primary" id="submitBtn">
                    Send Reset Link
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

    @if(session('status'))
        <div class="toast-container" id="toastContainer">
            <div class="toast">
                <div class="toast-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="toast-content">
                    <p class="toast-title">Success!</p>
                    <p class="toast-message">{{ session('status') }}</p>
                </div>
                <button class="toast-close" onclick="closeToast()" aria-label="Close notification">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <script>
        // Form Submit Loading State
        document.getElementById('forgotPasswordForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });

        // Close toast function
        function closeToast() {
            const container = document.getElementById('toastContainer');
            if (container) {
                container.querySelector('.toast').classList.add('toast-exit');
                setTimeout(() => container.remove(), 300);
            }
        }

        // Auto-hide toast after 6 seconds
        const toastContainer = document.getElementById('toastContainer');
        if (toastContainer) {
            setTimeout(() => {
                closeToast();
            }, 6000);
        }

        // Re-enable button if there's an error
        window.addEventListener('pageshow', function() {
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn && submitBtn.classList.contains('loading')) {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>