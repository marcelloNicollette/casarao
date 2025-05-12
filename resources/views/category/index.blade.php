@extends('layouts.app')

@section('content')

<div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">


                <div class="container mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="text-primary">Categoria(s) cadastradas</h1>
                        <a href="{{ route('categories.create') }}" class="btn btn-success">+ Adicionar Categoria</a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    @endif

                    <div class="card shadow-lg p-4">
                        <table class="table table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Categoria</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
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
