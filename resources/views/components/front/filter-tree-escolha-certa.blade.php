@php
$array_familia = json_decode($familia);
//dd($array_familia);
foreach ($array_familia as $key => $f) {
  $array_f[$key] = strtoupper($f->familia);
}

if(isset($categorias) && !empty($categorias)){
  $array_categorias = json_decode($categorias);
  //dd($array_familia);
  foreach ($array_categorias as $key => $f) {
    $array_c[$key] = strtoupper($f->categoria);
  }
}else{
  $array_c = [];
}


$filters = [
(object) [
"category" => "Categorias",
"subcategories" => $array_c
],
(object) [
"category" => "Size Extension",
"subcategories" => [
"SIM",
"NÃO",
]
],/*
(object) [
"category" => "Segmentação",
"subcategories" => [
"AS/DIST",
"ATACADO",
"VAREJO",
]
],
(object) [
"category" => "Drop",
"subcategories" => [
"DROP 1",
"DROP 2",
"DROP 3",
]
],*/
(object) [
"category" => "Família",
"subcategories" => $array_f
],
(object) [
"category" => "Top 5",
"subcategories" => [
"Sim",
"Não",
]
],
/*(object) [
"category" => "Canal",
"subcategories" => [
"AS/Distribuidor",
"Atacado",
"Varejo"
]
]*/
];
//dd($filters);
$i = 0;
@endphp

<div class="filter-tree d-flex gap-4 flex-column my-4">
  <h4 class="fw-bold text-primary">filtros</h4>

  <div class="tree-view">
    <ul>
      @foreach ($filters as $filter)
      <li>
        <input type="checkbox" class="form-check-input" id="category-{{ $i }}" value="{{ $filter->category }}">
        <label for="category-{{ $i }}">{{ $filter->category }}</label>
        
        @if (!empty($filter->subcategories))
        <span class="expand-button"></span>
        <ul class="subcategories">
          @foreach ($filter->subcategories as $subcategory)
          <li>
            <input type="checkbox" class="form-check-input" id="subcategory-{{ $i }}" value="{{ $subcategory }}">
            <label for="subcategory-{{ $i }}">{{ $subcategory }}</label>
          </li>

          @php $i++ @endphp
          @endforeach
        </ul>
        @endif

      </li>

      @php $i++ @endphp
      @endforeach
    </ul>
  </div>
</div>