<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Confirmation de commande - TechStore</title>

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
                            @auth
                                <a href="{{ route('dashboard.index') }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                            @endauth
                        </nav>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <div class="text-green-500 text-6xl mb-4">✓</div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">Merci pour votre commande !</h1>
                        <p class="text-gray-600 mb-6">Votre commande a été enregistrée avec succès.</p>
                        
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <p class="text-sm text-gray-600 mb-2">Numéro de commande</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $orderNumber }}</p>
                        </div>

                        <div class="text-sm text-gray-600 mb-6">
                            <p>Vous recevrez un email de confirmation avec les détails de votre commande.</p>
                            <p class="mt-2">Nous vous informerons dès que votre commande sera expédiée.</p>
                        </div>

                        <div class="flex justify-center space-x-4">
                            <a href="/" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                                Continuer mes achats
                            </a>
                            <a href="{{ route('my-orders') }}" class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50">
                                Mes commandes
                            </a>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-gray-800 text-white py-8 mt-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <p>&copy; {{ date('Y') }} TechStore. Tous droits réservés.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
