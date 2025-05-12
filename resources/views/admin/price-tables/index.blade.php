@extends('layouts.app')

@section('content')
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">


                    <div class="container mt-5">
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h1 class="display-6 mb-1">Tabelas de Preços</h1>
                                        <p class="text-muted mb-0">Lista de todas as tabelas de preços cadastradas</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('price-tables.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Nova Tabela
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($priceTables as $priceTable)
                                    <tr>
                                        <td>{{ $priceTable->name }}</td>
                                        <td>{{ $priceTable->description }}</td>
                                        <td>
                                            <a href="{{ route('price-tables.show', $priceTable) }}"
                                                class="btn btn-info">Ver</a>
                                            <a href="{{ route('price-tables.edit', $priceTable) }}"
                                                class="btn btn-warning">Editar</a>
                                            <form action="{{ route('price-tables.destroy', $priceTable) }}" method="POST"
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
                </div>
            </div>
        </div>
    @endsection
