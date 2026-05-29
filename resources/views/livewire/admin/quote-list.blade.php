<div class="p-4 md:p-8">
    @if(session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Devis</h1>
    </div>

    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <input 
            type="text" 
            wire:model="search" 
            placeholder="Rechercher..." 
            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
        
        <select wire:model="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Tous les statuts</option>
            <option value="pending">En attente</option>
            <option value="in_review">En cours d'examen</option>
            <option value="approved">Approuvé</option>
            <option value="rejected">Rejeté</option>
        </select>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entreprise</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant Estimé</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($quotes as $quote)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $quote->contact_name }}</div>
                            @if($quote->user)
                                <div class="text-xs text-gray-500">Utilisateur: {{ $quote->user->name }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $quote->company_name ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $quote->email }}</div>
                            @if($quote->phone)
                                <div class="text-xs text-gray-500">{{ $quote->phone }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate">{{ $quote->message }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <select wire:model.live="status.{{ $quote->id }}" class="text-xs px-2 py-1 border rounded">
                                <option value="pending" {{ $quote->status === 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="in_review" {{ $quote->status === 'in_review' ? 'selected' : '' }}>En cours</option>
                                <option value="approved" {{ $quote->status === 'approved' ? 'selected' : '' }}>Approuvé</option>
                                <option value="rejected" {{ $quote->status === 'rejected' ? 'selected' : '' }}>Rejeté</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input 
                                type="number" 
                                wire:model.live="amount.{{ $quote->id }}" 
                                value="{{ $quote->estimated_amount }}"
                                placeholder="0.00"
                                class="w-24 px-2 py-1 border rounded text-sm"
                                step="0.01"
                            >
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button 
                                wire:click="updateQuoteStatus({{ $quote->id }}, $status['{{ $quote->id }}'])"
                                class="text-blue-600 hover:text-blue-900 mr-3"
                            >
                                Mettre à jour
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Aucun devis trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $quotes->links() }}
    </div>
</div>
