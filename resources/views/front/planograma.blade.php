<x-front-layout>
  <x-slot:addclass>bg-white</x-slot:addclass>
  <x-front-header />

  <section id="planograma">
    <div class="container my-4">
      <div class="row">
        <div class="col-md-6">
          <h1 class="text-primary fw-bold">Display Virtual</h1>
          <p class="text-primary">aqui você cria sua vitrine com os produtos favoritados :)</p>
          <p class="text-primary">arraste os itens para criar seu display</p>

          <h5 class="text-primary fw-bold">Favoritos <a href="{{ url('/ajuda') }}" class="btn-duvida btn btn-primary rounded-circle btn-sm p-1 text-white fw-bold">?</a></h5>

          <div class="row mb-4">
            <div class="col-6">
              <select class="select-favorites-planograma form-select form-select-sm mt-1" aria-label="Selecione a lista de favoritos">
                <option value="" selected>Lista de favoritos</option>
              </select>
              <div id="favoritos-planograma" class="list-favorites d-grid gap-2 mt-2">
                <p class="text-primary text-center">Nenhum produto adicionado</p>
              </div>

              <form id="planograma_form" target="_blank" method="POST" action="{{ url('/export/pdf/planograma') }}" style="display: none">
              </form>
            </div>
            <div class="col-6">
              <div class="list-buttons d-grid gap-2">
                @if(Session::get('segmentacao') == 'varejo')
                  <button type="button" class="btn btn-primary text-white fw-bold " data-tipo="premium-3-ganchos" data-items="3">Premium 3 Ganchos</button>
                  <button type="button" class="btn btn-primary text-white fw-bold " data-tipo="premium-9-ganchos" data-items="9">Premium 9 Ganchos</button>
                  <button type="button" class="btn btn-primary text-white fw-bold" data-tipo="premium-15-ganchos" data-items="15">Premium 15 Ganchos 3x5</button>
                  <button type="button" class="btn btn-primary text-white fw-bold" data-tipo="premium-15-x5x3-ganchos" data-items="15">Premium 15 Ganchos 5x3</button>
                @else
                  <button type="button" class="btn btn-primary text-white fw-bold " data-tipo="vip-4-ganchos" data-items="4">VIP 4 Ganchos</button>
                  <button type="button" class="btn btn-primary text-white fw-bold" data-tipo="vip-10-ganchos" data-items="10">VIP 10 Ganchos</button>
                  <button type="button" class="btn btn-primary text-white fw-bold" data-tipo="vip-12-ganchos" data-items="12">VIP 12 Ganchos 3x4</button>
                  <button type="button" class="btn btn-primary text-white fw-bold" data-tipo="vip-15-ganchos" data-items="15">VIP 15 Ganchos 3x5</button>
                  <button type="button" class="btn btn-primary text-white fw-bold" data-tipo="vip-4-alturas" data-items="20">VIP 4 Alturas</button>
                  <button type="button" class="btn btn-primary text-white fw-bold" data-tipo="vip-20-ganchos" data-items="20">VIP 20 Ganchos</button>
                  <button type="button" class="btn btn-primary text-white fw-bold" data-tipo="vip-25-ganchos" data-items="25">VIP 25 Ganchos 5x5</button>
                  <button type="button" class="btn btn-primary text-white fw-bold" data-tipo="sem-display" data-items="50">Sem display - gôndola *</button>
                @endif
                
                
              </div>

              <ul class="icons list-unstyled mt-4">
                <li> 
                  <a href="#" class="icon icon-xls gerarPlanilhaPlanograma">gerar planilha</a>
                </li>
                <li>
                  <a href="#" id="gerar_pdf_planograma" class="icon icon-pdf">gerar pdf</a>
                </li>
              </ul>

              <a href="{{ url('/ajuda') }}" class="btn btn-primary text-white fw-bold btn-sm">Precisa de ajuda?</a>

              <a href="#" id="clearPlanograma" class="btn btn-secondary text-white fw-bold btn-sm clearPlanograma">Limpar Display</a>

              <p class="mt-5">* Limite máximo de 50 produtos</p>
            </div>

              

          </div>
        </div>


        <div class="col-md-6">
          <div class="show-planograma rounded-5 d-flex flex-column">
            <div class="header-planograma bg-primary p-2 d-flex align-items-center justify-content-center">
              <img src="{{ url('/images/logo.png') }}" class="img-logo" alt="logo-havaianas" />
            </div>

            <div id="content-planograma" class="body-planograma d-grid gap-2 vip-4-ganchos">
              <div class="item-planograma" data-index="0"></div>
              <div class="item-planograma" data-index="1"></div>
              <div class="item-planograma" data-index="2"></div>
              <div class="item-planograma" data-index="3"></div>
            </div>
          </div>
        </div>


      </div>
    </div>
  </section>
</x-front-layout>