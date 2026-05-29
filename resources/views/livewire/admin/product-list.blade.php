<div>
    @if(session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('message') }}
            </div>
        </div>
    @endif

    <div class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-[#1e293b]">Liste des Produits</h1>
        <a href="{{ route('admin.products.create') }}" class="btn-primary flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nouveau Produit
        </a>
    </div>

    <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <input
            type="text"
            wire:model.live="search"
            placeholder="Rechercher..."
            class="px-4 py-2.5 border border-[#e2e8f0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f97316] focus:border-transparent transition-all"
        >

        <select wire:model.live="categoryFilter" class="px-4 py-2.5 border border-[#e2e8f0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f97316] focus:border-transparent transition-all bg-white">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <input
            type="number"
            wire:model.live="minPrice"
            placeholder="Prix min"
            class="px-4 py-2.5 border border-[#e2e8f0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f97316] focus:border-transparent transition-all"
        >

        <input
            type="number"
            wire:model.live="maxPrice"
            placeholder="Prix max"
            class="px-4 py-2.5 border border-[#e2e8f0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f97316] focus:border-transparent transition-all"
        >
    </div>

    <div class="mb-6">
        <select wire:model.live="stockFilter" class="px-4 py-2.5 border border-[#e2e8f0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f97316] focus:border-transparent transition-all bg-white">
            <option value="">Tous les stocks</option>
            <option value="in_stock">En stock</option>
            <option value="out_of_stock">Rupture de stock</option>
        </select>
    </div>

    <div class="card overflow-hidden">
        <table class="min-w-full divide-y divide-[#e2e8f0]">
            <thead class="bg-[#f8fafc]">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Image</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Marque</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Catégorie</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Prix</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Référence</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-[#e2e8f0]">
                @forelse($products as $product)
                    <tr class="hover:bg-[#f8fafc] transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-lg shadow-sm">
                            @else
                                <div class="w-12 h-12 bg-[#f1f5f9] rounded-lg flex items-center justify-center text-[#94a3b8]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-[#1e293b]">{{ $product->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-[#64748b]">{{ $product->brand }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#f97316]/10 text-[#f97316]">
                                {{ $product->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-[#1e293b]">{{ number_format($product->price, 0, ',', ' ') }} FCFA</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $product->stock_quantity > 10 ? 'bg-green-100 text-green-800' : ($product->stock_quantity > 0 ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800') }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-[#64748b] font-mono">{{ $product->sku }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-[#f97316] hover:text-[#ea580c] mr-4 font-medium transition-colors">Modifier</a>
                            <button
                                wire:click="deleteProduct({{ $product->id }})"
                                wire:confirm="Êtes-vous sûr de vouloir supprimer ce produit ?"
                                class="text-red-600 hover:text-red-800 font-medium transition-colors"
                            >
                                Supprimer
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-[#64748b]">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 mb-3 text-[#94a3b8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-sm font-medium">Aucun produit trouvé</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
