<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-xl font-semibold text-gray-900 mb-4">Demander un Devis</h3>
    <form action="{{ route('dashboard.quote.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Entreprise</label>
                <input type="text" name="company" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom du contact</label>
                <input type="text" name="contact_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                <input type="tel" name="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie de produit</label>
                <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200">
                    <option value="">Sélectionner...</option>
                    <option value="pc-portables">PC Portables</option>
                    <option value="pc-de-bureau">PC de Bureau</option>
                    <option value="serveurs">Serveurs</option>
                    <option value="composants">Composants</option>
                    <option value="accessoires">Accessoires</option>
                    <option value="imprimantes">Imprimantes</option>
                    <option value="reseau">Réseau</option>
                    <option value="stockage">Stockage</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description du besoin</label>
                <textarea name="description" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200" placeholder="Décrivez vos besoins en détail..."></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Budget estimé (FCFA)</label>
                <input type="number" name="budget" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200" placeholder="Ex: 500000">
            </div>
            <button type="submit" class="w-full bg-orange-600 text-white py-3 rounded-lg hover:bg-orange-700 transition-colors font-medium shadow-md hover:shadow-lg">
                Envoyer la demande
            </button>
        </div>
    </form>
</div>
