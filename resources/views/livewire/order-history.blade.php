<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mes Commandes</h1>
        <p class="text-gray-600">Historique de vos commandes</p>
    </div>

    @if($selectedOrder)
        <!-- Order Detail Modal -->
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Détail de la commande #{{ $selectedOrder->order_number }}</h2>
                        <button wire:click="closeOrder" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Date</p>
                                <p class="font-semibold">{{ $selectedOrder->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Statut</p>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'paid' => 'bg-green-100 text-green-800',
                                        'shipped' => 'bg-blue-100 text-blue-800',
                                        'delivered' => 'bg-purple-100 text-purple-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'En attente',
                                        'paid' => 'Payée',
                                        'shipped' => 'Expédiée',
                                        'delivered' => 'Livrée',
                                        'cancelled' => 'Annulée',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$selectedOrder->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$selectedOrder->status] ?? $selectedOrder->status }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Adresse de livraison</p>
                            <p class="font-semibold">{{ $selectedOrder->shipping_address }}</p>
                            <p class="text-gray-700">{{ $selectedOrder->shipping_city }}</p>
                            <p class="text-gray-700">{{ $selectedOrder->shipping_phone }}</p>
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-800 mb-2">Articles</h3>
                            <div class="space-y-2">
                                @foreach($selectedOrder->orderItems as $item)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                        <div class="flex items-center">
                                            @if($item->product->image_path)
                                                <img src="{{ asset($item->product->image_path) }}" alt="{{ $item->product->name }}" class="h-12 w-12 object-cover rounded mr-3">
                                            @else
                                                <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center text-gray-400 mr-3">📦</div>
                                            @endif
                                            <div>
                                                <p class="font-semibold">{{ $item->product->name }}</p>
                                                <p class="text-sm text-gray-600">Quantité: {{ $item->quantity }} × {{ number_format($item->price, 2, ',', ' ') }} €</p>
                                            </div>
                                        </div>
                                        <p class="font-bold">{{ number_format($item->subtotal, 2, ',', ' ') }} €</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center">
                                <p class="text-lg font-bold text-gray-800">Total</p>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($selectedOrder->total_amount, 2, ',', ' ') }} €</p>
                            </div>
                        </div>

                        @if($selectedOrder->notes)
                            <div>
                                <p class="text-sm text-gray-600">Notes</p>
                                <p class="text-gray-700">{{ $selectedOrder->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    @forelse($orders as $order)
        <div class="bg-white rounded-lg shadow p-6 mb-4 hover:shadow-lg transition-shadow">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-4 mb-2">
                        <h3 class="text-lg font-bold text-gray-800">#{{ $order->order_number }}</h3>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'paid' => 'bg-green-100 text-green-800',
                                'shipped' => 'bg-blue-100 text-blue-800',
                                'delivered' => 'bg-purple-100 text-purple-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                            $statusLabels = [
                                'pending' => 'En attente',
                                'paid' => 'Payée',
                                'shipped' => 'Expédiée',
                                'delivered' => 'Livrée',
                                'cancelled' => 'Annulée',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $statusLabels[$order->status] ?? $order->status }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p class="text-sm text-gray-600">{{ $order->orderItems->count() }} article(s)</p>
                </div>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <p class="text-xl font-bold text-gray-900">{{ number_format($order->total_amount, 2, ',', ' ') }} €</p>
                    <button 
                        wire:click="viewOrder({{ $order->id }})"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        Voir le détail
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="text-gray-400 text-6xl mb-4">📦</div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Aucune commande</h2>
            <p class="text-gray-600 mb-6">Vous n'avez pas encore passé de commande.</p>
            <a href="/" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                Découvrir nos produits
            </a>
        </div>
    @endforelse
</div>
