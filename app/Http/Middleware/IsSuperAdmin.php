<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Autoriser l'accès à la page de login pour éviter la boucle
        if ($request->routeIs('login')) {
            return $next($request);
        }

        // 2. Vérifier l'authentification
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 3. Autoriser l'accès aux admins ET super_admins
        if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin()) {
            return $next($request);
        }

        // 4. Si aucun rôle, déconnecter et rediriger
        auth()->logout();
        return redirect()->route('login')->with('error', 'Accès non autorisé.');
    }
}
