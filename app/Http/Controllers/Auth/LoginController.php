<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        \Log::info('Login attempt', ['email' => $request->email]);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            \Log::info('Login successful', [
                'email' => $request->email,
                'role' => Auth::user()->role,
                'is_admin' => Auth::user()->isAdmin(),
                'is_super_admin' => Auth::user()->isSuperAdmin()
            ]);
            
            // Rediriger tous les admins (admin et super_admin) vers le dashboard admin
            if (Auth::user()->isAdmin()) {
                \Log::info('Redirecting to admin.dashboard');
                return redirect()->route('admin.dashboard');
            }
            
            \Log::info('Redirecting to intended or /');
            return redirect()->intended('/');
        }

        \Log::info('Login failed', ['email' => $request->email]);

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
