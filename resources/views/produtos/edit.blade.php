@extends('layouts.app')

@section('title', 'Editar Produtos')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="mb-4">Editar Produto</h1>
            <hr>
            <form action="{{ route('produtos.update', ['id' => $produtos->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" class="form-control" name="nome" maxlength="50" value="{{ old('nome', $produtos->nome) }}"
                        placeholder="Digite o nome do produto" required>
                </div>

                <div class="form-group mb-3">
                    <label for="categoria" class="form-label">Categoria:</label>
                    <select id="categoria" name="categoria" class="form-control" required>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->nome }}" {{ old('categoria', $produtos->categoria) == $categoria->nome ? 'selected' : '' }}>
                                {{ $categoria->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="tipos" class="form-label">Variações:</label>
                    <div id="tipos-container">
                        @foreach($produtos->variacoes as $index => $variacao)
                            <div class="row mb-2">
                                <div class="col">
                                    <input type="text" class="form-control" maxlength="1=50" name="tipos[{{ $index }}][nome]"
                                        value="{{ old('tipos.' . $index . '.nome', $variacao->nome) }}"
                                        placeholder="Tipo" required>
                                </div>
                                <div class="col">
                                    <input type="number" step="0.01" maxlength="10" class="form-control" name="tipos[{{ $index }}][preco]"
                                        value="{{ old('tipos.' . $index . '.preco', $variacao->preco) }}"
                                        placeholder="Preço" required>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn mt-2" style="background-color: #35221B; color: #f1f1f1" onclick="addTipo()">Adicionar Variação</button>
                </div>

                <div class="form-group mb-3">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <input type="text" class="form-control" name="descricao"
                        value="{{ old('descricao', $produtos->descricao) }}"
                        placeholder="Adicione a descrição do produto" maxlength="250" required>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="produto_arquivo" class="form-label">Adicionar foto principal:</label>
                        <input type="file" name="produto_arquivo" id="produto_arquivo" class="form-control"
                            onchange="previewImage(1)">
                        <img id="preview1" src="{{ asset('storage/' . $produtos->produto_arquivo) }}"
                            class="img-thumbnail mt-2"
                            style="width: 200px; display: {{ $produtos->produto_arquivo ? 'block' : 'none' }};" />
                        <button type="button" class="btn btn-danger mt-2" onclick="removeImage(1)" id="remove1"
                            style="display: {{ $produtos->produto_arquivo ? 'inline-block' : 'none' }};">Remover</button>
                    </div>
                </div>

                <input type="hidden" name="produto_arquivo_removed" id="produto_arquivo_removed"
                    value="{{ $produtos->produto_arquivo }}">

                <div class="form-group">
                    <button type="submit" class="btn" style="background-color: #35221B; color: #f1f1f1">Salvar</button>
                    <a href="{{ route('produtos') }}" class="btn"
                        style="background-color: #35221B; color: #f1f1f1">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function addTipo() {
        const container = document.getElementById('tipos-container');
        const row = document.createElement('div');
        row.className = 'row mb-2';
        row.innerHTML = `
            <div class="col">
                <input type="text" class="form-control" name="tipos[][nome]" placeholder="Tipo (e.g., Grande)" required>
            </div>
            <div class="col">
                <input type="number" step="0.01" class="form-control" name="tipos[][preco]" placeholder="Preço (e.g., 6.00)" required>
            </div>`;
        container.appendChild(row);
    }

    function previewImage(imageNumber) {
        const fileInput = document.getElementById('produto_arquivo' + imageNumber);
        const preview = document.getElementById('preview' + imageNumber);
        const removeBtn = document.getElementById('remove' + imageNumber);
        const imageGroup = document.getElementById('imagem' + imageNumber + '-group');

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                removeBtn.style.display = 'inline-block';
                imageGroup.style.display = 'block';
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
</script>

@endsection