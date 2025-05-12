<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PriceTable;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PriceTableExport;

use Illuminate\Support\Str;

class PriceTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $priceTables = PriceTable::with('products')->get();
        return view('admin.price-tables.index', compact('priceTables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::orderBy('title', 'asc')->get();
        return view('admin.price-tables.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        // Validação apenas dos campos da tabela price_tables
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:price_tables',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Validação adicional para produtos e preços
        $request->validate([
            'products' => 'required|array',
            'prices' => 'required|array',
            'prices.*' => 'required|numeric|min:0'
        ]);

        // Criar a tabela de preços apenas com os campos válidos
        $priceTable = PriceTable::create($validated);

        // Anexar produtos e preços
        foreach ($request->products as $index => $productId) {
            if ($request->prices[$index] != 0.00) {
                $priceTable->products()->attach($productId, [
                    'price' => $request->prices[$index]
                ]);
            }
        }

        return redirect()->route('price-tables.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PriceTable $priceTable)
    {
        $priceTable->load(['products' => function ($query) {
            $query->orderBy('title', 'asc');
        }]);

        return view('admin.price-tables.show', compact('priceTable'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PriceTable $priceTable)
    {
        $products = Product::orderBy('title', 'asc')->get();
        return view('admin.price-tables.edit', compact('priceTable', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PriceTable $priceTable)
    {
        // Valida apenas os campos da PriceTable
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:price_tables,name,' . $priceTable->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Atualiza a PriceTable
        $priceTable->update($validated);

        // Remove todos os produtos associados
        $priceTable->products()->detach();

        // Adiciona os novos produtos e preços
        if ($request->has('products')) {
            foreach ($request->products as $index => $productId) {
                if (isset($request->prices[$index]) && $request->prices[$index] !== null) {
                    $priceTable->products()->attach($productId, [
                        'price' => $request->prices[$index]
                    ]);
                }
            }
        }

        return redirect()->route('price-tables.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PriceTable $priceTable)
    {
        $priceTable->products()->detach();
        $priceTable->delete();
        return redirect()->route('price-tables.index');
    }

    public function import(Request $request, PriceTable $priceTable)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $csvData = array_map('str_getcsv', file($file));

        foreach ($csvData as $row) {
            $productName = trim($row[0]);
            $price = (float)str_replace(',', '.', trim($row[1]));

            $product = Product::where('title', $productName)->first();

            if ($product) {
                $priceTable->products()->syncWithoutDetaching([
                    $product->id => ['price' => $price]
                ]);
            }
        }

        return redirect()->route('price-tables.show', $priceTable)
            ->with('success', 'Tabela de preços importada com sucesso!');
    }

    public function duplicate(Request $request, PriceTable $priceTable)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:price_tables',
            'description' => 'nullable|string'
        ]);

        // Cria a nova tabela
        $newPriceTable = PriceTable::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $priceTable->is_active
        ]);

        // Duplica os produtos e preços
        foreach ($priceTable->products as $product) {
            $newPriceTable->products()->attach($product->id, [
                'price' => $product->pivot->price
            ]);
        }

        return redirect()->route('price-tables.show', $newPriceTable)
            ->with('success', 'Tabela duplicada com sucesso!');
    }


    public function export(PriceTable $priceTable)
    {
        $fileName = 'tabela-precos-' . Str::slug($priceTable->name) . '.xlsx';
        return Excel::download(new PriceTableExport($priceTable), $fileName);
    }
}
