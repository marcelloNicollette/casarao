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
                                        <h1 class="display-6 mb-1">Colaboradores</h1>
                                        <p class="text-muted mb-0">Lista de todos os colaboradores cadastrados</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('colaboradores.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Novo Colaborador
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (session('error'))
                            <div class="alert alert-danger text-center">{{ session('error') }}</div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success text-center">{{ session('success') }}</div>
                        @endif
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>CPF</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($colaboradores as $colaborador)
                                    <tr>
                                        <td>{{ $colaborador->nome }}</td>
                                        <td>{{ $colaborador->email }}</td>
                                        <td>{{ $colaborador->cpf ?? 'Não informado' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $colaborador->status ? 'success' : 'danger' }}">
                                                {{ $colaborador->status ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('colaboradores.edit', $colaborador) }}"
                                                class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('colaboradores.destroy', $colaborador) }}" method="POST"
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
