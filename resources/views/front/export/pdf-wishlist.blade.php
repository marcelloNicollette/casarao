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
      min-height: 250px;
    }
    td.col-6 {
      width: 50%;
    }
    h1 {
      text-align: center;
      background: #f40000;
      padding: 1rem 1rem .5rem 1rem;
      border-radius: 90px;
      width: 200px;
      height: 50px;
      color: #FFF;
    }
    h2 {
      font-size: 1.4rem;
      color: #f40000;
    }
    h2 span {
      border: 1px solid #f40000;
      border-radius: 50%;
      padding: 5px;
      color: #f40000;
    }
    h3, h4, h5, h6 {
      margin: 0 0 5px 0;
    }
    .img {
      width: 180px;
      float: left;
    }
    .content {
      margin-left: 5px;
      width: 130px;
      float: left;
    }
    footer {
                position: fixed; 
                bottom: -60px; 
                left: -50px; 
                right: -30px;
                height: 70px; 
                font-size: 20px !important;
                background-color: #f40000;
                color: white;
                text-align: right;
                line-height: 50px;
                width: 112%;
                padding-right: 400px;
            }
  </style>
</head>

<body>
  <div style="position:relative; margin: 0; width:100%; align:center; text-align:center; top:-50px; left:-50px;">
    <img src="data:image/svg+xml;base64,<?php echo base64_encode(file_get_contents(base_path('public/images/img_capa-800px.jpg'))); ?>" style="width: 700px; margin:0;">
  </div>
  <div style="page-break-before: always;"></div>
  <div style="background: #FFF;">
    <h1>{{ $title }}</h1>
    <h3>Total produtos: {{ count($content) }} </h3>
    <table>
      @for($i = 0; $i < count($content); $i++) 
        @if ($i % 2==0) 
        <tr class="row">
        @endif
          <td class="col-6">
            <div class="row">
              <img class="img" src="{{ $content[$i]['imagem'] }}" />
              <div class="content">
                <h2><span>{{ $content[$i]['codigo_4'] }}</span></h2>
                <h2>{{ $content[$i]['nome_do_modelo'] }}</h2>
                <h3>{{ $content[$i]['codigo_cor'] }}</h3>
                <h4>{{ $content[$i]['descricao_da_cor'] }}</h4>
                <h5>{{ $content[$i]['categoria'] }} / {{ $content[$i]['subcategoria'] }}</h5>
              </div>
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
    <footer>
      <img src="data:image/svg+xml;base64,<?php echo base64_encode(file_get_contents(base_path('public/images/logo.png'))); ?>" style="padding-top:10px;height:35px;" alt="Logo Havaianas" class="logo">
    </footer>
  </div>
</body>

</html>