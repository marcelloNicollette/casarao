@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalhes do Vinculo</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $userPriceTable->user->name }}</h5>
                <p class="card-text">
                    <strong>Tabela de Preço:</strong> {{ $userPriceTable->priceTable->name }}<br>
                    <strong>Criado em:</strong> {{ $userPriceTable->created_at->format('d/m/Y H:i') }}
                </p>
                <a href="{{ route('user-price-tables.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </div>
@endsection
