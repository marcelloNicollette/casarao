<x-front-layout>
    <x-front-header />

    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Meus Pedidos</h2>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            @if($pedidos->count() > 0)
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID do Pedido</th>
                                            <th>Data</th>
                                            <th>Registro</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pedidos as $pedido)
                                            <tr>
                                                <td>#{{ $pedido->id }}</td>
                                                <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                                                <td>{{ $pedido->registro_pedido }}</td>
                                                <td>
                                                    <a href="{{ route('colaborador.pedidos.show', $pedido->id) }}"
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
                                    <p class="text-muted mb-0">Não consta registro(s) de pedidos.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
