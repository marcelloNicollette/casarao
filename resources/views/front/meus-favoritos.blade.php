<x-front-layout>
  <x-slot:addclass>bg-white</x-slot:addclass>
  <x-front-header />

<style>
  .ui-state-default{
    cursor: move;
  }
  ul.d-flex.flex-wrap{
    display: flex;
  }
  ul.post_list_ul li{
    border: 1px solid #CCC;
    list-style: none;
    padding: 1rem;
    text-align: center;
    width: 170px;
  }
  .bg-red{
    opacity: .2
  }
  .icon-pdf, .icon-xls{
    font-size: 15px;
    vertical-align: super;
  }
  .col-2.icon{
    padding-top: 0.7rem;
  }
</style>

  <div class="container">

    <div class="row mt-4">
      <div class="col-md-12">
        <h1 class="text-primary text-center fw-bold">Meus Favoritos</h1>
        <p class="text-center">para mudar a ordem dos produtos, entre na listagem e arraste para onde quiser</p>
      </div>
    </div>

    <div class="row mt-4 mb-5 justify-content-center">
      <div class="col-md-8">

        <div class="accordion" id="accordionPanelsStayOpenExample">
 
          @for ($i = 0; $i < count($wishilists); $i++)
          <div class="accordion-item">
            <h2 class="accordion-header row icons">
              <button class="accordion-button collapsed col-6" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-{{$i}}" aria-expanded="true" aria-controls="panelsStayOpen-collapse-{{$i}}">
                {{ $wishilists[$i]['name_wishilist'] }}
              </button>
              <div class="col-2 icon icons">
                <!--<a href="#" class="icon icon-xls">gerar planilha</a>-->
                <a href="/api/export/pdf/wishlist/{{ $wishilists[$i]['id'] }}" id="gerar_pdf_sacola" class="icon icon-pdf">gerar pdf</a>
              </div>

              <div class="col-2 icon icons">
                <!--<a href="#" class="icon icon-xls">gerar planilha</a>-->
                <a href="/api/export-xls/{{ $wishilists[$i]['id'] }}" id="gerar_pdf_sacola" class="icon icon-xls">gerar xls</a>
              </div>

              
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
                <div class="list-products my-5 gap-3" data-wishilist="{{ $wishilists[$i]['id'] }}">
                  <ul id="post_sortable" class="post_list_ul d-flex flex-wrap" data-wishilist="{{ $wishilists[$i]['id'] }}">
                    
                @foreach($wishilists[$i]->wishilistIdProducts($wishilists[$i]['id']) as $product)
                  @php $imagem = array();
                        $prod = $wishilists[$i]->wishilistProductsOrder($wishilists[$i]->id, $product['codigo_cor']); 
                            
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
                    $filtro = json_encode([$prod['segmentacao'], $prod['drop'], $prod['size_extension'] , $prod['familia'] , $prod['top_5']]); 

                    if($prod['status'] == 0){
                      $css = 'bg-red';
                    }else{
                      $css = '';
                    }
                  @endphp
                  
                  <li class="ui-state-default {{ $css }}" data-id="{{ $prod['id'] }}" data-wish_id="{{ $product['id'] }}" data-wishilist="{{ $wishilists[$i]['id'] }}">
                    <span><img style="height: 100px;" src="<?php echo 'https://cdn-havaianas-global-2.yapoli.com/'.$prod['codigo_4'].'-'.$slug.'-'.$codigo_cor.'-0.png'; ?>" alt=""></span>
                    <span>{{ $prod['nome_do_modelo'] }}</span>

                    @if($prod['status'] == 0)
                    <br><span><b>produto - inativo</b></span>
                    @endif
                  </li>

                @endforeach
                  </ul>
                </div>
              </div>
            </div>
          </div>
          @endfor

      </div>
    </div>

    

    <link rel="stylesheet" href="/assets/fonts/feather-font/css/iconfont.css">
    
    <style>
    .accordion-header{
      margin-left: 0;
    }
    .accordion-button{
      width: 50%;
    }
    .accordion-header a{
      text-decoration: none;
      margin-top: 7px;
      text-align: center;
    }
    </style>
    
  </div>

  @section('scripts')
  <script>
    $(document).ready(function() {
        $(".post_list_ul ").sortable({
            placeholder: "ui-state-highlight",
            update: function(event, ui) {
                //var data = $(this).sortable('toArray');
              var wishilist_id = $(this).parent(".list-products").data("wishilist");
              
                var post_order_ids = new Array();
                var wishilist_order_ids = new Array();
                $('#post_sortable li').each(function() {
                  if(wishilist_id == $(this).data("wishilist")){    
                    post_order_ids.push($(this).data('wish_id'));
                    wishilist_order_ids.push($(this).data("wishilist"));
                  }
                    
                });
  
                $.ajax({
                    type: "POST",
                    url: "{{ route('front.order-whislist') }}",
                    dataType: "json",
                    data: {
                        order: post_order_ids,
                        wishilist_id: wishilist_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        $('#post_sortable li').each(function(index) {
                            $(this).find('.pos_num').text(index + 1);
  
                            //console.log(index);
                        });
  
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });
  </script>
    
    @endsection
  
</x-front-layout>
