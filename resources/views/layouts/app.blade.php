<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Car Rental System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            /* Modern Color Palette */
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #8b5cf6;
            --secondary-color: #10b981;
            --secondary-dark: #059669;
            --accent-color: #f59e0b;
            --accent-light: #fbbf24;
            --danger-color: #ef4444;
            --danger-light: #f87171;
            --success-color: #10b981;
            --success-light: #34d399;
            --warning-color: #f59e0b;
            --warning-light: #fbbf24;
            --info-color: #06b6d4;
            --info-light: #22d3ee;
            
            /* Neutral Colors */
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            /* Dark Mode Colors */
            --dark-bg: #0f172a;
            --dark-surface: #1e293b;
            --dark-surface-hover: #334155;
            --dark-text: #f1f5f9;
            --dark-text-secondary: #cbd5e1;
            
            /* Gradients */
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-hero: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            --gradient-card: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            --gradient-dark: linear-gradient(145deg, #1e293b 0%, #334155 100%);
            
            /* Shadows */
            --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --shadow-glow: 0 0 20px rgba(99, 102, 241, 0.3);
            
            /* Border Radius */
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            --radius-full: 9999px;
            
            /* Spacing */
            --space-xs: 0.25rem;
            --space-sm: 0.5rem;
            --space-md: 1rem;
            --space-lg: 1.5rem;
            --space-xl: 2rem;
            --space-2xl: 3rem;
            --space-3xl: 4rem;
            
            /* Typography */
            --font-family-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-family-mono: 'JetBrains Mono', 'Fira Code', monospace;
            
            /* Transitions */
            --transition-fast: 150ms ease-in-out;
            --transition-normal: 250ms ease-in-out;
            --transition-slow: 350ms ease-in-out;
        }

        /* Import Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        
        * {
            box-sizing: border-box;
        }
        
        body {
            background: var(--gray-50);
            font-family: var(--font-family-sans);
            min-height: 100vh;
            color: var(--gray-800);
            line-height: 1.6;
            font-size: 16px;
            font-weight: 400;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            scroll-behavior: smooth;
        }
        
        /* Dark mode styles */
        body.dark-mode {
            background: var(--dark-bg);
            color: var(--dark-text);
        }
        
        body.dark-mode .navbar {
            background: var(--dark-surface) !important;
            border-bottom-color: var(--dark-surface-hover);
        }
        
        body.dark-mode .card {
            background: var(--dark-surface);
            border-color: var(--dark-surface-hover);
            color: var(--dark-text);
        }
        
        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background: var(--dark-surface);
            border-color: var(--dark-surface-hover);
            color: var(--dark-text);
        }
        
        body.dark-mode .form-control:focus,
        body.dark-mode .form-select:focus {
            background: var(--dark-surface);
            border-color: var(--primary-color);
            color: var(--dark-text);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--shadow-lg);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all var(--transition-normal);
        }
        
        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: var(--shadow-xl);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.75rem;
            color: var(--primary-color) !important;
            text-decoration: none;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transition: all var(--transition-normal);
        }

        .navbar-brand:hover {
            transform: scale(1.05);
            text-decoration: none;
        }

        .navbar-nav .nav-link {
            color: var(--gray-600) !important;
            font-weight: 500;
            padding: 0.75rem 1rem !important;
            border-radius: var(--radius-lg);
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
        }
        
        .navbar-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--gradient-primary);
            opacity: 0.1;
            transition: left var(--transition-normal);
            z-index: -1;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }
        
        .navbar-nav .nav-link:hover::before {
            left: 0;
        }
        
        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
            background: rgba(99, 102, 241, 0.1);
        }

        .card {
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            background: var(--gradient-card);
            transition: all var(--transition-normal);
            overflow: hidden;
            position: relative;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity var(--transition-normal);
        }

        .card:hover {
            box-shadow: var(--shadow-xl);
            transform: translateY(-8px);
            border-color: var(--primary-color);
        }
        
        .card:hover::before {
            opacity: 1;
        }

        .card-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            color: var(--gray-800);
            border-bottom: 1px solid var(--gray-200);
            padding: var(--space-lg) var(--space-xl);
            font-weight: 600;
            font-size: 1.125rem;
        }
        
        .card-body {
            padding: var(--space-xl);
        }
        
        .card-footer {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            border-top: 1px solid var(--gray-200);
            padding: var(--space-lg) var(--space-xl);
        }

        .sidebar {
            min-height: 100vh;
            background: var(--gradient-primary);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-soft);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 1rem 1.5rem;
            margin: 0.25rem 1rem;
            border-radius: 15px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }

        /* Modern Button Styles */
        .btn {
            border-radius: var(--radius-lg);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
            border: none;
            text-transform: none;
            letter-spacing: 0.025em;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left var(--transition-slow);
        }
        
        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-success {
            background: var(--gradient-success);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color), var(--danger-light));
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color), var(--warning-light));
            color: white;
            box-shadow: var(--shadow-md);
        }
        
        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
        }
        
        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1rem;
        }

        /* Modern Table Styles */
        .table {
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            background: white;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background: var(--gradient-primary);
            color: white;
            border: none;
            font-weight: 700;
            padding: 1.25rem 1.5rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            position: relative;
        }
        
        .table thead th:first-child {
            border-top-left-radius: var(--radius-xl);
        }
        
        .table thead th:last-child {
            border-top-right-radius: var(--radius-xl);
        }

        .table tbody tr {
            transition: all var(--transition-normal);
            border-bottom: 1px solid var(--gray-200);
        }
        
        .table tbody tr:last-child td:first-child {
            border-bottom-left-radius: var(--radius-xl);
        }
        
        .table tbody tr:last-child td:last-child {
            border-bottom-right-radius: var(--radius-xl);
        }

        .table tbody tr:hover {
            background: rgba(99, 102, 241, 0.05);
            transform: scale(1.01);
        }
        
        .table tbody td {
            padding: 1.25rem 1.5rem;
            border: none;
            vertical-align: middle;
            font-weight: 500;
        }
        
        .table-striped tbody tr:nth-of-type(odd) {
            background: rgba(99, 102, 241, 0.02);
        }
        
        .table-striped tbody tr:nth-of-type(odd):hover {
            background: rgba(99, 102, 241, 0.08);
        }

        /* Modern Badge Styles */
        .badge {
            border-radius: var(--radius-full);
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            box-shadow: var(--shadow-sm);
        }
        
        .bg-primary {
            background: var(--gradient-primary) !important;
        }
        
        .bg-success {
            background: var(--gradient-success) !important;
        }
        
        .bg-danger {
            background: linear-gradient(135deg, var(--danger-color), var(--danger-light)) !important;
        }
        
        .bg-warning {
            background: linear-gradient(135deg, var(--warning-color), var(--warning-light)) !important;
        }
        
        .bg-info {
            background: linear-gradient(135deg, var(--info-color), var(--info-light)) !important;
        }
        
        .bg-secondary {
            background: linear-gradient(135deg, var(--gray-500), var(--gray-600)) !important;
        }

        /* Modern Form Controls */
        .form-control, .form-select {
            border-radius: var(--radius-lg);
            border: 2px solid var(--gray-300);
            padding: 0.875rem 1.25rem;
            transition: all var(--transition-normal);
            background: white;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.15);
            background: white;
            outline: none;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }
        
        .form-text {
            color: var(--gray-500);
            font-size: 0.75rem;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.15);
        }

        /* Modern Alert Styles */
        .alert {
            border-radius: var(--radius-lg);
            border: 1px solid transparent;
            box-shadow: var(--shadow-md);
            padding: 1rem 1.5rem;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        
        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: currentColor;
            opacity: 0.3;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(52, 211, 153, 0.1));
            color: var(--success-color);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(248, 113, 113, 0.1));
            color: var(--danger-color);
            border-color: rgba(239, 68, 68, 0.2);
        }
        
        .alert-warning {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(251, 191, 36, 0.1));
            color: var(--warning-color);
            border-color: rgba(245, 158, 11, 0.2);
        }
        
        .alert-info {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(34, 211, 238, 0.1));
            color: var(--info-color);
            border-color: rgba(6, 182, 212, 0.2);
        }

        /* Modern Hero Section */
        .hero-section {
            background: var(--gradient-hero);
            color: white;
            padding: 4rem 0;
            position: relative;
            overflow: hidden;
            margin-bottom: 3rem;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .hero-section .container {
            position: relative;
            z-index: 2;
        }

        /* Modern Stats Cards */
        .stats-card {
            background: var(--gradient-card);
            border-radius: var(--radius-2xl);
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            transition: all var(--transition-normal);
            border-left: 5px solid var(--primary-color);
            position: relative;
            overflow: hidden;
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: var(--gradient-primary);
            opacity: 0.1;
            border-radius: 50%;
            transform: translate(30px, -30px);
        }

        .stats-card:hover {
            transform: translateY(-12px);
            box-shadow: var(--shadow-2xl);
        }

        .stats-number {
            font-size: 3rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
        }

        /* Modern Car Cards */
        .car-card {
            background: var(--gradient-card);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transition: all var(--transition-normal);
            border: 1px solid var(--gray-200);
            position: relative;
            height: 100%;
        }
        
        .car-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity var(--transition-normal);
        }

        .car-card:hover {
            box-shadow: var(--shadow-2xl);
            transform: translateY(-12px);
            border-color: var(--primary-color);
        }
        
        .car-card:hover::before {
            opacity: 1;
        }

        .car-image {
            height: 220px;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 4rem;
            position: relative;
            overflow: hidden;
        }
        
        .car-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.2"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
            opacity: 0.3;
        }

        .price-tag {
            background: var(--gradient-success);
            color: white;
            padding: 0.75rem 1.25rem;
            border-radius: var(--radius-lg);
            font-weight: 700;
            font-size: 1.125rem;
            box-shadow: var(--shadow-md);
            display: inline-block;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            
            .sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                width: 250px;
                z-index: 1000;
                transition: all 0.3s ease;
            }
            
            .sidebar.show {
                left: 0;
            }
        }

        .floating-action-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--gradient-primary);
            color: white;
            border: none;
            box-shadow: var(--shadow-medium);
            font-size: 1.5rem;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .floating-action-btn:hover {
            transform: scale(1.1);
            box-shadow: var(--shadow-strong);
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('cars.index') }}">
                <i class="fas fa-car me-2"></i>Car Rental System
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cars.index') }}">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    @auth
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-1"></i>Admin Panel
                                </a>
                            </li>
                        @elseif(Auth::user()->isSupplier())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('supplier.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-1"></i>Supplier Panel
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
                
                <ul class="navbar-nav">
                    <!-- Dark Mode Toggle -->
                    <li class="nav-item">
                        <button class="nav-link btn btn-link border-0 p-2" id="darkModeToggle" title="Toggle Dark Mode">
                            <i class="fas fa-moon"></i>
                        </button>
                    </li>
                    
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fas fa-user-circle me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.settings') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <main class="col-12">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    

    <script>
        // Modern JavaScript enhancements
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize dark mode
            initializeDarkMode();
            
            // Add navbar scroll effect
            initializeNavbarScroll();
            
            // Add loading states to buttons
            initializeButtonLoading();
            
            // Add enhanced card interactions
            initializeCardInteractions();
            
            // Auto-hide alerts with animation
            initializeAlertAnimations();
            
            // Add smooth scrolling
            initializeSmoothScrolling();
            
            // Add intersection observer for animations
            initializeScrollAnimations();
        });
        
        // Dark Mode Functionality
        function initializeDarkMode() {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const body = document.body;
            
            // Check for saved theme preference or default to light mode
            const currentTheme = localStorage.getItem('theme') || 'light';
            body.classList.toggle('dark-mode', currentTheme === 'dark');
            
            if (darkModeToggle) {
                darkModeToggle.addEventListener('click', function() {
                    body.classList.toggle('dark-mode');
                    const isDark = body.classList.contains('dark-mode');
                    localStorage.setItem('theme', isDark ? 'dark' : 'light');
                    
                    // Update toggle icon
                    const icon = this.querySelector('i');
                    icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
                });
            }
        }
        
        // Navbar Scroll Effect
        function initializeNavbarScroll() {
            const navbar = document.querySelector('.navbar');
            let lastScrollTop = 0;
            
            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop > 100) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
                
                lastScrollTop = scrollTop;
            });
        }
        
        // Enhanced Button Loading States
        function initializeButtonLoading() {
            const buttons = document.querySelectorAll('button[type="submit"], .btn');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    // Skip certain buttons
                    if (this.closest('form')) {
                        const form = this.closest('form');
                        if (form.action.includes('logout') || 
                            form.action.includes('register') || 
                            form.action.includes('cars') ||
                            form.action.includes('suppliers') ||
                            form.action.includes('bookings') ||
                            form.action.includes('update-status')) {
                            return;
                        }
                    }
                    
                    if (this.type === 'submit' && !this.disabled) {
                        const originalText = this.innerHTML;
                        this.innerHTML = '<span class="loading-spinner me-2"></span>Loading...';
                        this.disabled = true;
                        
                        // Re-enable after 3 seconds as fallback
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.disabled = false;
                        }, 3000);
                    }
                });
            });
        }
        
        // Enhanced Card Interactions
        function initializeCardInteractions() {
            const cards = document.querySelectorAll('.card, .car-card, .stats-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        }
        
        // Enhanced Alert Animations
        function initializeAlertAnimations() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                // Add entrance animation
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                
                setTimeout(() => {
                    alert.style.transition = 'all 0.3s ease';
                    alert.style.opacity = '1';
                    alert.style.transform = 'translateY(0)';
                }, 100);
                
                // Auto-hide after 5 seconds
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        }
        
        // Smooth Scrolling
        function initializeSmoothScrolling() {
            const links = document.querySelectorAll('a[href^="#"]');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        }
        
        // Scroll Animations
        function initializeScrollAnimations() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);
            
            // Observe elements for animation
            const animatedElements = document.querySelectorAll('.card, .car-card, .stats-card, .hero-section');
            animatedElements.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'all 0.6s ease';
                observer.observe(el);
            });
        }

        // Add toast notifications
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} position-fixed`;
            toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            toast.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            `;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Show success messages from Laravel
        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            showToast('{{ session('error') }}', 'danger');
        @endif
    </script>
    
    @yield('scripts')
</body>
</html>
