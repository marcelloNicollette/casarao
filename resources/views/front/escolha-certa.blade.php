<x-front-layout>
  <x-front-header />

  <x-front-sub-header>
    <x-slot:title>
      Escolha Certa
    </x-slot:title>
    
  </x-front-sub-header>
  
  <div class="container">
    <div class="row">
      
      <div class="col-md-3 d-md-block d-none">
        <x-front-filter-tree-escolha-certa :familia="json_encode($familia)" :categorias="json_encode($othersCategorias)" />
      </div>

      <div class="col-md-9">
        <div class="list-products list-products-full d-grid my-5 gap-3">
          
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
            $slug = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç|Ç)/","/(&| )/","/(---)/"),explode(" ","a a e e i i o o u u n n c - -"),$string);
            $slug = str_replace(".","",$slug);
            array_push($imagem, ['id' => $cores['codigo_cor'], 'image' => 'https://cdn-havaianas-global-2.yapoli.com/'.$product['codigo_4'].'-'.$slug.'-'.$codigo_cor.'-0.png', 'ec' => $cores['ec']]);
            //array_push($imagem, 'https://cdn-havaianas-global-2.yapoli.com/'.$product['codigo_4'].'-'.$slug.'-'.$codigo_cor.'-1.png');
            //array_push($imagem, 'https://cdn-havaianas-global-2.yapoli.com/'.$product['codigo_4'].'-'.$slug.'-'.$codigo_cor.'-2.png');
            
            @endphp
          @endforeach

          @php 
            $filtro = json_encode([$product['segmentacao'], $product['drop'], $product['size_extension'] , strtoupper($product['familia']) , $product['top_5'] , strtoupper($product['subcategoria'])]); 
            @endphp
          
          <x-front-product id="{{ $product['id'] }}" categories="<?php echo $filtro; ?>" title="{{ $product['nome_do_modelo'] }}" :images="$imagem" :slug="$product['codigo_4']" />
        @endforeach

        </div>
      </div>

    </div>
  </div>

</x-front-layout>