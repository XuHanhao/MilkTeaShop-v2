<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Custom Color Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fff8f0',
                            100: '#ffeddb',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        },
                        secondary: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            300: '#fca5a5',
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                        },
                        accent: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                    },
                    boxShadow: {
                        'soft': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
                        'elevated': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                    },
                },
            }
        }
    </script>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-primary-600 hover:text-primary-700 transition-colors duration-200">
                            {{ config('app.name', 'Milk Tea Shop') }}
                        </a>
                    </div>
                    <div class="hidden sm:ml-10 sm:flex sm:space-x-8">
                        <a href="{{ route('home') }}" class="border-transparent text-gray-600 hover:border-primary-300 hover:text-primary-600 inline-flex items-center px-3 py-2 border-b-2 text-sm font-medium transition-all duration-200">
                            Home
                        </a>
                        <a href="{{ route('products.index') }}" class="border-transparent text-gray-600 hover:border-primary-300 hover:text-primary-600 inline-flex items-center px-3 py-2 border-b-2 text-sm font-medium transition-all duration-200">
                            Menu
                        </a>
                        @auth
                            <a href="{{ route('orders.index') }}" class="border-transparent text-gray-600 hover:border-primary-300 hover:text-primary-600 inline-flex items-center px-3 py-2 border-b-2 text-sm font-medium transition-all duration-200">
                                My Orders
                            </a>
                            <a href="{{ route('favorites.index') }}" class="border-transparent text-gray-600 hover:border-primary-300 hover:text-primary-600 inline-flex items-center px-3 py-2 border-b-2 text-sm font-medium transition-all duration-200">
                                Favorites
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="relative group">
                            <span class="text-gray-700 hover:text-primary-600 cursor-pointer transition-colors duration-200 flex items-center gap-1">
                                {{ auth()->user()->name }}
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-elevated py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors duration-200">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary-600 px-4 py-2 rounded-md text-sm font-medium transition-all duration-200">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-primary-500 text-white hover:bg-primary-600 hover:shadow-md px-5 py-2 rounded-md text-sm font-medium transition-all duration-200">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="sm:hidden" id="mobile-menu">
        <div class="bg-white border-t border-gray-200 px-4 py-5 space-y-1">
            <a href="{{ route('home') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-all duration-200">
                Home
            </a>
            <a href="{{ route('products.index') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-all duration-200">
                Menu
            </a>
            @auth
                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-all duration-200">
                    My Orders
                </a>
                <a href="{{ route('favorites.index') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-all duration-200">
                    Favorites
                </a>
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <span class="text-gray-700">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-600 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-all duration-200">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-all duration-200 text-center">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium bg-primary-500 text-white hover:bg-primary-600 rounded-lg transition-all duration-200 text-center">
                            Register
                        </a>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    <!-- Mobile Menu Script -->
    <script>
        const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                const expanded = mobileMenuButton.getAttribute('aria-expanded') === 'true' || false;
                mobileMenuButton.setAttribute('aria-expanded', !expanded);
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>

    <!-- Page Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-accent-50 border border-accent-200 text-accent-700 px-6 py-4 rounded-xl shadow-sm mb-6 flex items-start">
                <svg class="w-6 h-6 text-accent-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div class="bg-secondary-50 border border-secondary-200 text-secondary-700 px-6 py-4 rounded-xl shadow-sm mb-6 flex items-start">
                <svg class="w-6 h-6 text-secondary-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="block sm:inline font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-secondary-50 border border-secondary-200 text-secondary-700 px-6 py-4 rounded-xl shadow-sm mb-6">
                <div class="flex items-start mb-2">
                    <svg class="w-6 h-6 text-secondary-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="font-semibold">Form Validation Errors</h3>
                </div>
                <ul class="list-disc list-inside ml-9 space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-primary-700 hover:text-primary-800 transition-colors duration-200">
                        {{ config('app.name', 'Milk Tea Shop') }}
                    </a>
                    <p class="mt-4 text-gray-600 max-w-md">
                Providing you with the highest quality milk tea and service, making every sip full of happiness.
            </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-primary-700 mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-600 transition-colors duration-200">Home</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-gray-600 hover:text-primary-600 transition-colors duration-200">Menu</a></li>
                        @auth
                            <li><a href="{{ route('orders.index') }}" class="text-gray-600 hover:text-primary-600 transition-colors duration-200">My Orders</a></li>
                            <li><a href="{{ route('favorites.index') }}" class="text-gray-600 hover:text-primary-600 transition-colors duration-200">My Favorites</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-gray-600 hover:text-primary-600 transition-colors duration-200">Login</a></li>
                            <li><a href="{{ route('register') }}" class="text-gray-600 hover:text-primary-600 transition-colors duration-200">Register</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-primary-700 mb-4">Contact Us</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
123 Milk Tea Street, Chaoyang District, Beijing
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            010-12345678
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            info@milktea.com
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-200 pt-8">
                <p class="text-center text-gray-600 text-sm">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Milk Tea Shop') }}. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

