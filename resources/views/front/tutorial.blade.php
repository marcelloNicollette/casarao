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
         <h1>Tutorial
        </h1>
        </div>
      </div>
      <div class="container">
        
        <div class="row justify-content-center">
          <div class="col-10 position-relative">
  
            <div id="slide-home" class="swiper mt-4 mb-2 rounded-4">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="{{ asset('/images/tutorial/INICIO-2.jpg') }}" class="img-fluid" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/images/tutorial/CATEGORIA.jpg') }}" class="img-fluid" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/images/tutorial/PLANOGRAMA_01.jpg') }}" class="img-fluid" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/images/tutorial/PLANOGRAMA_02.jpg') }}" class="img-fluid" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/images/tutorial/PLANOGRAMA_03.jpg') }}" class="img-fluid" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/images/tutorial/PLANOGRAMA_04.jpg') }}" class="img-fluid" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/images/tutorial/ESCOLHA_CERTA_01.jpg') }}" class="img-fluid" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/images/tutorial/PRODUTOS_01.jpg') }}" class="img-fluid" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/images/tutorial/PRODUTOS_02.jpg') }}" class="img-fluid" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/images/tutorial/PRODUTOS_03.jpg') }}" class="img-fluid" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/images/tutorial/PRODUTOS_04.jpg') }}" class="img-fluid" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/images/tutorial/PRODUTOS_05.jpg') }}" class="img-fluid" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/images/tutorial/PRODUTOS_06.jpg') }}" class="img-fluid" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/images/tutorial/PRODUTOS_07.jpg') }}" class="img-fluid" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/images/tutorial/PRODUTOS_08.jpg') }}" class="img-fluid" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/images/tutorial/PRODUTOS_08_2.jpg') }}" class="img-fluid" alt="" />
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('/images/tutorial/PRODUTOS_09.jpg') }}" class="img-fluid" alt="" />
                </div>

              </div>
  
            </div>
  
            <div class="swiper-pagination"></div>
  
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          </div>
        </div>
  
        
      </div>
    </section>

  </x-front-layout>