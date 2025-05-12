@extends('layouts.app')

@section('content')
<div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <div class="container mt-5">
                    <div class="card shadow-lg p-4">
                        <h1 class="text-center text-primary mb-4">Editar Linha</h1>
                        
                        @if(session('success'))
                            <div class="alert alert-success text-center">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('product-line.update', $line->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Linha do Produto</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $line->name) }}" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('product-line.index') }}" class="btn btn-secondary">Cancelar</a>
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
