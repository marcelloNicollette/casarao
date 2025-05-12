<x-front-layout>
  
  <x-front-header />

  <x-front-sub-header>
    <x-slot:title>
      @if ($currentCategorias != null)
        {{ $currentCategorias->categoria }}    
      @else
        CATEGORIAS
      @endif
      
    </x-slot:title>
    <!--
    @foreach($othersCategorias as $others)
      @php if($currentCategorias != null && $currentCategorias->slug == $others->slug) $active = 'active'; else $active = ''; @endphp
      <div class="swiper-slide">
        <a href="/categorias/{{ $others->slug }}" class="btn btn-primary text-white btn-lg shadow-sm {{ $active }}">{{ $others->categoria }}</a>
      </div>
    @endforeach
    -->
  </x-front-sub-header>
  
  <div class="container">
    <div class="row">
      
      <div class="col-md-3 d-md-block d-none">
        <x-front-filter-tree :familia="json_encode($familia)" :categorias="json_encode($categorias)" />
        <div class="text-primary">Legenda</div>
        <div><img width="40" class="" id="" src="{{ asset('/images/img-ec.jpg') }}" alt=""><span style="font-size: .8rem"> - Escolha Certa Obrigatório</span></div>
        <div><img width="40" class="" id="" src="{{ asset('/images/img-ec-azul.jpg') }}" alt=""><span style="font-size: .8rem"> - Escolha Certa Complementar</span></div>

      </div>
      
      <div class="col-md-9">
        <div class="list-products d-grid my-5 gap-3">
          
          @foreach($products as $product)
            @php $imagem = array(); @endphp
            @foreach($product['cores'] as $cores)
              @php
              if(mb_strlen($cores['codigo_cor']) == 1){
              $codigo_cor = "000".$cores['codigo_cor'];
              }elseif(mb_strlen($cores['codigo_cor']) == 2){
              $codigo_cor = "00".$cores['codigo_cor'];
              }elseif(mb_strlen($cores['codigo_cor']) == 3){
              $codigo_cor = "0".$cores['codigo_cor'];
              }else{
              $codigo_cor = $cores['codigo_cor'];
              }
              $string = str_replace(" ","-",strtolower($product['nome_do_modelo']));
                       $slug = str_replace("(","",$string);
                       $slug = str_replace(")","",$slug);
                       $slug = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç|Ç)/","/(&| )/","/(---)/"),explode(" ","a a e e i i o o u u n n c - -"),$string);
                       $slug = str_replace(".","-",$slug);
              
                array_push($imagem, ['id' => $cores['codigo_cor'], 'image' => 'https://cdn-havaianas-global-4.yapoli.com/'.$product['codigo_4'].'-'.$codigo_cor.'-0.png', 'ec' => $cores['ec']]);
              
              //array_push($imagem, 'https://cdn-havaianas-global-2.yapoli.com/'.$product['codigo_4'].'-'.$slug.'-'.$codigo_cor.'-1.png');
              //array_push($imagem, 'https://cdn-havaianas-global-2.yapoli.com/'.$product['codigo_4'].'-'.$slug.'-'.$codigo_cor.'-2.png');
              @endphp
            @endforeach
           
           @php 
            $filtro = json_encode([$product['segmentacao'], $product['drop'], $product['size_extension'] , $product['familia'] , $product['top_5'] , $product['subcategoria']]); 
            @endphp

            <x-front-product id="{{ $product['id'] }}" categories='<?php echo $filtro; ?>' title="{{ $product['nome_do_modelo'] }}" :images="$imagem" :slug="$product['codigo_4']" />
          @endforeach
          
        </div>
      </div>

    </div>
  </div>

</x-front-layout>