<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use App\Models\User;
use App\Models\Wishilist;
use App\Models\WishilistProduct;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WishilistController extends Controller
{
    public function lista()
    {
        $user_wishilist = DB::table('wishilist')
            ->where('user_id', Auth::id())
            ->get();
        //dd($user_wishilist);

        $array = array();

        foreach ($user_wishilist as $wishilist) {

            $prod_wishilist = DB::table('wishilist_product')->where('wishilist_id', $wishilist->id)
                ->orderBy('order', 'ASC')->get();

            $array_product = array();
            foreach ($prod_wishilist as $pw) {
                $prod = DB::table('produtos_sync')
                ->where('codigo_4', $pw->codigo_4)
                ->where('codigo_cor', $pw->codigo_cor)
                    ->groupBy('codigo_4')
                    ->first();

                if (mb_strlen($prod->codigo_cor) == 1) {
                    $codigo_cor = "000" . $prod->codigo_cor;
                } elseif (mb_strlen($prod->codigo_cor) == 2) {
                    $codigo_cor = "00" . $prod->codigo_cor;
                } elseif (mb_strlen($prod->codigo_cor) == 3) {
                    $codigo_cor = "0" . $prod->codigo_cor;
                } else {
                    $codigo_cor = $prod->codigo_cor;
                }
                $string = str_replace(" ", "-", strtolower($prod->nome_do_modelo));
                $slug = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç|Ç)/", "/(&| )/", "/(---)/"), explode(" ", "a a e e i i o o u u n n c - -"), $string);
                $slug = str_replace(".", "", $slug);
                $imagem = 'https://cdn-havaianas-global-2.yapoli.com/' . $prod->codigo_4 . '-' . $slug . '-' . $codigo_cor . '-0.png';
                $prod->imagem = $imagem;


                $array_product[] = $prod;
            }
            usort($array_product, fn($a, $b) => $a->subcategoria <=> $b->subcategoria);
            usort($array_product, fn($a, $b) => $b->status <=> $a->status);
            $array[] = [
                'id' => $wishilist->id,
                'name_wishilist' => $wishilist->name_wishilist,
                'wishilist_products' => $array_product
            ];
            //dd($array);
        }


        return response()->json(['wishilist' => $array]);
    }

    public function action(Request $request)
    {

        $wishilist = Wishilist::create([
            'user_id' => Auth::id(),
            'name_wishilist' => $request->name_wishilist
        ]);
        //dd(event(new Registered($cliente)));
        event(new Registered($wishilist));

        \Log::channel('completeLogWebSite')->info('Criação de Wishilist userId ' . Auth::id() . ' lista id: ' . $wishilist->id);

        return $this->lista();
    }

    public function insertProductWishilist(Request $request)
    {
        $wishlist_exist = WishilistProduct::where('wishilist_id', $request->wishilist_id)
        ->where('codigo_4', $request->codigo_4)
        ->where('codigo_cor', $request->codigo_cor)
        ->first();
        if(isset($wishlist_exist)){
            \Log::channel('completeLogWebSite')->info('Produto Duplicado Wishilist codigo 4: ' . $request->codigo_4 . ' lista id: ' . $request->wishilist_id);
        }else{
            $wishilist = WishilistProduct::create([
                'wishilist_id' => $request->wishilist_id,
                'codigo_4' => $request->codigo_4,
                'codigo_cor' => $request->codigo_cor
            ]);
            //dd(event(new Registered($cliente)));
            event(new Registered($wishilist));
    
            \Log::channel('completeLogWebSite')->info('Inclusao de Produto Wishilist codigo 4: ' . $request->codigo_4 . ' lista id: ' . $request->wishilist_id);
        } 

        return $this->lista();
    }

    public function removeProductWishilist(Request $request)
    {

        $wishilist = WishilistProduct::where('wishilist_id', $request->wishilist_id)
            ->where('codigo_4', $request->id)
            ->where('codigo_cor', $request->codigo_cor)
            ->delete();
        //dd(event(new Registered($cliente)));
        event(new Registered($wishilist));

        \Log::channel('completeLogWebSite')->info('Exclusao de Produto Wishilist codigo 4: ' . $request->codigo_4 . ' lista id: ' . $request->wishilist_id);

        return $this->lista();
    }

    public function removeWishilist(Request $request)
    {

        $wishilistProd = WishilistProduct::where('wishilist_id', $request->id)
            ->delete();
        $wishilist = Wishilist::where('id', $request->id)
            ->delete();    
        //dd(event(new Registered($cliente)));
        event(new Registered($wishilistProd));
        event(new Registered($wishilist));

        \Log::channel('completeLogWebSite')->info('Exclusao de Wishilist id: ' . $request->id);

        return redirect('/meu-perfil');
    }

    public function editWishilistName(Request $request)
    {
        //dd($request->all());
        
        $wishilist = Wishilist::where('id', $request->wishilist_id)
            ->first();    
        //dd(event(new Registered($cliente)));
        $wishilist->name_wishilist = $request->name_wishilist; 
        $wishilist->save();
        event(new Registered($wishilist));

        \Log::channel('completeLogWebSite')->info('Editou nome da Wishilist id: ' . $request->wishilist_id);

        return redirect('/meu-perfil');
    }

}
