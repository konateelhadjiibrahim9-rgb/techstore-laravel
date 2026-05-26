@extends('layouts.admin', ['title' => 'Gestion des Devis'])

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Gestion des Devis</h2>
            <a href="{{ route('dashboard.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Retour au tableau de bord
            </a>
        </div>

        <div class="bg-gray-50 rounded-lg p-8 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Module de gestion des devis</h3>
            <p class="text-gray-500">Cette section sera développée ultérieurement pour gérer les devis clients.</p>
        </div>
    </div>
</div>
@endsection
