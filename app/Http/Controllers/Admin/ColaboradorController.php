<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Colaborador;
use App\Models\User;
use App\Notifications\VerifyColaboradorEmail;
use App\Rules\CpfValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ColaboradorController extends Controller
{
    public function index()
    {
        $colaboradores = Colaborador::all();
        return view('admin.colaboradores.index', compact('colaboradores'));
    }

    public function create()
    {
        return view('admin.colaboradores.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nome' => 'required',
                'email' => 'required|email|unique:colaboradores',
                'cpf' => ['required', 'unique:colaboradores', new CpfValidation],
                'data_nascimento' => 'required|date',
                'password' => 'required|min:8',
            ], [
                'nome.required' => 'O campo nome é obrigatório',
                'email.required' => 'O campo email é obrigatório',
                'email.email' => 'Informe um email válido',
                'email.unique' => 'Este email já está em uso',
                'cpf.unique' => 'Este CPF já está cadastrado',
                'data_nascimento.required' => 'A data de nascimento é obrigatória',
                'data_nascimento.date' => 'Informe uma data válida',
                'password.required' => 'A senha é obrigatória',
                'password.min' => 'A senha deve ter no mínimo 8 caracteres'
            ]);

            $data['password'] = Hash::make($data['password']);
            $data['status'] = 0;

            $colaborador = Colaborador::create($data);

            User::create([
                'name' => $data['nome'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => 'colaborador'
            ]);

            try {
                $colaborador->notify(new VerifyColaboradorEmail);
            } catch (\Exception $e) {
                // Log the error and inform the user
                \Illuminate\Support\Facades\Log::error('Error sending verification email: ' . $e->getMessage());
                /*return redirect()->route('colaboradores.index')
                        ->with('warning', 'Colaborador cadastrado, mas o email de verificação não pôde ser enviado. Entre em contato com o suporte.');*/
                return redirect()->back()
                    ->withErrors($e->getMessage())
                    ->withInput();
            }

            return redirect()->route('colaboradores.index')
                ->with('success', 'Colaborador cadastrado com sucesso! Verifique seu email para ativar a conta.');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        }
    }

    public function dashboard()
    {
        $user = Auth::user();

        if ($user->role !== 'colaborador') {
            return redirect()->route('dashboard');
        }

        return view('colaborador.dashboard');
    }

    public function edit(Colaborador $colaborador)
    {
        return view('admin.colaboradores.edit', compact('colaborador'));
    }

    public function update(Request $request, Colaborador $colaborador)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:colaboradores,email,' . $colaborador->id,
            'cpf' => 'required|string|unique:colaboradores,cpf,' . $colaborador->id,
            'data_nascimento' => 'required|string',
            'status' => 'required|boolean'
        ]);

        $colaborador->update($request->all());

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaborador atualizado com sucesso!');
    }

    public function destroy(Colaborador $colaborador)
    {

        try {
            // Verifica se o colaborador tem clientes vinculados
            if ($colaborador->clientes()->exists()) {
                return redirect()->route('colaboradores.index')
                    ->with('error', 'Não é possível excluir o colaborador pois ele possui cliente(s) vinculados.');
            }

            // Remove o usuário associado
            User::where('email', $colaborador->email)->delete();

            // Exclui o colaborador
            $colaborador->delete();

            return redirect()->route('colaboradores.index')
                ->with('success', 'Colaborador excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('colaboradores.index')
                ->with('error', 'Erro ao excluir colaborador: ' . $e->getMessage());
        }
    }
}
