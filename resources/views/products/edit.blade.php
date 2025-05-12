@extends('layouts.app')

@section('content')
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="container mt-5">
                        <div class="card shadow-lg p-4">
                            <h1 class="text-center text-primary mb-4">Editar Produto</h1>

                            @if (session('success'))
                                <div class="alert alert-success text-center">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('products.update', $product->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="title" class="form-label fw-bold">Título</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', $product->title) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold">Descrição</label>
                                    <textarea name="description" class="form-control" rows="4" required>{{ old('description', $product->description) }}</textarea>
                                </div>

                                <!--<div class="mb-3">
                                        <label for="linhaproduto_id" class="form-label fw-bold">Linha do Produto</label>
                                        <select name="linhaproduto_id" class="form-select" required>
                                            @foreach ($lines as $line)
    <option value="{{ $line->id }}" {{ $product->linhaproduto_id == $line->id ? 'selected' : '' }}>
                                                    {{ $line->name }}
                                                </option>
    @endforeach
                                        </select>
                                    </div>-->

                                <div class="mb-3">
                                    <label for="category_id" class="form-label fw-bold">Categoria do Produto</label>
                                    <select name="category_id" class="form-select" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="unidade" class="form-label fw-bold">Unidade do Produto</label>
                                    <input type="text" name="unidade" class="form-control"
                                        value="{{ old('unidade', $product->unidade) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="validade" class="form-label fw-bold">Validade do Produto</label>
                                    <input type="text" name="unidade" class="form-control"
                                        value="{{ old('validade', $product->validade) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="observacao" class="form-label fw-bold">Observação</label>
                                    <input type="text" name="observacao" class="form-control"
                                        value="{{ old('observacao', $product->observacao) }}" required>
                                </div>

                                <div class="mb-3 text-center">
                                    <label for="image" class="form-label fw-bold">Imagem Atual</label><br>
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="img-thumbnail mb-2"
                                            width="200">
                                    @else
                                        <p class="text-muted">Sem imagem</p>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label fw-bold">Nova Imagem (opcional)</label>
                                    <input type="file" name="image" class="form-control">
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
