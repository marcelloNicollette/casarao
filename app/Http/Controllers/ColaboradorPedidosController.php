<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use App\Models\ProdutosPedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColaboradorPedidosController extends Controller
{
    public function index()
    {
        $pedidos = Pedidos::where('client_id', session('cliente_id'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('front.meus-pedidos', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedidos::findOrFail($id);
        $produtos = ProdutosPedido::where('pedido_id', $id)->get();

        return view('front.detalhe-pedido', compact('pedido', 'produtos'));
    }
}
