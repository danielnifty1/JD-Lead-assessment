<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Scripts -->
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
     
    @vite('resources/css/app.css')
@vite('resources/js/app.js')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">
                                <img src="https://res.cloudinary.com/dhryqsuf8/image/upload/v1750213978/yqu96gbwygwakjlynmea.png" alt="Logo" class="h-1 w-1" style="width: 100px; height: 100px;">
                            </a>
                        </div>
                        <!-- Desktop menu -->
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8 items-center justify-center">
                            <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Products</a>
                            @auth
                                <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Cart</a>
                                <a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Orders</a>
                            @endauth
                        </div>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        @auth
                            <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-gray-700 mr-4 relative">
                                <i class="fa fa-shopping-cart fa-lg"></i>
                                @if(auth()->user()->cartItems->count() > 0)
                                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ auth()->user()->cartItems->count() }}
                                    </span>
                                @endif
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Login</a>
                            <a href="{{ route('register') }}" class="ml-4 text-gray-500 hover:text-gray-700 text-sm font-medium">Register</a>
                        @endauth
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center sm:hidden">
                        <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <!-- Icon when menu is closed -->
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <!-- Icon when menu is open -->
                            <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="sm:hidden hidden transform transition-all duration-500 ease-in-out opacity-0 -translate-y-4" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-300">Products</a>
                    @auth
                        <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-300 relative">
                            <i class="fa fa-shopping-cart fa-lg"></i>
                            @if(auth()->user()->cartItems->count() > 0)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ auth()->user()->cartItems->count() }}
                                </span>
                            @endif
                            <span class="ml-2">Cart</span>
                        </a>
                        <a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-300">Orders</a>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-300">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-300">Login</a>
                        <a href="{{ route('register') }}" class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-300">Register</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white shadow-lg mt-8">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-500 text-sm">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
                </p>
            </div>
        </footer>
    </div>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const mobileMenu = document.querySelector('#mobile-menu');
            const menuIcons = mobileMenuButton.querySelectorAll('svg');

            mobileMenuButton.addEventListener('click', function() {
                // Toggle menu visibility
                mobileMenu.classList.toggle('hidden');
                
                // Toggle icons with a slight delay
                setTimeout(() => {
                    menuIcons.forEach(icon => icon.classList.toggle('hidden'));
                }, 150);
                
                // Add animation classes with a slight delay for opening
                if (!mobileMenu.classList.contains('hidden')) {
                    // Opening animation
                    setTimeout(() => {
                        mobileMenu.classList.remove('opacity-0', '-translate-y-4');
                        mobileMenu.classList.add('opacity-100', 'translate-y-0');
                    }, 50);
                } else {
                    // Closing animation
                    mobileMenu.classList.remove('opacity-100', 'translate-y-0');
                    mobileMenu.classList.add('opacity-0', '-translate-y-4');
                }
            });
        });
    </script>
</body>
</html> 