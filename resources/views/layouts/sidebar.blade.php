<<aside id="sidebar" class="fixed left-0 top-16 bottom-0 w-64 bg-white/95 backdrop-blur-md border-r border-gray-200 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-40">
    <div class="p-4">
        <!-- Profile Switcher -->
        <div class="flex space-x-2 mb-6">
            <button wire:click="switchProfile('individual')" class="flex-1 px-3 py-2 rounded-lg text-sm font-medium {{ $profile === 'individual' ? 'bg-blue-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                👤 Particulier
            </button>
            <button wire:click="switchProfile('enterprise')" class="flex-1 px-3 py-2 rounded-lg text-sm font-medium {{ $profile === 'enterprise' ? 'bg-blue-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                🏢 Entreprise
            </button>
        </div>

        <!-- Navigation -->
        <nav class="space-y-2">
            <a href="{{ route('dashboard.index', ['profile' => $profile]) }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.index') ? 'bg-orange-50 text-orange-700' : 'text-gray-700 hover:bg-gray-100' }} font-medium transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('dashboard.products', ['profile' => $profile]) }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.products') ? 'bg-orange-50 text-orange-700' : 'text-gray-700 hover:bg-gray-100' }} font-medium transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                Produits
            </a>

            <a href="{{ route('dashboard.my-orders') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.my-orders') ? 'bg-orange-50 text-orange-700' : 'text-gray-700 hover:bg-gray-100' }} font-medium transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Mes Commandes
            </a>

            <a href="{{ route('dashboard.my-invoices') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.my-invoices') ? 'bg-orange-50 text-orange-700' : 'text-gray-700 hover:bg-gray-100' }} font-medium transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                </svg>
                Mes Factures
            </a>
        </nav>
    </div>
</aside>

<!-- Overlay pour mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        if (mobileMenuBtn && sidebar && sidebarOverlay) {
            mobileMenuBtn.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
                sidebarOverlay.classList.toggle('hidden');
            });

            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            });
        }
    });
</script>
