<x-front-layout>
  <x-front-header />
<style>
  .row_segmentacao{
    background: #fffef9;
    box-shadow: 0px 3px 5px #EEE;
  }
  .row_segmentacao img {
    float: left;
    padding: .5rem 1rem .5rem 5rem;
  }
  .row_segmentacao h1{
    color: #e41a18;
    font-size: 25px;
    padding: 1rem 1rem .5rem 5rem;
    font-weight: bold;
  }
</style>
  <section id="home-slide">
    <div class="row">
      <div class="col-12 row_segmentacao">
        <img src="/images/icone-chinelo.jpg">
       <h1>Segmentação atual: 
        @if(Session::get('segmentacao') == 'varejo')
          VAREJO
        @elseif(Session::get('segmentacao') == 'atacado')
          ATACADO
        @else
          AS/ Distribuidor
        @endif
      </h1>
      </div>
    </div>
    <div class="container">
      
      <div class="row justify-content-center">
        <div class="col-10 position-relative">

          <div id="slide-home" class="swiper mt-4 mb-2 rounded-4">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <img src="{{ asset('/images/slide/HAVAIANAS_V2.jpg') }}" class="img-fluid" alt="" />
              </div>
              <div class="swiper-slide">
                <img src="{{ asset('/images/slide/img-slide-1.jpg') }}" class="img-fluid" alt="" />
              </div>
            </div>

          </div>

          <div class="swiper-pagination"></div>

          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">

          <div class="d-flex flex-column align-items-center">
            <!--<div class="d-grid gap-2 d-md-block mt-4">
              @foreach($categorias as $cat)
              <a href="/categoria/{{ str_replace(' ','-',strtolower($cat->categoria)) }}" class="btn btn-primary fw-bold text-white btn-lg text-uppercase">{{ $cat->categoria }}</a>
              @endforeach
            </div>-->
            <!--<div class="d-grid gap-2 d-md-block mt-4">
              <a href="/categorias/core" class="btn btn-primary fw-bold text-white btn-lg text-uppercase">Chinelos</a>
              <a href="/categorias/beyond-core" class="btn btn-primary fw-bold text-white btn-lg text-uppercase">Novas Categorias</a>-->
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </section>



</x-front-layout>