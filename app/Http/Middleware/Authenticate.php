<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (Auth::guard('colaborador')->check()) {
            $colaborador = Auth::guard('colaborador')->user();
            if (is_null($colaborador->email_verified_at)) {
                Auth::guard('colaborador')->logout();
                return redirect()->route('login')
                    ->with('error', 'Você precisa confirmar seu email antes de acessar o painel.');
            }
        }

        return $next($request);
    }
}
