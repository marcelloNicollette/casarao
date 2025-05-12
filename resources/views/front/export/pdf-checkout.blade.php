<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
    h3, h4, h5, h6 {
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
  </style>
</head>

<body>
  <h1>Minha sacola</h1>

  <table>
    @for($i = 0; $i < count($content); $i++) 
      @if ($i % 2==0) 
      <tr class="row">
      @endif
        <td class="col-6">
          <h2><span>{{ $content[$i]['id'] }}</span> {{ $content[$i]['title'] }}</h2>
          <div class="row">
            <img src="{{ $content[$i]['image'] }}" />
            <div class="content">
              <h3>{{ $content[$i]['id_color'] }}</h3>
              <h4>{{ $content[$i]['color'] }}</h4>
              <h5>{{ $content[$i]['tamanho'] }}</h5>
              <h5>{{ $content[$i]['grade'] }}</h5>
              <h5>Mês: {{ $content[$i]['month'] }}</h5>
              <h5>Quantidade: {{ $content[$i]['qnt'] }}</h5>
            </div>
          </div>
          <div class="row">
            {{ $content[$i]['descricao_mkt'] }}
          </div>
        </td>
      @if ($i % 2!=0)
      </tr>
      @endif
    @endfor

    @if (count($content) % 2 != 0)
    </tr>
    @endif
  </table>
</body>

</html>