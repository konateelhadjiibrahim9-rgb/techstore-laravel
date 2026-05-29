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
        
        <style>
            :root {
                --color-primary: #1e293b;
                --color-secondary: #64748b;
                --color-accent: #f97316;
                --color-accent-hover: #ea580c;
                --color-bg: #f8fafc;
                --color-white: #ffffff;
                --color-text: #1e293b;
                --color-text-light: #64748b;
                --border-radius-sm: 0.375rem;
                --border-radius-md: 0.5rem;
                --border-radius-lg: 0.75rem;
                --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
                --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
                --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            }
            
            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--color-bg);
                color: var(--color-text);
            }
            
            .btn-primary {
                background-color: var(--color-accent);
                color: var(--color-white);
                border-radius: var(--border-radius-md);
                padding: 0.625rem 1.25rem;
                font-weight: 600;
                transition: all 0.2s ease;
            }
            
            .btn-primary:hover {
                background-color: var(--color-accent-hover);
                transform: translateY(-1px);
                box-shadow: var(--shadow-md);
            }
            
            .card {
                background-color: var(--color-white);
                border-radius: var(--border-radius-lg);
                box-shadow: var(--shadow-sm);
                border: 1px solid #e2e8f0;
                transition: all 0.3s ease;
            }
            
            .card:hover {
                box-shadow: var(--shadow-lg);
            }
            
            .nav-active {
                background-color: var(--color-accent) !important;
                color: var(--color-white) !important;
            }
        </style>
    </head>
    <body class="antialiased bg-gray-50">
        <div class="flex min-h-screen">
            <!-- Sidebar Fixe -->
            <aside class="fixed top-0 left-0 h-screen w-64 bg-[#1e293b] text-white z-50">
                <div class="p-6 border-b border-[#334155]">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-[#f97316] to-[#ea580c] rounded-lg flex items-center justify-center shadow-md">
                            <span class="text-white font-bold text-lg">TS</span>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold">TechStore</h1>
                            <p class="text-xs text-[#94a3b8]">Administration</p>
                        </div>
                    </div>
                </div>
                
                <nav class="mt-6 px-4">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg text-[#94a3b8] hover:bg-[#334155] hover:text-white transition-all duration-200 {{ request()->is('admin') ? 'nav-active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg text-[#94a3b8] hover:bg-[#334155] hover:text-white transition-all duration-200 {{ request()->is('admin/products*') ? 'nav-active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Produits
                    </a>

                    <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg text-[#94a3b8] hover:bg-[#334155] hover:text-white transition-all duration-200 {{ request()->is('admin/orders') ? 'nav-active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Commandes
                    </a>

                    <a href="{{ route('admin.deliveries.index') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg text-[#94a3b8] hover:bg-[#334155] hover:text-white transition-all duration-200 {{ request()->is('admin/deliveries') ? 'nav-active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Livraisons
                    </a>

                    <a href="{{ route('admin.quotes.index') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg text-[#94a3b8] hover:bg-[#334155] hover:text-white transition-all duration-200 {{ request()->is('admin/quotes') ? 'nav-active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Devis
                    </a>

                    @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('admin.admins.index') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg text-[#94a3b8] hover:bg-[#334155] hover:text-white transition-all duration-200 {{ request()->is('admin/admins*') ? 'nav-active' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            Gestion Admins
                        </a>
                    @endif
                </nav>

                <div class="absolute bottom-0 w-64 p-4 border-t border-[#334155]">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-4 py-3 text-[#94a3b8] hover:text-white hover:bg-[#334155] rounded-lg transition-all duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content Décalé -->
            <main class="flex-1 ml-64 overflow-y-auto">
                <!-- Header -->
                <header class="bg-white shadow-sm border-b border-[#e2e8f0] sticky top-0 z-40">
                    <div class="px-8 py-4 flex justify-between items-center">
                        <h2 class="text-2xl font-bold text-[#1e293b]">{{ $title ?? 'Administration' }}</h2>
                        <div class="flex items-center space-x-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-[#f97316] rounded-full flex items-center justify-center shadow-md">
                                    <span class="text-white font-bold text-sm">{{ substr(auth()->user()->name, 0, 2) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-[#1e293b]">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-[#64748b]">{{ auth()->user()->role }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Content -->
                <div class="p-8">
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
