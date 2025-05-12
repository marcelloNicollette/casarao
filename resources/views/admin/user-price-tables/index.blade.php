@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Vinculos de Usuários e Tabelas</h1>
        <a href="{{ route('user-price-tables.create') }}" class="btn btn-primary mb-3">Novo Vinculo</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Tabela de Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userPriceTables as $userPriceTable)
                    <tr>
                        <td>{{ $userPriceTable->user->name }}</td>
                        <td>{{ $userPriceTable->priceTable->name }}</td>
                        <td>
                            <a href="{{ route('user-price-tables.show', $userPriceTable) }}" class="btn btn-info">Ver</a>
                            <form action="{{ route('user-price-tables.destroy', $userPriceTable) }}" method="POST"
                                style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
