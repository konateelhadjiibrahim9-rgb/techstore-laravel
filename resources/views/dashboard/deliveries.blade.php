@extends('layouts.admin', ['title' => 'Gestion des Livraisons'])

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Gestion des Livraisons</h2>
            <a href="{{ route('dashboard.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Retour au tableau de bord
            </a>
        </div>

        <div class="bg-gray-50 rounded-lg p-8 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Module de gestion des livraisons</h3>
            <p class="text-gray-500">Cette section sera développée ultérieurement pour gérer les livraisons des commandes.</p>
        </div>
    </div>
</div>
@endsection
