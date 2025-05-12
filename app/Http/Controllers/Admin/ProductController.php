<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\LinhaProduto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('title', 'asc')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $lines = LinhaProduto::all();
        return view('admin.products.create', compact('lines', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'linhaproduto_id' => 'required|exists:linhaproduto,id',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('products', 'public') : null;

        Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'category_id' => $request->category_id,
            'linhaproduto_id' => $request->linhaproduto_id,
            'cod_produto' => $request->linhaproduto_id,
            'unidade' => $request->linhaproduto_id,
            'validade' => $request->linhaproduto_id,
            'observacao' => $request->observacao,
            'status' => $request->status,
        ]);

        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso!');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $lines = LinhaProduto::all();
        return view('admin.products.edit', compact('product', 'categories', 'lines'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update($request->except('image') + ['image' => $product->image]);

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produto removido com sucesso!');
    }
}
