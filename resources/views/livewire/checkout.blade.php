<div>
    @if($totalItems > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Summary -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Récapitulatif de commande</h2>
                    
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div class="flex items-center justify-between border-b pb-4">
                                <div class="flex items-center">
                                    @if($item['product']->image_path)
                                        <img src="{{ asset($item['product']->image_path) }}" alt="{{ $item['product']->name }}" class="h-16 w-16 object-cover rounded">
                                    @else
                                        <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-2xl">📦</div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">{{ $item['product']->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $item['product']->brand }}</div>
                                        <div class="text-sm text-gray-600">Qté: {{ $item['quantity'] }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-medium text-gray-900">{{ number_format($item['subtotal'], 2, ',', ' ') }} €</div>
                                    <div class="text-sm text-gray-500">{{ number_format($item['product']->price, 2, ',', ' ') }} € / unité</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-4 border-t">
                        <div class="flex justify-between items-center text-lg font-bold">
                            <span>Total</span>
                            <span>{{ number_format($total, 2, ',', ' ') }} €</span>
                        </div>
                    </div>
                </div>

                <!-- Shipping Form -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informations de livraison</h2>
                    
                    <form wire:submit="placeOrder">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Adresse *</label>
                                <input 
                                    type="text" 
                                    wire:model="shipping_address" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required
                                >
                                @error('shipping_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ville/Commune *</label>
                                <select 
                                    wire:model="shipping_city" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required
                                >
                                    <option value="">Sélectionner une ville</option>
                                    <optgroup label="Communes d'Abidjan">
                                        <option value="Abobo">Abobo</option>
                                        <option value="Adjame">Adjame</option>
                                        <option value="Anyama">Anyama</option>
                                        <option value="Attécoubé">Attécoubé</option>
                                        <option value="Bingerville">Bingerville</option>
                                        <option value="Cocody">Cocody</option>
                                        <option value="Koumassi">Koumassi</option>
                                        <option value="Marcory">Marcory</option>
                                        <option value="Plateau">Plateau</option>
                                        <option value="Port-Bouët">Port-Bouët</option>
                                        <option value="Treichville">Treichville</option>
                                        <option value="Yopougon">Yopougon</option>
                                    </optgroup>
                                    <optgroup label="Région des Grands Ponts">
                                        <option value="Dabou">Dabou</option>
                                        <option value="Jacqueville">Jacqueville</option>
                                        <option value="Grand-Lahou">Grand-Lahou</option>
                                    </optgroup>
                                    <optgroup label="Autres villes">
                                        <option value="Bouaké">Bouaké</option>
                                        <option value="Korhogo">Korhogo</option>
                                        <option value="San-Pédro">San-Pédro</option>
                                        <option value="Yamoussoukro">Yamoussoukro</option>
                                    </optgroup>
                                </select>
                                @error('shipping_city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                                <input 
                                    type="text" 
                                    wire:model="shipping_phone" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required
                                >
                                @error('shipping_phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Notes (optionnel)</label>
                                <textarea 
                                    wire:model="notes" 
                                    rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Instructions de livraison spéciales..."
                                ></textarea>
                                @error('notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <button 
                                type="submit" 
                                class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors font-medium"
                            >
                                Confirmer la commande
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Info -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informations</h2>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nombre d'articles:</span>
                            <span class="font-medium">{{ $totalItems }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sous-total:</span>
                            <span class="font-medium">{{ number_format($total, 2, ',', ' ') }} €</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Livraison:</span>
                            <span class="font-medium text-green-600">Gratuite</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between">
                            <span class="text-gray-800 font-bold">Total:</span>
                            <span class="text-gray-800 font-bold">{{ number_format($total, 2, ',', ' ') }} €</span>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t">
                        <a href="{{ route('cart') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                            ← Retour au panier
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="text-gray-400 text-6xl mb-4">🛒</div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Votre panier est vide</h2>
            <p class="text-gray-600 mb-6">Ajoutez des produits avant de passer commande.</p>
            <a href="/" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                Retour à la boutique
            </a>
        </div>
    @endif
</div>
