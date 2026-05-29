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
        // Si l'utilisateur n'est pas connecté, envoie-le au login sans passer par la logique admin
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Si ce n'est pas un super admin, déconnecte-le et envoie-le au login
        if (!auth()->user()->isSuperAdmin()) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Accès réservé aux Super Admins.');
        }

        return $next($request);
    }
}
