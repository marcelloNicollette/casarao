<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Tenta autenticar como colaborador primeiro
        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            
            if ($user->status === 0) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Sua conta ainda não foi ativada. Verifique seu email para ativar.');
            }
        
            $request->session()->regenerate();
            
            if ($user->role === 'colaborador') {
                return redirect()->route('colaborador.dashboard');
            }
            
            return redirect()->intended(route('dashboard', absolute: false));
        }
    
        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
