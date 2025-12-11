<!-- resources/views/layouts/clean.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Ganti title dengan nilai hardcode atau gunakan e() -->
    <title>Semua Riwayat Booking - TiketGunung</title>
    <!-- Atau -->
    <!-- <title>{{ e(config('app.name', 'Laravel')) }} - Semua Riwayat Booking</title> -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Style Tambahan -->
    <style>
        .breadcrumb {
            background-color: #f9fafb;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }
        .breadcrumb a {
            color: #4f46e5;
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
        }
        .card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            margin-top: 1rem;
        }
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #6b7280;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-paid {
            background-color: #10b981;
            color: white;
        }
        .status-completed {
            background-color: #ef4444;
            color: white;
        }
        .status-pending {
            background-color: #f59e0b;
            color: white;
        }
        .action-btn {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .action-btn:hover {
            opacity: 0.9;
        }
        .btn-primary {
            background-color: #60a5fa;
            color: white;
        }
        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }
        .btn-success {
            background-color: #10b981;
            color: white;
        }
        .btn-danger {
            background-color: #ef4444;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Breadcrumbs -->
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="mx-2">→</span>
            <span>Semua Riwayat Booking</span>
        </nav>

        <!-- Page Title -->
        <h1 class="page-title">Semua Riwayat Booking</h1>

        <!-- Main Content -->
        <div class="card">
            @yield('content')
        </div>
    </div>
</body>
</html>