<x-front-layout>
  <x-slot:addclass>bg-red</x-slot:addclass>
  <x-front-header />

  <section id="show-product" class="py-5">
    <div class="container">
      <div class="row">

        <div class="col-lg-6">

          <div class="slide-images p-5 rounded-5 position-relative bg-white">
            <div class="position-absolute top-0 start-0 p-4 dropdown">
              <button type="button" class="btn btn-primary fw-bold text-white btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">?</button>
              <div class="dropdown-menu p-3">
                <p><b class="text-primary">Caixa Grade:</b> tipo de caixa que contém pares de mais de uma numeração dentro.</p>
                <p><b class="text-primary">Caixa Fechada:</b> tipo de caixa que possui pares de apenas uma numeração dentro.</p>
              </div>
            </div>

            <div class="bg-white rounded-5 price-content position-absolute top-0 end-0 p-4 d-flex flex-column gap-1 align-items-end">
              @php
                  if($products['cores'][0]['ec'] == 0){
                    $class = "invisible";
                    $img = "/images/img-ec-azul.jpg";
                    echo '<img class="'.$class.'" id="imgEC" src="'.asset($img).'" alt="">';
                  }elseif($products['cores'][0]['ec'] == 2){
                    $class = "";
                    $img = "/images/img-ec-azul.jpg";
                    echo '<img class="'.$class.'" id="imgEC" src="'.asset($img).'" alt="">';
                  }else{
                    $class = "";
                    $img  = "/images/img-ec.jpg";
                    echo '<img class="'.$class.'" id="imgEC" src="'.asset($img).'" alt="">';
                  }
              @endphp
              
              
              <!--<h5 class="text-primary fw-bold">R$39,99</h5>-->
            </div>

            <div class="images-product position-relative">
              <div class="swiper-one-product swiper">
                <div class="swiper-wrapper">

                  @php
                  $imgs = json_decode($products['cores'][0]['imagens']);
                  $firstImage = null;
                  @endphp
                  @foreach($imgs as $img)
                  @php if ($firstImage == null) $firstImage = $img; @endphp
                  <div class="swiper-slide">
                    <img src="{{ $img }}" class="img-fluid" alt="" />
                  </div>
                  @endforeach

                </div>
              </div>

              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>

              <div class="legenda fw-normal text-center mt-3">{{ $products['cores'][0]['codigo_cor'] }} - {{ $products['cores'][0]['descricao_cor'] }}</div>
            </div>

          </div>

          <div thumbsSlider="" class="swiper-one-product-thumb swiper">
            <div class="swiper-wrapper">
              @php
              $imgs = json_decode($products['cores'][0]['imagens']);
              @endphp
              @foreach($imgs as $img)
              <div class="swiper-slide">
                <div class="content-thumb">
                  <img src="{{ $img }}" class="img-fluid" alt="" />
                </div>
              </div>
              @endforeach

            </div>
          </div>

        </div>

        <div class="col-lg-6 position-relative">
          <div>
            Segmentação atual: {{ Session::get('segmentacao') }}
            
          </div>
          <div class="dropdown">
            @if(Session::get('segmentacao') != 'fora-de-linha')
            <button class="btn btn-link text-primary text-left p-0 btn-favorite position-absolute end-0 dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" style="top: -30px;">adicionar aos favoritos</button>
            @endif
            <div class="dropdown-menu p-1">
              <form class="form-add-favorite content-dropdown mh-100 p-2 d-flex flex-column">
                <h6 class="text-primary fw-bold">Selecione a lista de favoritos</h6>
                <select class="select-favorites form-select mt-2" aria-label="Selecione a lista de favoritos">
                  <option value="" selected>Lista de favoritos</option>
                </select>

                <h6 class="text-primary fw-bold mt-2">Ou crie uma nova</h6>

                <div class="list-footer d-flex gap-2">
                  <input type="text" placeholder="Nome da nova lista" name="name-new-favorite" class="form-control name-new-favorite">
                  <button type="button" class="btn btn-primary text-white btn-sm create-favorite">Criar</button>
                </div>

                <div class="list-footer d-flex gap-2 mt-2">
                  <button type="button" class="btn btn-primary text-white btn-sm add-favorite w-100">Adicionar aos favoritos</button>
                </div>
                <input type="hidden" name="id" value="{{ $products['codigo_4'] }}">
                <input type="hidden" name="id_color" value="{{ $products['cores'][0]['codigo_cor'] }}">
                <input type="hidden" name="title" value="{{ $products['nome_do_modelo'] }}">
                <input type="hidden" name="image" value="{{ $firstImage }}">
              </form>
            </div>
          </div>
          <h2 class="mb-0 fw-bold purple">{{ $products['codigo_4'] }} - {{ $products['nome_do_modelo'] }}</h2>
          <h6 class="fw-bold mb-3 purple">{{ $products['categoria'] }}/{{ $products['subcategoria'] }}</h6>

          <h4 class="collapse-title fw-bold text-primary" data-bs-toggle="collapse" href="#collapseCores" role="button" aria-expanded="false" aria-controls="collapseCores">Cores</h4>
          <div class="content-cores collapse show" id="collapseCores">
            <div class="list-cores d-flex gap-1">
              @php $i = 0; @endphp
              @foreach($products['cores'] as $idInfo => $cor)

              @php
                foreach ($products['cores'][$idInfo]['tipo_caixa'] as $key => $value) {
                  if ($value['tipo_caixa'] == 'CAIXA FECHADA' || $value['tipo_caixa'] == 'caixa fechada') {
                  $caixaFechada = json_encode($value['grade_numeracao']);
                  //$caixaGrade = json_encode([]);
                  $caixaGrade = ($value['grade_numeracao']) ? json_encode($value['grade_numeracao']) : json_encode([]);
                  }else{
                  //$caixaFechada = json_encode([]);
                  $caixaGrade = ($value['grade_numeracao']) ? json_encode($value['grade_numeracao']) : null;
                  }
                }
                
              @endphp
              <style>.cor{
                position: relative;
              }
              </style>
              <div class="cor rounded-2 bg-white @if($i == 0) active @endif p-2" data-colorhex="#000" data-price="R$ 39,99" data-id="{{ $cor['codigo_cor'] }}" data-title="{{ $products['nome_do_modelo'] }}" data-cor="{{ $cor['descricao_cor'] }}" data-images="{{ $cor['imagens'] }}" data-caixafechada="{{ $caixaFechada }}" data-caixagrade="{{ $caixaGrade }}" data-ec="{{ $cor['ec'] }}">
                @php $img = json_decode($cor['imagens']); 
                
                if($cor['ec'] == 1){
                  echo '<img src="/assets/images/star.png" alt="" style="position: absolute; top:-10px; right:5px;" />';
                }
                @endphp
                
                <img src="{{ $img[0] }}" class="img-fluid" alt="" />
              </div>
              @php $i++; @endphp
              @endforeach
 
            </div>
          </div>
          <style>
            #dtHorizontalExample {
              display: block;
              overflow-x: auto;
              --bs-table-bg: transparent;
            }

            #dtHorizontalExample th,
            td {
              white-space: nowrap;
            }

            #dtHorizontalExample td {
              font-size: 14px;
              text-align: left;
              padding: 10px;
            }
          </style>
          
          @if(Session::get('segmentacao') != 'fora_de_linha')
          <div class="col-lg-12">
            <h4 class="fw-bold text-primary mt-4">Preço PDV Sugerido</h4>
            <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm collapse show" cellspacing="0" width="100%">
              <tr>
                            
                  <td class="" align="center" valign="middle">
                    
                    @if ($products['tem_size_extension'] == 'SIM' || $products['tem_size_extension'] == 'Sim' || $products['tem_size_extension'] == 'YES' || $products['tem_size_extension'] == 'Yes')
                    {{ $products['valores'][0]['classificacao'] }}: R$ {{ $products['valores'][0][Session::get('segmentacao')] }}<br>
                    {{ $products['valores'][1]['classificacao'] }}: R$ {{ $products['valores'][1][Session::get('segmentacao')] }}
                    @else
                    R$ {{ $products['valores'][0][Session::get('segmentacao')] }}
                    @endif
                  </td>
                  
              </tr>

            </table>

          </div>

          @endif

          <form method="POST" id="form-add-checkout" class="content-dropdown mh-100 d-flex flex-column @if(Session::get('segmentacao') == 'fora_de_linha') d-none @endif">

            <h4 class="collapse-title fw-bold text-primary mt-4" data-bs-toggle="collapse" href="#collapseGrades" role="button" aria-expanded="false" aria-controls="collapseGrades">Grades</h4>
            <div class="content-grades collapse show" id="collapseGrades">
              <div class="d-flex gap-2 tipo-caixa">
                <a href="#" class="btn btn-caixa btn-primary btn-sm text-white fw-bold" data-bs-toggle="collapse" data-bs-target="#content1" aria-expanded="true">Caixa Fechada</a>
                <a href="#" class="btn btn-caixa btn-primary btn-sm text-white fw-bold collapsed" data-bs-toggle="collapse" data-bs-target="#content2" aria-expanded="false">Caixa Grade</a>
              </div>
              <div style="text-align:right; font-size:12px;">
                <p class="text-right">Digite o plano de volume em <b>caixas</b></p>
              </div>
              <div class="content-grade bg-white rounded-2 mt-3 p-3">
                <div class="collapse show" id="content1" data-bs-parent=".content-grades">
                  <div class="table-responsive">

                  </div>
                </div>
                <div class="collapse" id="content2" data-bs-parent=".content-grades">
                  <div class="table-responsive">

                  </div>
                </div>

              </div>
            </div>

            <input type="hidden" name="id" value="{{ $products['codigo_4'] }}">
            <input type="hidden" name="title" value="{{ $products['nome_do_modelo'] }}">
            <input type="hidden" name="descricao_de_marketing" value="{{ $products['descricao_de_marketing'] }}">
            <input type="hidden" name="color" value="{{ $products['cores'][0]['descricao_cor'] }}">
            <input type="hidden" name="id_color" value="{{ $products['cores'][0]['codigo_cor'] }}">
            <input type="hidden" name="colorHex" value="#000">
            <input type="hidden" name="caixaOption" value="Caixa Fechada">
            <input type="hidden" name="caixaSelecionada" value="?">
            <input type="hidden" name="quantidade" value="0">
            <input type="hidden" name="tamanho" value="?">
            <input type="hidden" name="image" value="{{ $firstImage }}">

            <div class="d-flex justify-content-end gap-2 mt-4">
              <a href="{{ url('/ajuda') }}" class="btn btn-primary text-white fw-bold">PRECISA DE AJUDA?</a>
              <a id="btn-prepedido" class="btn btn-primary text-white fw-bold btn-prePedido">ADICIONAR PRÉ-PEDIDO</a>
            </div>

          </form>

          <div class="content-description mt-4">
            @if(Session::get('segmentacao') != 'fora_de_linha')
            <p><b>Abertura de Carteira: {{ $products['X_factory'] }}</b></p>
            @endif
            <h6 class="fw-bold">Descrição de marketing</h6>
            <p>{{ $products['descricao_de_marketing'] }}</p>
          </div>

        </div>

      </div>
    </div>
  </section>

</x-front-layout>
<script>


</script>