<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use App\Models\ProdutosPedido;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PedidosController extends Controller
{
  function register(Request $request)
  {
    $cliente_id = session('cliente_id');
    if (count($request->pedido) > 0) {
      $newPedido = new Pedidos();
      $newPedido->user_id = Auth::id();
      $newPedido->client_id = $cliente_id;
      $newPedido->registro_pedido = "Pedido do cliente: " . $cliente_id . " - Colaborador: " . Auth::user()->name;

      if ($newPedido->save()) {
        foreach ($request->pedido as $pedido) {
          $produtosPedido = new ProdutosPedido();
          $produtosPedido->pedido_id = $newPedido->id;
          $produtosPedido->cod_produto = $pedido["id"];
          $produtosPedido->produto = $pedido["title"];
          $produtosPedido->qtd = $pedido["quantity"];
          $produtosPedido->price = $pedido["price"];

          $produtosPedido->save();
        }

        Session::put('checkout_id', $newPedido->id);

        return response()->json(array('status' => 'success', 'message' => 'Pré-pedido registrado com sucesso.'), 200);
      }

      return response()->json(array('status' => 'error', 'message' => 'Ocorreu um erro ao registrar o pré-pedido. Por favor, tente novamente.'), 500);
    } else {
      return response()->json(array('status' => 'error', 'message' => 'Nenhum produto adicionado a sacola.'), 500);
    }
  }

  public function editCheckoutName(Request $request)
  {
    //dd($request->all());

    $checkout = Pedidos::where('id', $request->checkout_id)
      ->first();
    //dd(event(new Registered($cliente)));
    $checkout->registro_pedido = $request->registro_pedido;
    $checkout->save();
    event(new Registered($checkout));

    Log::channel('completeLogWebSite')->info('Editou nome do Checkout id: ' . $request->registro_pedido);

    return redirect('/meu-perfil');
  }



  public function delete(Request $request)
  {

    $checkoutProduto = ProdutosPedido::where('pedido_id', $request->id)
      ->delete();
    $checkout = Pedidos::where('id', $request->id)
      ->delete();

    event(new Registered($checkout));

    Log::channel('completeLogWebSite')->info('Excluir Checkout id: ' . $request->id);

    return redirect('/meu-perfil');
  }
}
