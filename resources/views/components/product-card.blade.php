<div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden group">
    <!-- Image -->
    <div class="relative h-48 bg-gray-100 overflow-hidden">
        @if($product->image_path)
            <img src="{{ asset('storage/' . $product->image_path) }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100">
                <svg class="w-16 h-16 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        @endif
        
        <!-- Badge Category -->
        <div class="absolute top-3 left-3 bg-blue-900 text-white text-xs px-3 py-1 rounded-full font-medium">
            {{ $product->category->name ?? 'Matériel' }}
        </div>
        
        <!-- Badge Stock -->
        @if($product->stock > 0)
            <div class="absolute top-3 right-3 bg-green-500 text-white text-xs px-2 py-1 rounded-full font-medium">
                En stock
            </div>
        @else
            <div class="absolute top-3 right-3 bg-red-500 text-white text-xs px-2 py-1 rounded-full font-medium">
                Rupture
            </div>
        @endif
    </div>

    <!-- Content -->
    <div class="p-5">
        <!-- Title -->
        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-900 transition-colors">
            {{ $product->name }}
        </h3>
        
        <!-- Specifications -->
        <div class="space-y-2 mb-4">
            @if($product->processor)
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                    <span>{{ $product->processor }}</span>
                </div>
            @endif
            
            @if($product->ram)
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                    </svg>
                    <span>{{ $product->ram }} RAM</span>
                </div>
            @endif
            
            @if($product->storage)
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                    </svg>
                    <span>{{ $product->storage }}</span>
                </div>
            @endif
        </div>

        <!-- Price -->
        <div class="flex items-center justify-between mb-4">
            <div>
                <span class="text-2xl font-bold text-blue-900">
                    {{ number_format($product->price, 0, ',', ' ') }} FCFA
                </span>
            </div>
            @if($product->discount)
                <span class="text-sm text-gray-500 line-through">
                    {{ number_format($product->discount, 0, ',', ' ') }} FCFA
                </span>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex space-x-2">
            <a href="{{ route('dashboard.products.show', $product->id) }}" 
               class="flex-1 bg-blue-900 text-white py-2.5 rounded-lg hover:bg-blue-800 transition-colors text-center font-medium">
                Voir détails
            </a>
            <button class="px-4 py-2.5 border border-orange-500 text-orange-600 rounded-lg hover:bg-orange-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
