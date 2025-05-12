@extends('layouts.app')

@section('content')
<div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <div class="container mt-5">
                    <div class="card border-0 shadow-sm mb-5">
                        <div class="card-header bg-light py-3">
                            <h2 class="h4 mb-0">Criar Nova Tabela de Preços</h2>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('price-tables.store') }}" method="POST">
                                @csrf
                                
                                <div class="row g-3 mb-4">
                                    <div class="col-md-8">
                                        <div class="form-floating">
                                            <input type="text" name="name" id="name" class="form-control" required placeholder="Nome da Tabela">
                                            <label for="name">Nome da Tabela</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" role="switch" value="1" checked>
                                            <label class="form-check-label" for="is_active">Tabela Ativa</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="form-floating">
                                        <textarea name="description" id="description" class="form-control" style="height: 100px" placeholder="Descrição"></textarea>
                                        <label for="description">Descrição</label>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-header bg-light py-3">
                                        <h5 class="mb-0">Produtos e Preços</h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Produto</th>
                                                        <th>Preço (R$)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($products->sortBy('title') as $product)
                                                    <tr>
                                                        <td>{{ $product->title }}</td>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-text">R$</span>
                                                                <input type="number" name="prices[]" class="form-control price-input" step="0.01" min="0" value="0.00">
                                                                <input type="hidden" name="products[]" value="{{ $product->id }}">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-2"></i>Criar Tabela
                                    </button>
                                </div>
                            </form>
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
    .price-input {
        max-width: 150px;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    .card-header {
        background-color: #f8f9fa !important;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.price-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.select();
            });
            
            input.addEventListener('blur', function() {
                if(this.value) {
                    this.value = parseFloat(this.value).toFixed(2);
                }
            });
        });
    });
</script>
@endpush
