@extends('layouts.app')

@section('content')
<div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <div class="container mt-5">
                    <div class="card shadow-lg p-4">
                        <h1 class="text-center text-primary mb-4">Adicionar Produto</h1>

                        @if(session('success'))
                            <div class="alert alert-success text-center">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold">Título</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Descrição</label>
                                <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="linhaproduto_id" class="form-label fw-bold">Linha do Produto</label>
                                <select name="linhaproduto_id" class="form-select" required>
                                    <option value="" disabled selected>Selecione uma linha</option>
                                    @foreach($lines as $line)
                                        <option value="{{ $line->id }}">{{ $line->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label fw-bold">Categoria do produto</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="" disabled selected>Selecione uma categoria</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label fw-bold">Imagem</label>
                                <input type="file" name="image" class="form-control">
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-success">Adicionar Produto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
