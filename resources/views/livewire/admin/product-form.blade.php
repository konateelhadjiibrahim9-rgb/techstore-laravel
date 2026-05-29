<div class="p-4 md:p-8">
    @if(session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $isEdit ? 'Modifier le Produit' : 'Nouveau Produit' }}</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom du produit *</label>
                    <input 
                        type="text" 
                        wire:model="name" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Marque *</label>
                    <input 
                        type="text" 
                        wire:model="brand" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                    @error('brand') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Référence (SKU) *</label>
                    <input 
                        type="text" 
                        wire:model="sku" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                    @error('sku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie *</label>
                    <select 
                        wire:model="category_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prix (FCFA) *</label>
                    <input 
                        type="number" 
                        step="0.01" 
                        wire:model="price" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                    @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantité en stock *</label>
                    <input 
                        type="number" 
                        wire:model="stock_quantity" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                        min="0"
                    >
                    @error('stock_quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Images du produit</label>
                    @if($image_path)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $image_path) }}" alt="Image actuelle" class="h-32 w-32 object-cover rounded">
                        </div>
                    @endif
                    @if(isset($images) && count($images) > 0)
                        <div class="mb-3 grid grid-cols-4 gap-2">
                            @foreach($images as $image)
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Image produit" class="h-24 w-full object-cover rounded">
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <input 
                        type="file" 
                        wire:model="images" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        accept="image/jpeg,image/png,image/webp"
                        multiple
                    >
                    <p class="text-sm text-gray-500 mt-1">Formats acceptés : JPEG, PNG, WebP (max 2Mo par image). Vous pouvez sélectionner plusieurs images.</p>
                    @error('images') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                    <textarea 
                        wire:model="description" 
                        rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    ></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Variantes -->
            <div class="mt-8 border-t pt-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Variantes du produit</h2>
                
                <!-- Liste des variantes existantes -->
                @if(count($variants) > 0)
                    <div class="mb-4 space-y-2">
                        @foreach($variants as $index => $variant)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <span class="font-medium">{{ $variant['name'] }}</span>
                                    <span class="text-gray-500 ml-2">SKU: {{ $variant['sku'] }}</span>
                                    <span class="text-gray-500 ml-2">{{ number_format($variant['price'], 2) }} FCFA</span>
                                    <span class="text-gray-500 ml-2">Stock: {{ $variant['stock_quantity'] }}</span>
                                </div>
                                <button 
                                    type="button"
                                    wire:click="removeVariant({{ $index }})"
                                    class="text-red-600 hover:text-red-800"
                                >
                                    Supprimer
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Formulaire d'ajout de variante -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-medium text-gray-700 mb-3">Ajouter une variante</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                            <input 
                                type="text" 
                                wire:model="variantName" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            @error('variantName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                            <input 
                                type="text" 
                                wire:model="variantSku" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            @error('variantSku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prix</label>
                            <input 
                                type="number" 
                                step="0.01" 
                                wire:model="variantPrice" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            @error('variantPrice') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                            <input 
                                type="number" 
                                wire:model="variantStock" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                min="0"
                            >
                            @error('variantStock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <button 
                        type="button"
                        wire:click="addVariant"
                        class="mt-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                    >
                        Ajouter la variante
                    </button>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Annuler
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                >
                    {{ $isEdit ? 'Modifier' : 'Créer' }} le produit
                </button>
            </div>
        </form>
    </div>
</div>
