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
                                        <h1 class="display-6 mb-1">Editar Cliente</h1>
                                        <p class="text-muted mb-0">Atualize as informações do cliente</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('clientes.update', $cliente) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="razao_social" class="form-label">Razão Social</label>
                                        <input type="text" class="form-control" id="razao_social" name="razao_social"
                                            value="{{ $cliente->razao_social }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $cliente->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cnpj" class="form-label">CNPJ</label>
                                        <input type="text" class="form-control" id="cnpj" name="cnpj"
                                            value="{{ $cliente->cnpj }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="colaborador_id" class="form-label">Colaborador</label>
                                        <select class="form-select" id="colaborador_id" name="colaborador_id" required>
                                            @foreach($colaboradores as $colaborador)
                                                <option value="{{ $colaborador->id }}" {{ $cliente->colaborador_id == $colaborador->id ? 'selected' : '' }}>
                                                    {{ $colaborador->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price_tables_id" class="form-label">Tabela de Preço</label>
                                        <select class="form-select" id="price_tables_id" name="price_tables_id" required>
                                            @foreach($priceTables as $priceTable)
                                                <option value="{{ $priceTable->id }}" {{ $cliente->price_tables_id == $priceTable->id ? 'selected' : '' }}>
                                                    {{ $priceTable->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="1" {{ $cliente->status ? 'selected' : '' }}>Ativo</option>
                                            <option value="0" {{ !$cliente->status ? 'selected' : '' }}>Inativo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Atualizar</button>
                                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection