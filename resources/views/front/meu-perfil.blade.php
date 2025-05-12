<x-front-layout>
  <x-slot:addclass>bg-white</x-slot:addclass>
  <x-front-header />

  <div class="container">

    <div class="row mt-4">
      <div class="col-md-12">
        <h1 class="text-primary text-center fw-bold">Lista de Favoritos</h1>
      </div>
    </div>

    <div class="row mt-4 mb-5 justify-content-center">
      <div class="col-md-8">

        <div class="accordion" id="accordionPanelsStayOpenExample">
 
          @for ($i = 0; $i < count($wishilists); $i++)
          <div class="accordion-item">
            <h2 class="accordion-header row">
              <button class="accordion-button collapsed col-8" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-{{$i}}" aria-expanded="true" aria-controls="panelsStayOpen-collapse-{{$i}}">
                {{ $wishilists[$i]['name_wishilist'] }}
              </button>
              <a href="#" data-id="{{ $wishilists[$i]['id'] }}" class="col-1" data-bs-toggle="modal" data-bs-target="#modalUpdateNameWishilist-{{ $wishilists[$i]['id'] }}"><i class="icon feather icon-edit"></i></a>
              <a href="/api/wishilist/remove/{{ $wishilists[$i]['id'] }}" class="col-1"><i class="icon feather icon-x-circle"></i></a>
            </h2>
            <div id="modalUpdateNameWishilist-{{ $wishilists[$i]['id'] }}" class="modal modal-{{ $wishilists[$i]['id'] }}" tabindex="-1">
              <div class="modal-dialog">
                <form method="POST" action="{{ route('api.wishilist.editWishilistName') }}" >
                  {{ csrf_field() }}
                  <input type="hidden" name="wishilist_id" value="{{ $wishilists[$i]['id'] }}">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Atualizar nome de Favorito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <input name="name_wishilist" type="text" class="form-control" value="{{ $wishilists[$i]['name_wishilist'] }}" />
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                  </div>
                </div>
                </form>
              </div>
            </div>
            <div id="panelsStayOpen-collapse-{{$i}}" class="accordion-collapse collapse">
              <div class="accordion-body">
                <div class="list-products d-grid my-5 gap-3">
                @foreach($wishilists[$i]->wishilistProducts as $product)
                  @php $imagem = array();
                        $prod = \App\Models\ProdutosSync::where('codigo_4', $product['codigo_4'])
                              ->where('codigo_cor', $product['codigo_cor'])
                              ->groupBy('codigo_4')->first(); 
                            
                    if(mb_strlen($prod['codigo_cor']) == 1){
                    $codigo_cor = "000".$prod['codigo_cor'];
                    }elseif(mb_strlen($prod['codigo_cor']) == 2){
                    $codigo_cor = "00".$prod['codigo_cor'];
                    }elseif(mb_strlen($prod['codigo_cor']) == 3){
                    $codigo_cor = "0".$prod['codigo_cor'];
                    }else{
                    $codigo_cor = $prod['codigo_cor'];
                    }
                    $string = str_replace(" ","-",strtolower($prod['nome_do_modelo']));
                    $slug = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç|Ç)/","/(&| )/","/(---)/"),explode(" ","a a e e i i o o u u n n c - -"),$string);
                    $slug = str_replace(".","",$slug);

                    if($prod['ec_calcadista_p'] != 'NÃO' || $prod['ec_calcadista_m'] != 'NÃO' || $prod['ec_calcadista_g'] != 'NÃO' || $prod['ec_departamento'] != 'NÃO' || $prod['ec_long_tail_p'] != 'NÃO' || $prod['ec_long_tail_m'] != 'NÃO' || $prod['ec_long_tail_g'] != 'NÃO' || $prod['ec_tradicional'] != 'NÃO' || $prod['ec_autosservico_p'] != 'NÃO' || $prod['ec_autosservico_m'] != 'NÃO' || $prod['ec_autosservico_g'] != 'NÃO' || $prod['ec_hipermercado'] != 'NÃO' || $prod['ec_cash_carry'] != 'NÃO'){
                      $ec = 1;
                    }else{
                      $ec = 0;
                    }

                    array_push($imagem, ['id' => $prod['codigo_cor'], 'image' => 'https://cdn-havaianas-global-2.yapoli.com/'.$prod['codigo_4'].'-'.$slug.'-'.$codigo_cor.'-0.png', 'ec' => $ec]);
                    
                    
                    @endphp
                  
                
                  @php 
                    $filtro = json_encode([]); 
                  @endphp

                  <x-front.clear-product id="{{ $prod['id'] }}" categories='<?php echo $filtro; ?>' title="{{ $prod['nome_do_modelo'] }}" :images="$imagem" :slug="$prod['codigo_4']" />
                @endforeach

                </div>
              </div>
            </div>
          </div>
          @endfor

      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-12">
        <h1 class="text-primary text-center fw-bold">Pré-pedidos</h1>
      </div>
    </div>

    <link rel="stylesheet" href="/assets/fonts/feather-font/css/iconfont.css">
    
    <style>
    .accordion-header{
      margin-left: 0;
    }
    .accordion-button{
      width: 82%;
    }
    .accordion-header a{
      text-decoration: none;
      margin-top: 7px;
      text-align: center;
    }
    </style>

    <div class="row mt-4 mb-5 justify-content-center">
      <div class="col-md-8">

        <div class="accordion" id="accordionPanelsStayOpenExample">
 
          @for ($i = 0; $i < count($checkouts); $i++)
          <div class="accordion-item">
            <h2 class="accordion-header row">
              <button class="accordion-button collapsed col-8" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpenW-collapse-{{$i}}" aria-expanded="true" aria-controls="panelsStayOpenW-collapse-{{$i}}">
                {{ $checkouts[$i]['registro_pedido'] }}
              </button>
              <a href="#" data-id="{{ $checkouts[$i]['id'] }}" class="col-1" data-bs-toggle="modal" data-bs-target="#modalUpdateNameCheckout-{{ $checkouts[$i]['id'] }}"><i class="icon feather icon-edit"></i></a>
              <a href="/api/pedidos/remover/{{ $checkouts[$i]['id'] }}" class="col-1"><i class="icon feather icon-x-circle"></i></a>
            </h2>

            <div id="modalUpdateNameCheckout-{{ $checkouts[$i]['id'] }}" class="modal modal-{{ $checkouts[$i]['id'] }}" tabindex="-1">
              <div class="modal-dialog">
                <form method="POST" action="{{ route('api.pedidos.editCheckoutName') }}" >
                  {{ csrf_field() }}
                  <input type="hidden" name="checkout_id" value="{{ $checkouts[$i]['id'] }}">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Atualizar nome do Checkout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <input name="registro_pedido" type="text" class="form-control" value="{{ $checkouts[$i]['registro_pedido'] }}" />
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                  </div>
                </div>
                </form>
              </div>
            </div>
            <div id="panelsStayOpenW-collapse-{{$i}}" class="accordion-collapse collapse">
              <div class="accordion-body">
                <div class="item-content">
                @php $list_produtos_pedido = DB::table('produtos_pedido')->where('pedido_id', $checkouts[$i]['id'])->get();
                  //dd($list_produtos_pedido);
                  foreach ($list_produtos_pedido as $value) {
                    $produto_pedido = DB::table('produtos_sync')
                    ->where('codigo_4', $value->codigo_4)
                    ->where('codigo_cor', $value->cor_id)->first();
                    //dd($produto_pedido);

                    if(mb_strlen($value->cor_id) == 1){
                        $codigo_cor = "000".$value->cor_id;
                       }elseif(mb_strlen($value->cor_id) == 2){
                        $codigo_cor = "00".$value->cor_id;
                       }elseif(mb_strlen($value->cor_id) == 3){
                        $codigo_cor = "0".$value->cor_id;
                       }else{
                        $codigo_cor = $value->cor_id;
                       }
                       $string = str_replace(" ","-",strtolower($produto_pedido->nome_do_modelo));
                       $slug = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç|Ç)/","/(&| )/","/(---)/"),explode(" ","a a e e i i o o u u n n c - -"),$string);
                       $slug = str_replace(".","-",$slug);
                       
                       $imagem = 'https://cdn-havaianas-global-2.yapoli.com/'.$produto_pedido->codigo_4.'-'.$slug.'-'.$codigo_cor.'-0.png';   


                    echo '<div class="content">
                  <img src="'.$imagem.'" class="img-product" alt="'.$produto_pedido->nome_do_modelo.'" />
                  <div class="title">'.$produto_pedido->nome_do_modelo.'
                    <div class="grid">
                      <div class="title-grid title-grid-cor">Cor: '.$produto_pedido->descricao_da_cor.'</div>
                    </div>
                  </div>        
                  <div class="grid">
                    <div class="title-grid">'.$value->tipo_caixa.'</div>
                    <div class="show-grid">'.$value->numeracao_grade.'</div>
                  </div>
                  <div class="grid">
                    <div class="title-grid">Mês</div>
                    <div class="show-grid">'.$value->mes.'</div>
                  </div>
                </div>
                <div class="dados">
                  <input type="text" placeholder="QUANTIDADE" class="form-control" value="Quantidade:'.$value->qtd.'" disabled />                  
                </div>';

                  }
                @endphp
                </div>
              </div>
            </div>
          </div>
          @endfor

      </div>
    </div>
    

  </div>
  </div>

</x-front-layout>