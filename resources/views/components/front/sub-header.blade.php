<div class="sub-header py-4 shadow-sm">

  <div class="container">
    <div class="row">
      <div class="col-lg-12 d-flex align-items-center gap-2 gap-lg-5 justify-content-between flex-lg-row flex-column">
        <h2 class="fw-bold text-primary">
          {{ $title }}
        </h2>

        <div class="slide-categorias flex-grow-1 position-relative">
          <div id="slide-categorias" class="swiper">
            <div class="swiper-wrapper">
              {{ $slot }}
            </div>
          </div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
        </div>
        <style>
          .estilo{
            color: #e41a18;
    font-size: 20px;
    font-weight: bold;
          }
        </style>
        <div class="estilo">
          Segmentação atual:<br> 
            {{ $segmentacao }}

        </div>
      </div>
    </div>

    <div class="row">
      <div class="icons mt-3">
        @php
            $url_separada = explode('/',$_SERVER["REQUEST_URI"]);
            if(isset($url_separada[2])){
              $url = $url_separada[2];
            }else{
              $url = "";
            }
        @endphp
        <a href="/api/export-xls-categoria/{{ $url }}" target="_blank" class="icon icon-xls gerarPlanilha">gerar planilha</a>
      </div>
    </div>
  </div>

</div>