<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductPrice;
use App\Models\PriceTable;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductPriceController extends Controller
{
    public function index()
    {
        $productPrices = ProductPrice::with(['priceTable', 'product'])->get();
        return view('admin.product-prices.index', compact('productPrices'));
    }

    public function create()
    {
        $priceTables = PriceTable::all();
        $products = Product::all();
        return view('admin.product-prices.create', compact('priceTables', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'price_table_id' => 'required|exists:price_tables,id',
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0'
        ]);

        ProductPrice::create($validated);
        return redirect()->route('product-prices.index');
    }

    public function show(ProductPrice $productPrice)
    {
        return view('admin.product-prices.show', compact('productPrice'));
    }

    public function edit(ProductPrice $productPrice)
    {
        $priceTables = PriceTable::all();
        $products = Product::all();
        return view('admin.product-prices.edit', compact('productPrice', 'priceTables', 'products'));
    }

    public function update(Request $request, ProductPrice $productPrice)
    {
        $validated = $request->validate([
            'price_table_id' => 'required|exists:price_tables,id',
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0'
        ]);

        $productPrice->update($validated);
        return redirect()->route('product-prices.index');
    }

    public function destroy(ProductPrice $productPrice)
    {
        $productPrice->delete();
        return redirect()->route('product-prices.index');
    }
}
