<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Exports\ExportChechout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
  public function pdfCheckout(Request $request)
  {
    if (isset($request->content)) {
      $pdf = Pdf::loadView('front.export.pdf-checkout', ['content' => $request->content]);
      return $pdf->download('checkout.pdf');
    } else {
      return response()->view('errors.' . '500', [], 500);
    }
  }

  public function viewPdf()
  {
   
    
      $wishilist = DB::table('wishilist')
            ->where('id', 6)
            ->first();
            
            $string_name = str_replace(" ", "-", strtolower($wishilist->name_wishilist));
            
            $name_wishilist = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç|Ç)/"), explode(" ", "a a e e i i o o u u n n c"), $string_name);

      //$pdf = Pdf::loadView('front.export.pdf-wishlist', ['content' => $request->content, 'title' => $wishilist->name_wishilist]);
      
      return view('front.export.pdf-wishlist', ['content' => [], 'title' => $wishilist->name_wishilist]);
      
            
      //return $pdf->download($name_wishilist.'.pdf');
   
  }

  public function pdfWishlist(Request $request)
  {
    if (isset($request->content)) { 
      
      $wishilist = DB::table('wishilist')
            ->where('id', $request->whislist_id)
            ->first();
            
            $string_name = str_replace(" ", "-", strtolower($wishilist->name_wishilist));
            
            $name_wishilist = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç|Ç)/"), explode(" ", "a a e e i i o o u u n n c"), $string_name);

      $pdf = Pdf::loadView('front.export.pdf-wishlist', ['content' => $request->content, 'title' => $wishilist->name_wishilist]);
       
      
            
      return $pdf->download($name_wishilist.'.pdf');
    } else {
      return response()->view('errors.' . '500', [], 500);
    }
  }

  public function pdfWishlistGet($id)
  {
    
    if (isset($id)) { 
      
      $wishilist = DB::table('wishilist')
            ->where('id', $id)
            ->first();
            
            $string_name = str_replace(" ", "-", strtolower($wishilist->name_wishilist));
            
            $name_wishilist = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç|Ç)/"), explode(" ", "a a e e i i o o u u n n c"), $string_name);

              $prod_wishilist = DB::table('wishilist_product')->where('wishilist_id', $id)
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
                  $imagem = 'https://cdn-havaianas-global-4.yapoli.com/' . $prod->codigo_4 . '-'. '-' . $codigo_cor . '-0.png';
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
          
              
      $pdf = Pdf::loadView('front.export.pdf-wishlist-get', ['content' => $array_product, 'title' => $wishilist->name_wishilist]);
       
      
            
      return $pdf->download($name_wishilist.'.pdf');
    } else {
      return response()->view('errors.' . '500', [], 500);
    }
  }

  public function pdfPlanograma(Request $request)
  {
    if (isset($request->content) && isset($request->planograma) ) {
      //return response()->view('front.export.pdf-planograma',  ['content' => $request->content, 'planograma' => $request->planograma]);
      
      $wishilist = DB::table('wishilist')
            ->where('id', $request->wishlist_id)
            ->first();
            
            $string_name = str_replace(" ", "-", strtolower($wishilist->name_wishilist));
            
            $name_wishilist = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç|Ç)/"), explode(" ", "a a e e i i o o u u n n c"), $string_name);

      $pdf = Pdf::loadView('front.export.pdf-planograma', ['content' => $request->content, 'planograma' => $request->planograma, 'title' => $name_wishilist]);
      return $pdf->download('planograma.pdf');
    } else {
      return response()->view('errors.500');
    }
  }

  public function xlsCheckout()
  {
    if (Session::get('checkout_id') != null) {
      return Excel::download(new ExportChechout(), 'checkout.xlsx');
    } else {
      return response()->view('errors.500');
    }
  }

              
  
}
