<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'user')->get();
        return view('dashboard.admins', ['users' => $users]);
    }

    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,super_admin',
            'password' => 'sometimes|required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.admins.index')
                ->withErrors($validator)
                ->withInput();
        }

        // Génération du mot de passe
        $password = $request->auto_generate_password 
            ? Str::random(12) 
            : $request->password;

        // Création de l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => $request->role,
        ]);

        // Message de succès avec le mot de passe généré
        $message = $request->auto_generate_password
            ? "Administrateur créé avec succès. Mot de passe généré : {$password}"
            : "Administrateur créé avec succès.";

        return redirect()->route('admin.admins.index')
            ->with('success', $message);
    }

    public function updateRole(Request $request, $userId)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:user,admin,super_admin',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.admins.index')
                ->withErrors($validator)
                ->withInput();
        }

        // Modification d'un utilisateur existant
        $user = User::find($userId);
        
        if (!$user) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Utilisateur non trouvé.');
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
