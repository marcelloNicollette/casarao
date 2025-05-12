<?php

namespace App\Http\Controllers;

use App\Models\Ajuda;
use App\Models\Categoria;
use App\Models\Pedidos;
use App\Models\Precos;
use App\Models\ProdutosSync;
use App\Models\SegmentacaoPreco;
use App\Models\Wishilist;
use App\Models\Comunicados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Services\YapoliServices;
use App\Models\Cliente;
use App\Models\Colaborador;
use App\Models\PriceTable;
use App\Models\ProductPrice;
use App\Models\WishilistProduct;
use Illuminate\Support\Facades\Hash;

class FrontendController extends Controller
{

    public $currentUser;

    public function __construct()
    {

        $this->currentUser = Auth::user();
        //dd($this->currentUser);
    }

    //
    public function dashboard()
    {
        $colaborador = Colaborador::select('id')->where('email', $this->currentUser->email)->first();

        $clientes = Cliente::where('colaborador_id', $colaborador->id)->get();
        //dd($clientes);
        return view('front.clientes', ['clientes' => $clientes]);
    }

    public function setCliente(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id'
        ]);

        Session::put('cliente_id', $request->cliente_id);

        //return redirect()->back()->with('success', 'Cliente selecionado com sucesso!');
        return redirect(route('colaborador.produtos'));
    }

    public function produtos()
    {
        $cliente_id = session('cliente_id');
        $cliente = Cliente::with('price_tables')->find($cliente_id);

        $produtos = PriceTable::with(['products' => function ($query) {
            $query->orderBy('title', 'asc');
        }])->find($cliente->price_tables->id);
        //dd($produtos);
        return view('front.produtos', ['produtos' => $produtos, 'cliente' => $cliente]);
    }


    public function perfilUser()
    {

        $wishilists = Wishilist::where('user_id', Auth::id())->get();
        $checkouts = Pedidos::where('user_id', Auth::id())->get();
        //dd($checkouts);
        return view('front.meu-perfil', ['wishilists' => $wishilists, 'checkouts' => $checkouts]);
    }

    public function favoritos()
    {

        $wishilists = Wishilist::where('user_id', Auth::id())->get();
        //dd($checkouts);
        return view('front.meus-favoritos', ['wishilists' => $wishilists]);
    }

    public function order_whislist(Request $request)
    {

        $orders = $request->order;

        for ($i = 0; $i < count($orders); $i++) {
            $wishi = WishilistProduct::find($orders[$i]);
            //dd($wishi);
            $wishi->order = $i + 1;
            $wishi->save();
        }

        return response()->json([
            "status" => true,
            "msg" =>  "ordens atualizadas",
        ]);
    }
}
