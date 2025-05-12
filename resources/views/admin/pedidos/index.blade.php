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
                                        <h1 class="display-6 mb-1">Pedidos</h1>
                                        <p class="text-muted mb-0">Lista de todos os pedidos realizados</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    @if ($pedidos->count() > 0)
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Data</th>
                                                    <th>Cliente</th>
                                                    <th>Colaborador</th>
                                                    <th>Total</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pedidos as $pedido)
                                                    <tr>
                                                        <td>#{{ $pedido->id }}</td>
                                                        <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                                                        <td>{{ $pedido->cliente ? $pedido->cliente->razao_social : 'Cliente não encontrado' }}
                                                        </td>
                                                        <td>{{ $pedido->user->name }}</td>
                                                        <td>
                                                            R$
                                                            {{ number_format(
                                                                $pedido->produtos->sum(function ($produto) {
                                                                    return $produto->price * $produto->qtd;
                                                                }),
                                                                2,
                                                                ',',
                                                                '.',
                                                            ) }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('admin.pedidos.show', $pedido->id) }}"
                                                                class="btn btn-primary btn-sm">
                                                                Ver Detalhes
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="text-center py-4">
                                            <p class="text-muted mb-0">Não há pedidos registrados.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
