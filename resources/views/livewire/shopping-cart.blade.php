<div>
    @if($totalItems > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sous-total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($cartItems as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($item['product']->image_path)
                                            <img src="{{ asset($item['product']->image_path) }}" alt="{{ $item['product']->name }}" class="h-16 w-16 object-cover rounded">
                                        @else
                                            <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-2xl">📦</div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item['product']->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $item['product']->brand }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($item['product']->price, 2, ',', ' ') }} €</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <button 
                                            wire:click="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] - 1 }})"
                                            class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center"
                                        >
                                            -
                                        </button>
                                        <span class="w-8 text-center">{{ $item['quantity'] }}</span>
                                        <button 
                                            wire:click="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] + 1 }})"
                                            class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center"
                                        >
                                            +
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ number_format($item['subtotal'], 2, ',', ' ') }} €</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button 
                                        wire:click="removeProduct({{ $item['product']->id }})"
                                        wire:confirm="Êtes-vous sûr de vouloir supprimer ce produit ?"
                                        class="text-red-600 hover:text-red-800"
                                    >
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 px-6 py-4 flex justify-between items-center">
                <div class="text-lg font-medium text-gray-900">
                    Total: {{ number_format($total, 2, ',', ' ') }} €
                </div>
                <div class="flex space-x-4">
                    <button 
                        wire:click="clearCart"
                        wire:confirm="Êtes-vous sûr de vouloir vider le panier ?"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
                    >
                        Vider le panier
                    </button>
                    <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Passer la commande
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="text-gray-400 text-6xl mb-4">🛒</div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Votre panier est vide</h2>
            <p class="text-gray-600 mb-6">Ajoutez des produits pour commencer vos achats.</p>
            <a href="/" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                Retour à la boutique
            </a>
        </div>
    @endif
</div>
