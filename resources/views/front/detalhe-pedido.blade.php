<x-front-layout>
    <x-front-header />

    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Detalhes do Pedido #{{ $pedido->id }}</h2>
                    <a href="{{ route('colaborador.pedidos') }}" class="btn btn-secondary">Voltar</a>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Informações do Pedido</h5>
                        <p><strong>Data:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Registro:</strong> {{ $pedido->registro_pedido }}</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Produtos do Pedido</h5>
                        
                        <div class="table-responsive">
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
                                    @foreach($produtos as $produto)
                                    <tr>
                                        <td>{{ $produto->produto }}</td>
                                        <td>{{ $produto->qtd }}</td>
                                        <td>R$ {{ number_format($produto->price, 2, ',', '.') }}</td>
                                        <td>R$ {{ number_format($produto->price * $produto->qtd, 2, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total do Pedido:</strong></td>
                                        <td>
                                            <strong>
                                                R$ {{ number_format($produtos->sum(function($produto) {
                                                    return $produto->price * $produto->qtd;
                                                }), 2, ',', '.') }}
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
</x-front-layout>