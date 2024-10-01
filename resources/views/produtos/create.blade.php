@extends('layouts.app')

@section('title', 'Adicionar Produtos')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="mb-4">Criar Produto</h1>
            <hr>
            <form id="produtoForm" action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" class="form-control" maxlength="50" name="nome" placeholder="Digite o nome do produto" required>
                </div>

                <div class="form-group mb-3">
                    <label for="categoria" class="form-label">Categoria:</label>
                    <select id="categoria" name="categoria" class="form-control" required>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->nome }}">{{ $categoria->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <input type="text" class="form-control" maxlength="250" name="descricao"
                        placeholder="Adicione a descrição do produto" required>
                </div>

                <div class="form-group mb-3">
                    <label for="tipos" class="form-label">Variações:</label>
                    <div id="tipos-container">
                        <div class="row mb-2">
                            <div class="col">
                                <input type="text" class="form-control" maxlength="50" name="tipos[0][nome]"
                                    placeholder="Tipo" required>
                            </div>
                            <div class="col">
                                <input type="number" step="0.01" maxlength="10" class="form-control" name="tipos[0][preco]"
                                    placeholder="Preço" required>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn mt-2" style="background-color: #35221B; color: #f1f1f1" onclick="addTipo()">Adicionar Variação</button>
                </div>

                <div class="form-group mb-3">
                    <label for="produto_arquivo" class="form-label">Adicionar foto principal</label>
                    <input type="file" name="produto_arquivo" id="produto_arquivo" class="form-control" required>
                </div>

                <button type="submit" class="btn" style="background-color: #35221B; color: #f1f1f1">Criar Produto</button>
            </form>
        </div>
    </div>
</div>

<script>
    let tipoIndex = 1;

    function addTipo() {
        const container = document.getElementById('tipos-container');
        const row = document.createElement('div');
        row.className = 'row mb-2';
        row.innerHTML = `
            <div class="col">
                <input type="text" class="form-control" name="tipos[${tipoIndex}][nome]" placeholder="Tipo (e.g., Grande)" required>
            </div>
            <div class="col">
                <input type="number" step="0.01" class="form-control" name="tipos[${tipoIndex}][preco]" placeholder="Preço (e.g., 6.00)" required>
            </div>`;
        container.appendChild(row);
        tipoIndex++;
    }
</script>
@endsection