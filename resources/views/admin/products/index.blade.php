@extends('layouts.app')

@section('content')
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="container mt-5">
                        <div class="card border-0 shadow-sm mb-5">
                            <div class="card-header bg-light py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="h4 mb-0">Lista de Produtos</h2>
                                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Novo Produto
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Nome</th>
                                                <th>Codigo</th>
                                                <th>Descrição</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products->sortBy('title') as $product)
                                                <tr>
                                                    <td>{{ $product->title }}</td>
                                                    <td>{{ $product->cod_produto }}</td>
                                                    <td>{{ Str::limit($product->description, 50) }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('products.edit', $product->id) }}"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('products.destroy', $product->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                    onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
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

@push('styles')
    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .card-header {
            background-color: #f8f9fa !important;
        }

        .btn-group .btn {
            margin-right: 5px;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>
@endpush
