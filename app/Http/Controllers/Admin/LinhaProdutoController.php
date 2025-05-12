<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LinhaProduto;
use Illuminate\Http\Request;

class LinhaProdutoController extends Controller
{
    public function index()
    {
        $lines = LinhaProduto::get();
        return view('product-line.index', compact('lines'));
    }

    public function create()
    {
        return view('product-line.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        LinhaProduto::create([
            'name' => $request->name,
        ]);

        return redirect()->route('product-line.index')->with('success', 'Categoria criado com sucesso!');
    }

    public function show(LinhaProduto $line)
    {
        return view('product-line.show', compact('line'));
    }

    public function edit(LinhaProduto $line)
    {
        return view('product-line.edit', compact('line'));
    }

    public function update(Request $request, LinhaProduto $line)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $line->update($request->except('name') + ['name' => $request->name]);

        return redirect()->route('product-line.index')->with('success', 'Categoria atualizado com sucesso!');
    }

    public function destroy(LinhaProduto $line)
    {

        $line->delete();

        return redirect()->route('product-line.index')->with('success', 'Categoria removido com sucesso!');
    }
}
