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
                                        <h1 class="display-6 mb-1">Clientes</h1>
                                        <p class="text-muted mb-0">Lista de todos os clientes cadastrados</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Novo Cliente
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success text-center">{{ session('success') }}</div>
                        @endif
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Razão Social</th>
                                    <th>Email</th>
                                    <th>CNPJ</th>
                                    <th>Colaborador</th>
                                    <th>Tabela Preço</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientes as $cliente)
                                    <tr>
                                        <td>{{ $cliente->razao_social }}</td>
                                        <td>{{ $cliente->email }}</td>
                                        <td>{{ $cliente->cnpj }}</td>
                                        <td>{{ $cliente->colaborador->nome }}</td>
                                        <td>{{ $cliente->price_tables->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $cliente->status ? 'success' : 'danger' }}">
                                                {{ $cliente->status ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('clientes.destroy', $cliente) }}" method="POST"
                                                style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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
@endsection
