@extends('layouts.app')

@section('content')
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">


                    <div class="container mt-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h1 class="text-primary">Lista de Produtos</h1>
                            <a href="{{ route('products.create') }}" class="btn btn-success">+ Adicionar Produto</a>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success text-center">{{ session('success') }}</div>
                        @endif

                        <div class="card shadow-lg p-4">
                            <table class="table table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>ID</th>
                                        <th>Cod</th>
                                        <th>Título</th>

                                        <th>Categoria</th>
                                        <th>Imagem</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>{{ $product->cod_produto }}</td>
                                            <td>{{ $product->title }}</td>

                                            <td>{{ $product->category->name }}</td>
                                            <td>
                                                @if ($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" width="50"
                                                        class="img-thumbnail">
                                                @else
                                                    <span class="text-muted">Sem imagem</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="btn btn-warning btn-sm">Editar</a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
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
        </div>
    </div>
@endsection
