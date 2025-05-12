<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Colaborador;
use App\Models\User;
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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tenta autenticar como usuário
        if (Auth::guard('web')->attempt($credentials, $request->remember)) {
            return $this->authenticated($request, Auth::guard('web')->user());
        }

        // Tenta autenticar como colaborador
        if (Auth::guard('colaborador')->attempt($credentials, $request->remember)) {
            return $this->authenticated($request, Auth::guard('colaborador')->user());
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ])->withInput($request->only('email', 'remember'));
    }

    protected function authenticated(Request $request, $user)
    {
        if (Auth::guard('colaborador')->check()) {
            return redirect()->route('colaborador.dashboard');
        }

        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('colaborador')->check()) {
            Auth::guard('colaborador')->logout();
        } else {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}