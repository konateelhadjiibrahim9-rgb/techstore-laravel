<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="TechStore - Votre boutique informatique de confiance en Côte d'Ivoire. Ordinateurs, laptops, accessoires au meilleur prix.">
        <meta name="keywords" content="informatique, ordinateur, laptop, Côte d'Ivoire, Abidjan, techstore, matériel informatique">
        <meta name="author" content="TechStore">

        <title>TechStore - Boutique Informatique Côte d'Ivoire</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>💻</text></svg>">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans bg-gray-50">
        <div class="min-h-screen">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-4">
                        <div class="flex items-center">
                            <h1 class="text-2xl font-bold text-gray-900">TechStore</h1>
                        </div>
                        <nav class="flex items-center space-x-4">
                            <livewire:cart-counter />
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ route('my-orders') }}" class="text-gray-700 hover:text-gray-900">Mes Commandes</a>
                                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Connexion</a>
                                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Inscription</a>
                                @endauth
                            @endif
                        </nav>
                    </div>
                </div>
            </header>

            <!-- Hero Section -->
            <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 class="text-4xl font-bold mb-4">Bienvenue sur TechStore</h2>
                    <p class="text-xl mb-8">Le meilleur matériel informatique au meilleur prix</p>
                </div>
            </section>

            <!-- Products Section -->
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <h3 class="text-3xl font-bold text-gray-900 mb-8">Nos Produits</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        use App\Models\Product;
                        $products = Product::with('category')->get();
                    @endphp

                    @forelse($products as $product)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover-lift animate-fade-in">
                            <div class="h-48 bg-gray-200 flex items-center justify-center">
                                @if($product->image_path)
                                    <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="text-gray-400 text-6xl">📦</div>
                                @endif
                            </div>
                            
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm text-blue-600 font-semibold">{{ $product->brand }}</span>
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">{{ $product->category->name }}</span>
                                </div>
                                
                                <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $product->name }}</h4>
                                
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl font-bold text-gray-900">{{ number_format($product->price, 2, ',', ' ') }} €</span>
                                    
                                    @if($product->stock_quantity > 0)
                                        @if($product->stock_quantity > 10)
                                            <span class="text-sm text-green-600">En stock ({{ $product->stock_quantity }})</span>
                                        @else
                                            <span class="text-sm text-orange-600">Stock limité ({{ $product->stock_quantity }})</span>
                                        @endif
                                    @else
                                        <span class="text-sm text-red-600">Rupture de stock</span>
                                    @endif
                                </div>
                                
                                <livewire:add-to-cart :product-id="$product->id" :stock-quantity="$product->stock_quantity" />
                                
                                <div class="mt-3 text-xs text-gray-500">
                                    Réf: {{ $product->sku }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-500 text-lg">Aucun produit disponible pour le moment.</p>
                        </div>
                    @endforelse
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-gray-900 text-white py-12 mt-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div>
                            <h3 class="text-lg font-bold mb-4">TechStore</h3>
                            <p class="text-gray-400 text-sm">Votre boutique informatique de confiance en Côte d'Ivoire. Produits de qualité, service professionnel.</p>
                        </div>
                        <div>
                            <h4 class="text-md font-semibold mb-4">Liens rapides</h4>
                            <ul class="space-y-2 text-gray-400 text-sm">
                                <li><a href="/" class="hover:text-white transition-colors">Accueil</a></li>
                                <li><a href="/cart" class="hover:text-white transition-colors">Panier</a></li>
                                @auth
                                    <li><a href="{{ route('my-orders') }}" class="hover:text-white transition-colors">Mes Commandes</a></li>
                                @endauth
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-md font-semibold mb-4">Service client</h4>
                            <ul class="space-y-2 text-gray-400 text-sm">
                                <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                                <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                                <li><a href="#" class="hover:text-white transition-colors">Livraison</a></li>
                                <li><a href="#" class="hover:text-white transition-colors">Retours</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-md font-semibold mb-4">Contact</h4>
                            <ul class="space-y-2 text-gray-400 text-sm">
                                <li>📍 Abidjan, Côte d'Ivoire</li>
                                <li>📞 +225 XX XX XX XX XX</li>
                                <li>✉️ contact@techstore.ci</li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                        <p>&copy; {{ date('Y') }} TechStore. Tous droits réservés.</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
