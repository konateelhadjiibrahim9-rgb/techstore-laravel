<x-techstore-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-[#1e293b] mb-2">
                        Bienvenue, {{ auth()->user()->name }} !
                    </h3>
                    <p class="text-[#64748b]">
                        Gérez vos commandes et votre profil depuis votre espace client.
                    </p>
                </div>
            </div>

            <!-- Profile Switcher -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex space-x-4">
                        <a href="{{ route('dashboard.index', ['profile' => 'individual']) }}" 
                           class="px-4 py-2 rounded-lg {{ $profile === 'individual' ? 'bg-[#f97316] text-white' : 'bg-[#f8fafc] text-[#64748b] hover:bg-[#e2e8f0]' }} transition-colors">
                            Particulier
                        </a>
                        <a href="{{ route('dashboard.index', ['profile' => 'enterprise']) }}" 
                           class="px-4 py-2 rounded-lg {{ $profile === 'enterprise' ? 'bg-[#f97316] text-white' : 'bg-[#f8fafc] text-[#64748b] hover:bg-[#e2e8f0]' }} transition-colors">
                            Entreprise
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-[#64748b]">Catégories</p>
                            <p class="text-2xl font-bold text-[#1e293b]">{{ $stats['productCategories'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-[#64748b]">Devis</p>
                            <p class="text-2xl font-bold text-[#1e293b]">{{ $stats['quotes'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-[#64748b]">Devis en attente</p>
                            <p class="text-2xl font-bold text-[#1e293b]">{{ $stats['pending_quotes'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Categories -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-[#1e293b] mb-4">Catégories de produits</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($productCategories as $category)
                            <a href="{{ route('dashboard.products', ['profile' => $profile, 'category' => $category->category]) }}" 
                               class="p-4 border border-[#e2e8f0] rounded-lg hover:border-[#f97316] hover:shadow-md transition-all">
                                <h4 class="font-medium text-[#1e293b]">{{ $category->category }}</h4>
                                <p class="text-sm text-[#64748b]">{{ $category->description }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Quotes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-[#1e293b] mb-4">Devis récents</h3>
                    @if($recentQuotes->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentQuotes as $quote)
                                <div class="flex items-center justify-between p-4 bg-[#f8fafc] rounded-lg">
                                    <div>
                                        <p class="font-medium text-[#1e293b]">{{ $quote->reference }}</p>
                                        <p class="text-sm text-[#64748b]">{{ $quote->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                        {{ $quote->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           $quote->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                           $quote->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                                           'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($quote->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-[#64748b]">Aucun devis récent</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-techstore-layout>
