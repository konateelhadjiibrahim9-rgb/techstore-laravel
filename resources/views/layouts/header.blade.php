<header class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard.index', ['profile' => 'individual']) }}" class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">TS</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900">TechStore</span>
                </a>
            </div>

            <!-- Barre de recherche (Desktop) -->
            <div class="hidden md:flex flex-1 max-w-xl mx-8">
                <div class="relative">
                    <input type="text" 
                           placeholder="Rechercher PC, serveurs, composants..." 
                           class="w-full px-4 py-2 pl-10 rounded-full border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all">
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Navigation Desktop -->
            <nav class="hidden md:flex items-center space-x-6">
                <a href="{{ route('dashboard.products', ['profile' => 'individual']) }}" class="text-gray-700 hover:text-orange-600 font-medium transition-colors">
                    Produits
                </a>
                <a href="{{ route('dashboard.my-orders') }}" class="text-gray-700 hover:text-orange-600 font-medium transition-colors">
                    Mes Commandes
                </a>
                <button class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700 transition-colors shadow-md hover:shadow-lg">
                    Demander un Devis
                </button>
            </nav>

            <!-- Menu Burger Mobile -->
            <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>
</header>
