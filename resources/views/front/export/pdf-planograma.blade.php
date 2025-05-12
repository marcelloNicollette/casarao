<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Havaianas Showroom') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


  <style>
    * {
      font-family: Arial, Helvetica, sans-serif;
    }

    body {
      margin: 0;
    }

    table {
      width: 100%;
    }

    .row {
      width: 100%;
      margin-bottom: 20px;
      clear: both;
      float: none;
      min-height: 200px;
    }

    td.col-6 {
      width: 50%;
    }

    h1 {
      text-align: center;
    }

    h2 {
      float: left;
      clear: both;
      font-size: 1.4rem;
    }

    h2 span {
      border: 1px solid #0f5132;
      border-radius: 50%;
      padding: 5px;
      color: #0f5132;
    }

    h3,
    h4,
    h5,
    h6 {
      margin: 0 0 5px 0;
    }

    img {
      width: 180px;
      float: left;
    }

    .content {
      margin-left: 5px;
      width: 130px;
      float: left;
    }

    .planograma {
      background: #e0e0e0;
      border-radius: 40px;
      overflow: hidden;
    }

    .planograma tr {
      width: 100%;
      clear: both;
      height: 130px;
    }

    .planograma tr td {
      padding: 1rem;
      /* background: url("{{ url('/assets/images/gancho.png') }}") no-repeat center top; */
      background-size: auto 40px;
      text-align: center;
      height: 110px;
    }

    .planograma tr td img {
      width: 100px;
      height: auto;
      float: none;
    }
  </style>
</head>

