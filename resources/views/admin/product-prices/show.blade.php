@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalhes do Preço do Produto</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $productPrice->product->title }}</h5>
                <p class="card-text">
                    <strong>Tabela de Preço:</strong> {{ $productPrice->priceTable->name }}<br>
                    <strong>Preço:</strong> R$ {{ number_format($productPrice->price, 2, ',', '.') }}
                </p>
                <a href="{{ route('product-prices.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </div>
@endsection
