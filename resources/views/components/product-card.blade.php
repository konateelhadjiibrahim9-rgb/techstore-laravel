<div class="card p-5 group">
    <!-- Image -->
    <div class="relative h-56 bg-[#f8fafc] overflow-hidden rounded-lg mb-5">
        @if($product->image_path)
            <img src="{{ asset('storage/' . $product->image_path) }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#f8fafc] to-[#e2e8f0]">
                <svg class="w-20 h-20 text-[#94a3b8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        @endif
        
        <!-- Badge Category -->
        <div class="absolute top-3 left-3 bg-[#1e293b] text-white text-xs px-3 py-1.5 rounded-full font-medium shadow-md">
            {{ $product->category->name ?? 'Matériel' }}
        </div>
        
        <!-- Badge Stock -->
        @if($product->stock > 0)
            <div class="absolute top-3 right-3 bg-[#10b981] text-white text-xs px-2.5 py-1 rounded-full font-medium shadow-md">
                En stock
            </div>
        @else
            <div class="absolute top-3 right-3 bg-[#ef4444] text-white text-xs px-2.5 py-1 rounded-full font-medium shadow-md">
                Rupture
            </div>
        @endif
    </div>

    <!-- Content -->
    <div>
        <!-- Title -->
        <h3 class="text-lg font-semibold text-[#1e293b] mb-3 line-clamp-2 group-hover:text-[#f97316] transition-colors">
            {{ $product->name }}
        </h3>
        
        <!-- Specifications -->
        <div class="space-y-2.5 mb-5">
            @if($product->processor)
                <div class="flex items-center text-sm text-[#64748b]">
                    <svg class="w-4 h-4 mr-2.5 text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                    <span>{{ $product->processor }}</span>
                </div>
            @endif
            
            @if($product->ram)
                <div class="flex items-center text-sm text-[#64748b]">
                    <svg class="w-4 h-4 mr-2.5 text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                    </svg>
                    <span>{{ $product->ram }} RAM</span>
                </div>
            @endif
            
            @if($product->storage)
                <div class="flex items-center text-sm text-[#64748b]">
                    <svg class="w-4 h-4 mr-2.5 text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                    </svg>
                    <span>{{ $product->storage }}</span>
                </div>
            @endif
        </div>

        <!-- Price -->
        <div class="flex items-center justify-between mb-5">
            <div>
                <span class="text-2xl font-bold text-[#1e293b]">
                    {{ number_format($product->price, 0, ',', ' ') }} FCFA
                </span>
            </div>
            @if($product->discount)
                <span class="text-sm text-[#94a3b8] line-through">
                    {{ number_format($product->discount, 0, ',', ' ') }} FCFA
                </span>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex space-x-3">
            <a href="{{ route('dashboard.products.show', $product->id) }}" 
               class="flex-1 bg-[#1e293b] text-white py-3 rounded-lg hover:bg-[#334155] transition-colors text-center font-medium shadow-md hover:shadow-lg">
                Voir détails
            </a>
            <button class="px-4 py-3 border-2 border-[#f97316] text-[#f97316] rounded-lg hover:bg-[#f97316] hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
