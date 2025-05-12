@extends('layouts.app')

@section('content')
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="container mt-5">
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <h1 class="display-6 mb-1">Pedido #{{ $pedido->id }}</h1>
                                        <p class="text-muted mb-0">Detalhes do pedido</p>
                                    </div>
                                    <a href="{{ route('admin.pedidos.index') }}" class="btn btn-secondary">Voltar</a>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">Informações do Cliente</h5>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p class="mb-1"><strong>Nome:</strong></p>
                                                        <h6 class="text-dark">
                                                            {{ $pedido->cliente ? $pedido->cliente->razao_social : 'Cliente não encontrado' }}
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="mb-1"><strong>Email:</strong></p>
                                                        <h6 class="text-dark">
                                                            {{ $pedido->cliente ? $pedido->cliente->email : 'N/A' }}</h6>
                                                    </div>
                                                    <!--<div class="col-md-4">
                                                                        <p class="mb-1"><strong>Telefone:</strong></p>
                                                                        <h6 class="text-dark">
                                                                            {{ $pedido->cliente && $pedido->cliente->telefone ? $pedido->cliente->telefone : 'N/A' }}
                                                                        </h6>
                                                                    </div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Informações do Colaborador</h5>
                                        <p><strong>Colaborador:</strong>
                                            {{ $pedido->user ? $pedido->user->name : 'Não encontrado' }}</p>
                                        <p><strong>Email:</strong>
                                            {{ $pedido->user ? $pedido->user->email : 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Informações do Pedido</h5>
                                        <p><strong>Data:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                                        <p><strong>Registro:</strong> {{ $pedido->registro_pedido }}</p>
                                    </div>
                                </div>

                                <div class="table-responsive mt-4">
                                    <h5><b>Produtos do Pedido</b></h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Produto</th>
                                                <th>Quantidade</th>
                                                <th>Preço Unitário</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pedido->produtos as $produto)
                                                <tr>
                                                    <td>{{ $produto->produto }}</td>
                                                    <td>{{ $produto->qtd }}</td>
                                                    <td>R$ {{ number_format($produto->price, 2, ',', '.') }}</td>
                                                    <td>R$
                                                        {{ number_format($produto->price * $produto->qtd, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-end"><strong>Total do Pedido:</strong></td>
                                                <td>
                                                    <strong>
                                                        R$
                                                        {{ number_format(
                                                            $pedido->produtos->sum(function ($produto) {
                                                                return $produto->price * $produto->qtd;
                                                            }),
                                                            2,
                                                            ',',
                                                            '.',
                                                        ) }}
                                                    </strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
