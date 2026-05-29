<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admin - TechStore</title>

        <!-- Police Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 dark:bg-gray-900">
        <div class="flex min-h-screen">
            <!-- Sidebar Flowbite -->
            <aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
                <div class="h-full px-3 py-4 overflow-y-auto bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
                    <!-- Logo -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center pl-2.5 mb-5">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center shadow-md">
                            <span class="text-white font-bold text-lg">TS</span>
                        </div>
                        <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white ml-3">TechStore</span>
                    </a>
                
                    <!-- Navigation -->
                    <ul class="space-y-2 font-medium">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2.5 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->is('admin') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400' : '' }}">
                                <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="ml-3">Tableau de Bord</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.products.index') }}" class="flex items-center p-2.5 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->is('admin/products*') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400' : '' }}">
                                <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span class="ml-3">Produits</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.orders.index') }}" class="flex items-center p-2.5 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->is('admin/orders') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400' : '' }}">
                                <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                <span class="ml-3">Commandes</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.deliveries.index') }}" class="flex items-center p-2.5 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->is('admin/deliveries') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400' : '' }}">
                                <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="ml-3">Livraisons</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.quotes.index') }}" class="flex items-center p-2.5 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->is('admin/quotes') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400' : '' }}">
                                <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="ml-3">Devis</span>
                            </a>
                        </li>

                        @if(auth()->user()->isSuperAdmin())
                        <li>
                            <a href="{{ route('admin.admins.index') }}" class="flex items-center p-2.5 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->is('admin/admins*') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400' : '' }}">
                                <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span class="ml-3">Gestion Admins</span>
                            </a>
                        </li>
                        @endif
                    </ul>

                    <!-- Logout -->
                    <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full p-2.5 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span class="ml-3">Déconnexion</span>
                                </button>
                            </form>
                        </li>
                    </ul>

                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 ml-64 overflow-y-auto h-screen">
                <!-- Header -->
                <nav class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <div class="px-4 py-3">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title ?? 'Administration' }}</h2>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center shadow-md">
                                        <span class="text-white font-bold text-sm">{{ substr(auth()->user()->name, 0, 2) }}</span>
                                    </div>
                                    <div class="hidden md:block">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->role }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Content -->
                <div class="p-4 md:p-8">
                    @if(isset($slot))
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endif
                </div>
            </main>
        </div>
    </body>
</html>
