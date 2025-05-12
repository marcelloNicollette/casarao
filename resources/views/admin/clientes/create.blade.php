@extends('layouts.app')

@section('content')
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="display-6 mb-1">Novo Cliente</h1>
                                <p class="text-muted mb-0">Cadastre um novo cliente no sistema</p>
                            </div>
                            <div>
                                <a href="{{ route('clientes.index') }}" class="btn btn-light">
                                    <i class="fas fa-arrow-left me-2"></i>Voltar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('clientes.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="razao_social" class="form-label">Razão Social</label>
                            <input type="text" class="form-control" id="razao_social" name="razao_social" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cnpj" class="form-label">CNPJ</label>
                            <input type="text" class="form-control" id="cnpj" name="cnpj" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="colaborador_id" class="form-label">Colaborador</label>
                            <select class="form-select" id="colaborador_id" name="colaborador_id" required>
                                @foreach ($colaboradores as $colaborador)
                                    <option value="{{ $colaborador->id }}">{{ $colaborador->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="price_tables_id" class="form-label">Colaborador</label>
                            <select class="form-select" id="price_tables_id" name="price_tables_id" required>
                                @foreach ($price_tables as $price_table)
                                    <option value="{{ $price_table->id }}">{{ $price_table->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Cadastrar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
