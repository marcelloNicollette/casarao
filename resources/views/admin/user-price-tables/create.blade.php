@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Criar Novo Vinculo de Usuário e Tabela</h1>

        <form action="{{ route('user-price-tables.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="user_id">Usuário</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="price_table_id">Tabela de Preço</label>
                <select name="price_table_id" id="price_table_id" class="form-control" required>
                    @foreach ($priceTables as $priceTable)
                        <option value="{{ $priceTable->id }}">{{ $priceTable->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
@endsection
