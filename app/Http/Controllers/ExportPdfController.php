<?php

namespace App\Http\Controllers;

use App\Exports\ExportEscolhaCerta;
use App\Exports\ExportWishilist;
use App\Models\Categoria;
use App\Models\ProdutosSync;
use App\Models\SegmentacaoPreco;
use App\Models\Wishilist;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExportPdfController extends Controller
{
    public $segmentacao;

    public function __construct()
    {
        
        $this->segmentacao = SegmentacaoPreco::get();
        //dd($this->segmentacao);
    }
    /**
     * Display a listing of the resource.
     */
    public function export()
    {   
        //return view('front.planograma');
        $pdf = Pdf::loadView('front.planograma');
        
        //$pdf = Pdf::loadView('front.planograma');
        return $pdf->download('pdf-v.pdf');
    }
 
    public function export_xls(Request $request){ 
        Session::put('wishilist_id', $request->id);

        $wishilist = DB::table('wishilist')
            ->where('user_id', Auth::id())
            ->where('id', Session::get('wishilist_id'))
            ->first();
       
            $string_name = str_replace(" ", "-", strtolower($wishilist->name_wishilist));
            
            $name_wishilist = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç|Ç)/"), explode(" ", "a a e e i i o o u u n n c"), $string_name);
            
            
        return Excel::download(new ExportWishilist($request), $name_wishilist.'.xlsx');
    }

    public function export_xls_escolha($categoria_escolha = null){ 
        foreach($this->segmentacao as $seg){
            $array_seg[$seg->portifolio] = $seg->segmentacao;
            $array_segmentacao[$seg->portifolio] = $seg->segmentacao;
            $array_segmentacao_EC[$seg->portifolio] = explode(",",$seg->ec);
        }
        $array_segmentacao_EC = $array_segmentacao_EC;
        $segmentacao = $array_segmentacao[Session::get('segmentacao')];  
        
        $seg = $array_segmentacao_EC[Session::get('segmentacao')];
            //dd($array_segmentacao_EC[Session::get('segmentacao')]);

        //dd($categoria_escolha);
        //$array_seg = ['atacado' => ['ATACADO'], 'varejo' => ['AS/DIST','ATACADO','VAREJO'], 'as-distribuidor' => ['AS/DIST','ATACADO']];

        $segmentacao = $array_segmentacao[Session::get('segmentacao')];

        $array_segmentacao = [
            'atacado' => ['ec_tradicional','ec_autosservico_p','ec_autosservico_m', 'ec_autosservico_g', 'ec_hipermercado', 'ec_cash_carry'], 
            'varejo' => ['ec_calcadista_p','ec_calcadista_m','ec_calcadista_g', 'ec_departamento', 'ec_long_tail_p', 'ec_long_tail_m', 'ec_long_tail_g'], 
            'as-distribuidor' => ['ec_tradicional','ec_autosservico_p','ec_autosservico_m', 'ec_autosservico_g', 'ec_hipermercado', 'ec_cash_carry']];
        
            $array_segmentacao_nome = [
                'atacado_nacional' => ['EC Tradicional','EC Autosserviço P','EC Autosserviço M', 'EC Autosserviço G', 'EC Hipermercado P', 'EC Cash&Carry'], 
                'atacado_regional' => ['EC Cash&Carry', 'EC Tradicional','EC Autosserviço P','EC Autosserviço M'],
                'distribuidor' => ['EC Autosserviço P','EC Autosserviço M', 'EC Autosserviço G', 'EC Hipermercado P', 'EC Hipermercado M', 'EC Hipermercado G', 'EC Cash&Carry'], 
                'atacado_especializado' => ['EC Calçadista P','EC Calçadista M','EC Calçadista G', 'EC Long Tail'], 
                'as' => ['EC Autosserviço P','EC Autosserviço M', 'EC Autosserviço G', 'EC Hipermercado P', 'EC Hipermercado M', 'EC Hipermercado G'], 
                'c_c' => ['EC Cash&Carry'], 
                'departamento' => ['EC Departamento'], 
                'calcadista' => ['EC Calçadista P','EC Calçadista M','EC Calçadista G', 'EC Long Tail'], 
                'fora_de_linha' => ['EC Tradicional','EC Autosserviço P','EC Autosserviço M', 'EC Autosserviço G', 'EC Hipermercado P', 'EC Hipermercado M', 'EC Hipermercado G', 'EC Cash&Carry', 'EC Calçadista P','EC Calçadista M','EC Calçadista G', 'EC Long Tail']];    
        
        $seg = $array_segmentacao_EC[Session::get('segmentacao')];
            //dd($seg);

        if($categoria_escolha == null){
            $name_wishilist = 'escolha-certa';
        }else{
            $name_wishilist = $categoria_escolha;
        }
        

        $othersCategorias = $array_segmentacao_nome[Session::get('segmentacao')];
        $slug = $categoria_escolha;
        if($categoria_escolha == null){
            $produtos = ProdutosSync::where('segmentacao', 'LIKE', '%'.$segmentacao.'%')
            ->where(function ($query) use ( $seg) {
                foreach ($seg as $s) {
                    $query->orWhere($s, '<>', 'não');
                }
            })
            ->where('status', 1)
            ->groupBy('codigo_4')
            ->orderBy('codigo_4','ASC')
            ->orderBy('codigo_cor','ASC')
            ->orderBy('id','ASC')
            ->toSql();
        }else{
            $produtos = ProdutosSync::where('segmentacao', 'LIKE', '%'.$segmentacao.'%')
            ->where(function ($query) use ( $seg) {
                foreach ($seg as $s) {
                    $query->orWhere($s, '<>', 'não');
                }
            })
            ->where($slug, '<>', 'NÃO')
                
                ->where('status', 1)
            ->groupBy('codigo_4')
            ->orderBy('codigo_4','ASC')
            ->orderBy('codigo_cor','ASC')
            ->orderBy('id','ASC')
            ->toSql();
            //
        }
        dd($produtos);
    $array_produtos = array();    
            
        return Excel::download(new ExportEscolhaCerta($produtos), $name_wishilist.'.xlsx');
    }

    public function export_xls_categoria($categoria = null){ 
        foreach($this->segmentacao as $seg){
            $array_seg[$seg->portifolio] = $seg->segmentacao;
            $array_segmentacao[$seg->portifolio] = $seg->segmentacao;
            $array_segmentacao_EC[$seg->portifolio] = explode(",",$seg->ec);
        }
        $array_segmentacao_EC = $array_segmentacao_EC;
        $segmentacao = $array_segmentacao[Session::get('segmentacao')];  
        
        $seg = $array_segmentacao_EC[Session::get('segmentacao')];
            //dd($array_segmentacao_EC[Session::get('segmentacao')]);

        //dd($categoria_escolha);
        //$array_seg = ['atacado' => ['ATACADO'], 'varejo' => ['AS/DIST','ATACADO','VAREJO'], 'as-distribuidor' => ['AS/DIST','ATACADO']];

        $segmentacao = $array_segmentacao[Session::get('segmentacao')];

        $array_segmentacao = [
            'atacado' => ['ec_tradicional','ec_autosservico_p','ec_autosservico_m', 'ec_autosservico_g', 'ec_hipermercado', 'ec_cash_carry'], 
            'varejo' => ['ec_calcadista_p','ec_calcadista_m','ec_calcadista_g', 'ec_departamento', 'ec_long_tail_p', 'ec_long_tail_m', 'ec_long_tail_g'], 
            'as-distribuidor' => ['ec_tradicional','ec_autosservico_p','ec_autosservico_m', 'ec_autosservico_g', 'ec_hipermercado', 'ec_cash_carry']];
        
            $array_segmentacao_nome = [
                'atacado_nacional' => ['EC Tradicional','EC Autosserviço P','EC Autosserviço M', 'EC Autosserviço G', 'EC Hipermercado P', 'EC Cash&Carry'], 
                'atacado_regional' => ['EC Cash&Carry', 'EC Tradicional','EC Autosserviço P','EC Autosserviço M'],
                'distribuidor' => ['EC Autosserviço P','EC Autosserviço M', 'EC Autosserviço G', 'EC Hipermercado P', 'EC Hipermercado M', 'EC Hipermercado G', 'EC Cash&Carry'], 
                'atacado_especializado' => ['EC Calçadista P','EC Calçadista M','EC Calçadista G', 'EC Long Tail'], 
                'as' => ['EC Autosserviço P','EC Autosserviço M', 'EC Autosserviço G', 'EC Hipermercado P', 'EC Hipermercado M', 'EC Hipermercado G'], 
                'c_c' => ['EC Cash&Carry'], 
                'departamento' => ['EC Departamento'], 
                'calcadista' => ['EC Calçadista P','EC Calçadista M','EC Calçadista G', 'EC Long Tail'], 
                'fora_de_linha' => ['EC Tradicional','EC Autosserviço P','EC Autosserviço M', 'EC Autosserviço G', 'EC Hipermercado P', 'EC Hipermercado M', 'EC Hipermercado G', 'EC Cash&Carry', 'EC Calçadista P','EC Calçadista M','EC Calçadista G', 'EC Long Tail']];    
        
        $seg = $array_segmentacao_EC[Session::get('segmentacao')];
            //dd($seg);

            if($categoria == null){            
                $currentCategorias = null;
                $othersCategorias = Categoria::whereNotNull('id_categoria')->get();
                $produtos = ProdutosSync::where('segmentacao', 'LIKE', '%'.$segmentacao.'%')
                ->where('status', 1)
                ->groupBy('codigo_4')->orderBy('codigo_4','ASC')
                ->orderBy('codigo_cor','ASC')
                ->orderBy('id','ASC')
                ->get();
            }else{                   
                $currentCategorias = Categoria::where('slug', $categoria)->first();
                $othersCategorias = Categoria::where('id_categoria', $currentCategorias->id_categoria)->get();
                //dd($othersCategorias);
                $produtos = ProdutosSync::where('segmentacao', 'LIKE', '%'.$segmentacao.'%')
                ->where('subcategoria', $currentCategorias->categoria)
                ->where('status', 1)
                ->groupBy('codigo_4')
                ->orderBy('codigo_4','ASC')
                ->orderBy('codigo_cor','ASC')
                ->orderBy('id','ASC')
                ->get();
            }
        
        //dd($produtos);
    $array_produtos = array();    
            
        return Excel::download(new ExportEscolhaCerta($produtos), 'listagem.xlsx');
    }
}
