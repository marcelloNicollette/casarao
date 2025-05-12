<x-front-layout>
  <x-slot:addclass>bg-white</x-slot:addclass>
  <x-front-header />

  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <img src="{{ asset('images/img-topo-ajuda.jpg') }}" class="img-fluid" alt="Ajuda" />
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-12">
        <h1 class="text-primary text-center fw-bold">Ajuda</h1>
      </div>
    </div>

    <div class="row mt-4 mb-5 justify-content-center">
      <div class="col-md-8">

        <div class="accordion" id="accordionPanelsStayOpenExample">
 
          @for ($i = 0; $i < count($ajuda); $i++)
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-{{$i}}" aria-expanded="true" aria-controls="panelsStayOpen-collapse-{{$i}}">
                {{ $ajuda[$i]['pergunta'] }}
              </button>
            </h2>
            <div id="panelsStayOpen-collapse-{{$i}}" class="accordion-collapse collapse">
              <div class="accordion-body">
                {!! $ajuda[$i]['resposta'] !!}
              </div>
            </div>
          </div>
          @endfor

      </div>
    </div>
    <!--<div class="col-md-4">

      <div class="accordion" id="accordionPanelsStayOpenExample">
        
        @for ($i = 4; $i <= 6; $i++)
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-{{$i}}" aria-expanded="true" aria-controls="panelsStayOpen-collapse-{{$i}}">
                Accordion Item #1
              </button>
            </h2>
            <div id="panelsStayOpen-collapse-{{$i}}" class="accordion-collapse collapse">
              <div class="accordion-body">
                <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
              </div>
            </div>
          </div>
        @endfor

      </div>-->

    </div>
  </div>
  </div>

</x-front-layout>