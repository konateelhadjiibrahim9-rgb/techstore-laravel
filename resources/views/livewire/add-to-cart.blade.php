<div>
    <button 
        wire:click="addToCart"
        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors duration-200 disabled:bg-gray-300 disabled:cursor-not-allowed"
        {{ $stockQuantity > 0 ? '' : 'disabled' }}
    >
        {{ $stockQuantity > 0 ? 'Ajouter au panier' : 'Indisponible' }}
    </button>
</div>
