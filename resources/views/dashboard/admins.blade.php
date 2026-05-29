@extends('layouts.admin', ['title' => 'Gestion des Administrateurs'])

@section('content')
<div class="p-4 md:p-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Gestion des Administrateurs</h1>

    @if(session()->has('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-400 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-400 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Formulaire d'ajout -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6 mb-8">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Ajouter un administrateur</h3>
        <form action="{{ route('admin.admins.update.role', ['user' => 'new']) }}" method="POST" id="addAdminForm" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email de l'utilisateur</label>
                    <input 
                        type="email" 
                        id="email"
                        name="email" 
                        placeholder="exemple@email.com" 
                        class="w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                        required
                    >
                    @if($errors->has('email'))
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <div>
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rôle</label>
                    <select 
                        id="role"
                        name="role" 
                        class="w-full px-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    >
                        <option value="admin">Admin</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end">
                <button 
                    type="submit" 
                    id="submitBtn"
                    class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-primary-500 rounded-lg hover:bg-primary-600 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <svg id="spinner" class="hidden w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="btnText">Ajouter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Liste des administrateurs -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Administrateurs existants</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nom</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Rôle</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $user->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4">
                                @if($user->role === 'super_admin')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                        Super Admin
                                    </span>
                                @elseif($user->role === 'admin')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                        Admin
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        User
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.admins.update.role', ['user' => $user->id]) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        <select name="role" class="px-3 py-1.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="super_admin" {{ $user->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                        </select>
                                        <button type="submit" class="px-3 py-1.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 dark:focus:ring-green-900 transition-colors">
                                            Modifier
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-sm italic">Vous</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 mb-3 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <p class="text-sm font-medium">Aucun administrateur trouvé</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('addAdminForm');
        const submitBtn = document.getElementById('submitBtn');
        const spinner = document.getElementById('spinner');
        const btnText = document.getElementById('btnText');

        if (form && submitBtn) {
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                spinner.classList.remove('hidden');
                btnText.textContent = 'Traitement...';
            });
        }
    });
</script>
@endsection