<body>
  <h1>Planograma</h1>

  @if ($planograma['tipo'] == 'vip-4-ganchos')
  <table class="planograma {{ $planograma['tipo'] }}">
    @for($i = 0; $i < 4; $i++) <tr class="row">
      <td>
        @if (isset($planograma['produtos'][$i]['imagem']))
        <img src="{{ $planograma['produtos'][$i]['imagem'] }}" />
        @endif
      </td>
      </tr>
      @endfor
  </table>
  @endif

  @if ($planograma['tipo'] == 'vip-10-ganchos')
  <table class="planograma {{ $planograma['tipo'] }}">
    <tr>
      @for ($i = 0; $i < 10; $i++) <td>
        @if (isset($planograma['produtos'][$i]['imagem']))
        <img src="{{ $planograma['produtos'][$i]['imagem'] }}" />
        @endif
        </td>
        @if ($i % 2 != 0 && $i < 9) </tr>
    <tr>
      @endif
      @endfor
    </tr>
  </table>
  @endif

  @if ($planograma['tipo'] == 'vip-12-ganchos')
  <table class="planograma {{ $planograma['tipo'] }}">
    @for ($row = 0; $row < 4; $row++) <tr>
      @for ($col = 0; $col < 3; $col++) @php $index=($row * 3) + $col; @endphp <td>
        @if (isset($planograma['produtos'][$index]['imagem']))
        <img src="{{ $planograma['produtos'][$index]['imagem'] }}" alt="Imagem">
        @endif
        </td>
        @endfor
        </tr>
        @endfor
  </table>
  @endif

  @if ($planograma['tipo'] == 'vip-15-ganchos')
  <table class="planograma {{ $planograma['tipo'] }}">
    @for ($row = 0; $row < 5; $row++) <tr>
      @for ($col = 0; $col < 3; $col++) @php $index=($row * 3) + $col; @endphp <td>
        @if (isset($planograma['produtos'][$index]['imagem']))
        <img src="{{ $planograma['produtos'][$index]['imagem'] }}" alt="Imagem">
        @endif
        </td>
        @endfor
        </tr>
        @endfor
  </table>
  @endif

  @if ($planograma['tipo'] == 'vip-4-alturas')
  <table class="planograma {{ $planograma['tipo'] }}">
    @for ($row = 0; $row < 4; $row++) <tr>
      @for ($col = 0; $col < 5; $col++) @php $index=($row * 5) + $col; @endphp <td>
        @if (isset($planograma['produtos'][$index]['imagem']))
        <img src="{{ $planograma['produtos'][$index]['imagem'] }}" alt="Imagem">
        @endif
        </td>
        @endfor
        </tr>
        @endfor
  </table>
  @endif

  @if ($planograma['tipo'] == 'vip-20-ganchos')
  <table class="planograma {{ $planograma['tipo'] }}">
    @for ($row = 0; $row < 5; $row++) <tr>
      @for ($col = 0; $col < 4; $col++) @php $index=($row * 4) + $col; @endphp <td>
        @if (isset($planograma['produtos'][$index]['imagem']))
        <img src="{{ $planograma['produtos'][$index]['imagem'] }}" alt="Imagem">
        @endif
        </td>
        @endfor
        </tr>
        @endfor
  </table>
  @endif

  @if ($planograma['tipo'] == 'vip-25-ganchos' || $planograma['tipo'] == 'sem-display')
  <table class="planograma {{ $planograma['tipo'] }}">
    @for ($row = 0; $row < 5; $row++) <tr>
      @for ($col = 0; $col < 5; $col++)
      @php $index=($row * 5) + $col; @endphp <td>
        @if (isset($planograma['produtos'][$index]['imagem']))
        <img src="{{ $planograma['produtos'][$index]['imagem'] }}" alt="Imagem">
        @endif
        </td>
        @endfor
        </tr>
        @endfor
  </table>
  @endif


  @if ($planograma['tipo'] == 'premium-3-ganchos')
  <table class="planograma {{ $planograma['tipo'] }}">
    @for($i = 0; $i < 3; $i++) <tr class="row">
      <td>
        @if (isset($planograma['produtos'][$i]['imagem']))
        <img src="{{ $planograma['produtos'][$i]['imagem'] }}" />
        @endif
      </td>
      </tr>
      @endfor
  </table>
  @endif


  @if ($planograma['tipo'] == 'premium-9-ganchos')
  <table class="planograma {{ $planograma['tipo'] }}">
    @for ($row = 0; $row < 3; $row++) <tr>
      @for ($col = 0; $col < 3; $col++)
      @php $index=($row * 3) + $col; @endphp <td>
        @if (isset($planograma['produtos'][$index]['imagem']))
        <img src="{{ $planograma['produtos'][$index]['imagem'] }}" alt="Imagem">
        @endif
        </td>
        @endfor
        </tr>
        @endfor
  </table>
  @endif


  @if ($planograma['tipo'] == 'premium-15-ganchos')
  <table class="planograma {{ $planograma['tipo'] }}">
    @for ($row = 0; $row < 5; $row++) <tr>
      @for ($col = 0; $col < 3; $col++) @php $index=($row * 3) + $col; @endphp <td>
        @if (isset($planograma['produtos'][$index]['imagem']))
        <img src="{{ $planograma['produtos'][$index]['imagem'] }}" alt="Imagem">
        @endif
        </td>
        @endfor
        </tr>
        @endfor
  </table>
  @endif

  @if ($planograma['tipo'] == 'premium-15-x5x3-ganchos')
  <table class="planograma {{ $planograma['tipo'] }}">
    @for ($row = 0; $row < 3; $row++) <tr>
      @for ($col = 0; $col < 5; $col++)
      @php $index=($row * 3) + $col; @endphp <td>
        @if (isset($planograma['produtos'][$index]['imagem']))
        <img src="{{ $planograma['produtos'][$index]['imagem'] }}" alt="Imagem">
        @endif
        </td>
        @endfor
        </tr>
        @endfor
  </table>
  @endif

  <div style="page-break-before: always;"></div>

  <h1>{{ $title }}</h1>

  <table cellspacing="0" cellpadding="0" border="1">
    <tr>
      <td>Codigo 4</td>
      <td>Modelo</td>
      <td>Codigo Cor</td>
      <td>Cor</td>
      <td>Categoria</td>
      <td>SubCategoria</td>
    </tr>
    @for($i = 0; $i < count($content); $i++) 
    <tr>
        <td>{{ $content[$i]['codigo_4'] }}</td> 
        <td>{{ $content[$i]['nome_do_modelo'] }}</td>
        <td>{{ $content[$i]['codigo_cor'] }}</td>
        <td>{{ $content[$i]['descricao_da_cor'] }}</td>
        <td>{{ $content[$i]['categoria'] }}</td>
        <td>{{ $content[$i]['subcategoria'] }}</td>
      
    </tr>
      
      @endfor

  </table>

  

</body>

</html>