<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'user')->get();
        return view('dashboard.admins', ['users' => $users]);
    }

    public function updateRole(Request $request, $userId)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|required|email|exists:users,email',
            'role' => 'required|in:user,admin,super_admin',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.admins.index')
                ->withErrors($validator)
                ->withInput();
        }

        // Si c'est un nouvel administrateur (email fourni)
        if ($request->has('email')) {
            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                return redirect()->route('admin.admins.index')
                    ->with('error', 'Utilisateur non trouvé avec cet email.');
            }

            // Vérifier que l'utilisateur n'est pas déjà admin
            if ($user->role !== 'user') {
                return redirect()->route('admin.admins.index')
                    ->with('error', 'Cet utilisateur a déjà un rôle d\'administrateur.');
            }
        } else {
            // Modification d'un utilisateur existant
            $user = User::find($userId);
            
            if (!$user) {
                return redirect()->route('admin.admins.index')
                    ->with('error', 'Utilisateur non trouvé.');
            }
        }

        // Vérifier que l'utilisateur ne se modifie pas lui-même
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');
        }

        // Sécurité supplémentaire : vérifier que le rôle demandé est valide
        $validRoles = ['user', 'admin', 'super_admin'];
        if (!in_array($request->role, $validRoles)) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Rôle invalide.');
        }

        // Mise à jour du rôle
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Rôle de l\'utilisateur mis à jour avec succès.');
    }
}
