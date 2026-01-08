<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f7fafc;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .email-header {
            background: #000000;
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
            border-bottom: 3px solid #333333;
        }

        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* Body */
        .email-body {
            padding: 40px 30px;
        }

        .email-body h2 {
            color: #2d3748;
            font-size: 20px;
            margin: 0 0 20px 0;
        }

        .email-body p {
            color: #4a5568;
            font-size: 15px;
            margin: 0 0 16px 0;
        }

        /* Button */
        .button-wrapper {
            text-align: center;
            margin: 32px 0;
        }

        .button {
            display: inline-block;
            padding: 16px 32px;
            background: #000000;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 16px;
            border: 2px solid #000000;
            transition: all 0.3s ease;
        }

        .button:hover {
            background: #ffffff;
            color: #000000 !important;
            border: 2px solid #000000;
        }

        /* Info Box */
        .info-box {
            background: #f7fafc;
            border-left: 4px solid #000000;
            padding: 16px 20px;
            border-radius: 8px;
            margin: 24px 0;
        }

        .info-box p {
            margin: 0;
            font-size: 14px;
            color: #000000ff;
        }

        /* Subcopy */
        .subcopy {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .subcopy p {
            font-size: 13px;
            color: #718096;
        }

        .subcopy a {
            color: #000000;
            word-break: break-all;
            text-decoration: underline;
        }

        /* Footer */
        .email-footer {
            background: #f7fafc;
            padding: 24px 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .email-footer p {
            margin: 8px 0;
            font-size: 13px;
            color: #718096;
        }

        .email-footer a {
            color: #000000;
            text-decoration: none;
            font-weight: 600;
        }

        .email-footer a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .email-wrapper {
                margin: 0;
                border-radius: 0;
            }

            .email-header {
                padding: 32px 24px;
            }

            .email-header h1 {
                font-size: 24px;
            }

            .email-body {
                padding: 32px 24px;
            }

            .button {
                padding: 14px 28px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="email-header">
            <h1>{{ config('app.name') }}</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            {{-- Greeting --}}
            @if (! empty($greeting))
                <h2>{{ $greeting }}</h2>
            @else
                @if ($level === 'error')
                    <h2>Whoops!</h2>
                @else
                    <h2>Hello!</h2>
                @endif
            @endif

            {{-- Intro Lines --}}
            @foreach ($introLines as $line)
                <p>{{ $line }}</p>
            @endforeach

            {{-- Action Button --}}
            @isset($actionText)
                <div class="button-wrapper">
                    <a href="{{ $actionUrl }}" class="button">{{ $actionText }}</a>
                </div>
            @endisset

            {{-- Outro Lines --}}
            @foreach ($outroLines as $line)
                <p>{{ $line }}</p>
            @endforeach

            {{-- Salutation --}}
            @if (! empty($salutation))
                <p>{{ $salutation }}</p>
            @else
                <p>
                    Regards,<br>
                    <strong>{{ config('app.name') }}</strong>
                </p>
            @endif

            {{-- Subcopy --}}
            @isset($actionText)
                <div class="subcopy">
                    <p>
                        If you're having trouble clicking the "{{ $actionText }}" button, 
                        copy and paste the URL below into your web browser:
                    </p>
                    <p><a href="{{ $actionUrl }}">{{ $actionUrl }}</a></p>
                </div>
            @endisset
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            @if (config('app.url'))
                <p><a href="{{ config('app.url') }}">Visit our website</a></p>
            @endif
        </div>
    </div>
</body>
</html>
