<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Cliente;
use App\Models\Colaborador;
use App\Models\PriceTable;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with(['colaborador', 'price_tables'])->get();
        return view('admin.clientes.index', compact('clientes'));
    }

    public function create()
    {
        $colaboradores = Colaborador::all();
        $price_tables = PriceTable::all();
        return view('admin.clientes.create', compact('colaboradores', 'price_tables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'razao_social' => 'required',
            'email' => 'required|email|unique:clientes',
            'cnpj' => 'required|unique:clientes',
            'colaborador_id' => 'required|exists:colaboradores,id',
            'price_tables_id' => 'required'
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente criado com sucesso.');
    }

    public function edit(Cliente $cliente)
    {
        $colaboradores = Colaborador::all();
        $priceTables = PriceTable::all();
        return view('admin.clientes.edit', compact('cliente', 'colaboradores', 'priceTables'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'razao_social' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email,'.$cliente->id,
            'cnpj' => 'required|string|unique:clientes,cnpj,'.$cliente->id,
            'colaborador_id' => 'required|exists:colaboradores,id',
            'price_tables_id' => 'required|exists:price_tables,id',
            'status' => 'required|boolean'
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }
}
