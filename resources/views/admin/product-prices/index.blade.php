@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Preços de Produtos</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Tabela de Preço</th>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productPrices as $productPrice)
                    <tr>
                        <td>{{ $productPrice->priceTable->name }}</td>
                        <td>{{ $productPrice->product->title }}</td>
                        <td>R$ {{ number_format($productPrice->price, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('product-prices.show', $productPrice) }}" class="btn btn-info">Ver</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
