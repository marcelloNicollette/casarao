<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedidos;
use App\Models\ProdutosPedido;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPedidosController extends Controller
{
    public function index()
    {
        $pedidos = Pedidos::with(['cliente', 'user', 'produtos'])
            ->orderBy('created_at', 'desc')
            ->get();
        //dd($pedidos);
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedidos::with(['cliente', 'produtos'])->findOrFail($id);
        return view('admin.pedidos.show', compact('pedido'));
    }
}
