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
                                        <h1 class="display-6 mb-1">{{ $priceTable->name }}</h1>
                                        <p class="text-muted mb-0">{{ $priceTable->description }}</p>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary me-2" onclick="toggleDuplicateForm()">
                                            <i class="fas fa-copy me-2"></i>Duplicar
                                        </button>
                                        <button type="button" class="btn btn-success me-2" onclick="toggleImportForm()">
                                            <i class="fas fa-file-import me-2"></i>Importar
                                        </button>
                                        <a href="{{ route('price-tables.export', $priceTable) }}" class="btn btn-warning">
                                            <i class="fas fa-file-excel me-2"></i>Exportar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Formulário de Duplicação -->
                        <div class="mb-4 card border-primary" id="duplicateForm" style="display: none;">
                            <div class="card-header bg-primary text-white">
                                <h3 class="mb-0"><i class="fas fa-copy me-2"></i>Duplicar Tabela de Preços</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('price-tables.duplicate', $priceTable) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nome da Nova Tabela</label>
                                        <input type="text" name="name" id="name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Descrição</label>
                                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-copy me-2"></i>Duplicar Tabela
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Formulário de Importação -->
                        <div class="mb-4 card border-success" id="importForm" style="display: none;">
                            <div class="card-header bg-success text-white">
                                <h3 class="mb-0"><i class="fas fa-file-import me-2"></i>Importar Tabela de Preços</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('price-tables.import', $priceTable) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Arquivo CSV</label>
                                        <input type="file" name="file" id="file" class="form-control" required>
                                        <div class="form-text">
                                            O arquivo CSV deve conter duas colunas: Nome do Produto e Preço
                                        </div>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <i class="fas fa-file-import me-2"></i>Importar Tabela
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Preço</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($priceTable->products as $product)
                                    <tr>
                                        <td>{{ $product->title }}</td>
                                        <td>R$ {{ number_format($product->pivot->price, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <a href="{{ route('price-tables.index') }}" class="btn btn-secondary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function toggleDuplicateForm() {
        const duplicateForm = document.getElementById('duplicateForm');
        const importForm = document.getElementById('importForm');
        
        if (importForm.style.display === 'block') {
            importForm.style.display = 'none';
        }
        duplicateForm.style.display = duplicateForm.style.display === 'none' ? 'block' : 'none';
    }

    function toggleImportForm() {
        const duplicateForm = document.getElementById('duplicateForm');
        const importForm = document.getElementById('importForm');
        
        if (duplicateForm.style.display === 'block') {
            duplicateForm.style.display = 'none';
        }
        importForm.style.display = importForm.style.display === 'none' ? 'block' : 'none';
    }
</script>
