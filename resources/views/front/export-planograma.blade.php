<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Havaianas Showroom') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/scss/front.scss', 'resources/js/front.js'])
</head>

<body>
  <!-- Page Content -->
  <main class="min-vh-100 {{ @$addclass }}">
    <section id="planograma">
      <div class="container my-4">
        <div class="row">
          <div class="col-md-6">
            <h1 class="text-primary fw-bold">Planograma</h1>
            <p class="text-primary">aqui você cria sua vitrine com os produtos favoritados :)</p>
            <p class="text-primary">arraste os itens para criar seu planograma</p>
  
            <h5 class="text-primary fw-bold">Favoritos <a href="{{ url('/ajuda') }}" class="btn-duvida btn btn-primary rounded-circle btn-sm p-1 text-white fw-bold">?</a></h5>
  
            <div class="row mb-4">
              <div class="col-6">
                <div id="favoritos-planograma" class="list-favorites d-grid gap-2">
                  <p class="text-primary text-center">Nenhum produto adicionado</p>
                </div>
              </div>
              <div class="col-6">
                <div class="list-buttons d-grid gap-2">
                  <button type="button" class="btn btn-primary text-white fw-bold active" data-tipo="vip-4-ganchos" data-items="4">VIP 4 Ganchos</button>
                  <button type="button" class="btn btn-primary text-white fw-bold" data-tipo="vip-10-ganchos" data-items="10">VIP 10 Ganchos</button>
                  <button type="button" class="btn btn-primary text-white fw-bold" data-tipo="vip-12-ganchos" data-items="12">VIP 12 Ganchos 3x4</button>
                  <button type="button" class="btn btn-primary text-white fw-bold" data-tipo="vip-15-ganchos" data-items="15">VIP 15 Ganchos 3x5</button>
                  <button type="button" class="btn btn-primary text-white fw-bold" data-tipo="vip-4-alturas" data-items="20">VIP 4 Alturas</button>
                  <button type="button" class="btn btn-primary text-white fw-bold" data-tipo="vip-20-ganchos" data-items="20">VIP 20 Ganchos</button>
                  <button type="button" class="btn btn-primary text-white fw-bold" data-tipo="vip-25-ganchos" data-items="25">VIP 25 Ganchos 5x5</button>
                  <button type="button" class="btn btn-primary text-white fw-bold" data-tipo="sem-display" data-items="25">Sem display</button>
                </div>
  
                <ul class="icons list-unstyled mt-4">
                  <li>
                    <a href="#" class="icon icon-xls">gerar planilha</a>
                  </li>
                  <li>
                    <a href="#" class="icon icon-pdf">gerar pdf</a>
                  </li>
                </ul>
  
                <a href="{{ url('/ajuda') }}" class="btn btn-primary text-white fw-bold btn-sm">Precisa de ajuda?</a>
              </div>
            </div>
          </div>
  
  
          <div class="col-md-6">
            <div class="show-planograma rounded-5 d-flex flex-column">
              <div class="header-planograma bg-primary p-2 d-flex align-items-center justify-content-center">
                <img width="200px" border="1" src="{{ public_path("/images/logo.png") }}" class="img-logo" alt="logo-havaianas" />
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
  </main>

  <div class="toast-container position-fixed bottom-0 end-0 p-2"></div>
</body>

</html>