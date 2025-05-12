<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Colaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function verify(Request $request, $id)
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('login')
                ->with('error', 'Link inválido ou expirado. Por favor, solicite um novo link de verificação.');
        }

        $colaborador = Colaborador::findOrFail($id);

        if (! hash_equals((string) $request->route('hash'), sha1($colaborador->getEmailForVerification()))) {
            return redirect()->route('login')
                ->with('error', 'Link de verificação inválido.');
        }

        if ($colaborador->hasVerifiedEmail()) {
            return redirect()->route('login')
                ->with('info', 'Email já verificado anteriormente.');
        }

        $colaborador->markEmailAsVerified();
        $colaborador->status = 1;
        $colaborador->save();

        // Autentica o colaborador após a verificação
        Auth::login($colaborador);

        return redirect()->route('colaborador.dashboard')
            ->with('success', 'Email verificado com sucesso! Bem-vindo ao painel.');
    }
}
