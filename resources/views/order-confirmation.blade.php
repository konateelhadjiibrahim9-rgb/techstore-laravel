@extends('layouts.admin')

@section('title', 'Confirmation de commande')

@section('content')
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
            <a href="{{ route('dashboard') }}" class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50">
                Mon compte
            </a>
        </div>
    </div>
</div>
@endsection
