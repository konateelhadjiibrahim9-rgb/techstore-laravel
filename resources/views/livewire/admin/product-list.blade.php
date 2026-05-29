<div class="p-4 md:p-8">
    @if(session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-400 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('message') }}
            </div>
        </div>
    @endif

    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Liste des Produits</h1>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-primary-500 rounded-lg hover:bg-primary-600 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nouveau Produit
        </a>
    </div>

    <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input
                type="text"
                wire:model.live="search"
                placeholder="Rechercher..."
                class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
            >
        </div>

        <select wire:model.live="categoryFilter" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <input
            type="number"
            wire:model.live="minPrice"
            placeholder="Prix min"
            class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
        >

        <input
            type="number"
            wire:model.live="maxPrice"
            placeholder="Prix max"
            class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
        >
    </div>

    <div class="mb-6">
        <select wire:model.live="stockFilter" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option value="">Tous les stocks</option>
            <option value="in_stock">En stock</option>
            <option value="out_of_stock">Rupture de stock</option>
        </select>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Image</th>
                    <th scope="col" class="px-6 py-3">Nom</th>
                    <th scope="col" class="px-6 py-3">Marque</th>
                    <th scope="col" class="px-6 py-3">Catégorie</th>
                    <th scope="col" class="px-6 py-3">Prix</th>
                    <th scope="col" class="px-6 py-3">Stock</th>
                    <th scope="col" class="px-6 py-3">Référence</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-lg">
                            @else
                                <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-400 dark:text-gray-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $product->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $product->brand }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-primary-100 text-primary-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-primary-900 dark:text-primary-300">
                                {{ $product->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            {{ number_format($product->price, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->stock_quantity > 10 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : ($product->stock_quantity > 0 ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300') }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-mono">
                            {{ $product->sku }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="font-medium text-primary-600 dark:text-primary-500 hover:underline mr-4">Modifier</a>
                            <button
                                wire:click="deleteProduct({{ $product->id }})"
                                wire:confirm="Êtes-vous sûr de vouloir supprimer ce produit ?"
                                class="font-medium text-red-600 dark:text-red-500 hover:underline"
                            >
                                Supprimer
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 mb-3 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
