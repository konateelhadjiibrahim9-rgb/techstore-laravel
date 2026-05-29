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
        \Log::info('IsSuperAdmin middleware check', [
            'authenticated' => auth()->check(),
            'is_super_admin' => auth()->check() ? auth()->user()->isSuperAdmin() : false,
            'route' => $request->route() ? $request->route()->getName() : 'unknown'
        ]);

        if (!auth()->check()) {
            \Log::info('Redirecting to login: not authenticated');
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        if (!auth()->user()->isSuperAdmin()) {
            \Log::info('Redirecting to login: not super admin');
            return redirect()->route('login')->with('error', 'Accès refusé. Cette fonctionnalité est réservée aux super administrateurs.');
        }

        \Log::info('IsSuperAdmin middleware passed');
        return $next($request);
    }
}
