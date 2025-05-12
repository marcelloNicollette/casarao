<x-front-layout>
  <style>
    .w-20{
      width: 24%
    }
    .flex-container {
    justify-content: center;
  }
  </style>
  <section class="section-inicio min-vh-100">
    <div class="container">
      <div class="d-flex flex-column align-items-center">
        <img src="{{ asset('/images/bg-topo-v2.jpg') }}" class="img-fluid" alt="" />
        <img src="{{ asset('/images/logo-red.png') }}" class="logo my-3" alt="" />

        <div class="w-100 mt-5 gap-1 text-center">
          <a href="inicio/atacado_nacional" class="w-20 btn btn-primary fw-bold text-white btn-lg">Atacado Nacional</a>
          <a href="inicio/atacado_regional" class="w-20 btn btn-primary fw-bold text-white btn-lg">Atacado Regional</a>
          <a href="inicio/distribuidor" class="w-20 btn btn-primary fw-bold text-white btn-lg">Distribuidor</a>
          <a href="inicio/atacado_especializado" class="w-20 btn btn-primary fw-bold text-white btn-lg">Atacado Especializado</a>
        </div>
        <div class="w-100 mt-3 gap-1 text-center">
          <a href="inicio/as" class="w-20 btn btn-primary fw-bold text-white btn-lg">AS</a>
          <a href="inicio/c_c" class="w-20 btn btn-primary fw-bold text-white btn-lg">C&C</a>
          <a href="inicio/departamento" class="w-20 btn btn-primary fw-bold text-white btn-lg">Departamento</a>
          <a href="inicio/calcadista" class="w-20 btn btn-primary fw-bold text-white btn-lg">Calçadista</a>
        </div>
        <div class="w-100 mt-3 gap-1 text-center">
          <a href="inicio/fora_de_linha" class="w-20  btn btn-primary opacity-50 fw-bold text-white btn-lg">Fora de linha</a>
          
        </div>
      </div>
    </div>
  </section>
</x-front-layout>
